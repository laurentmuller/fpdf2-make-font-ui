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
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Attribute\Route;

class LocaleController extends AbstractController
{
    public const LOCALE_EN = 'en';
    public const LOCALE_FR = 'fr';

    #[Route('/locale/{locale}', name: 'switch_locale', requirements: ['locale' => self::LOCALE_EN . '|' . self::LOCALE_FR])]
    public function __invoke(string $locale, Request $request, RequestStack $requestStack): RedirectResponse
    {
        $session = $requestStack->getSession();
        $session->set('_locale', $locale);
        $url = $request->headers->get('referer') ?? '/';

        return $this->redirect($url);
    }
}
