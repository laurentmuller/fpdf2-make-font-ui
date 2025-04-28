<?php

/*
 * This file is part of the 'fpdf2-make-font-ui' package.
 *
 * For the license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author bibi.nu <bibi@bibi.nu>
 */

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class LocaleController extends AbstractController
{
    public const LOCALE_KEY = '_locale';

    #[Route(
        path: '/locale/{locale}',
        name: 'switch_locale',
        requirements: ['locale' => '%supported_locales%']
    )]
    public function __invoke(string $locale, Request $request): RedirectResponse
    {
        $request->getSession()->set(self::LOCALE_KEY, $locale);

        return $this->redirectToRoute(IndexController::ROUTE_NAME);
    }
}
