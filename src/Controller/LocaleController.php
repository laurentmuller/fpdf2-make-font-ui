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
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class LocaleController extends AbstractController
{
    public const LOCALE_KEY = '_locale';

    #[Route(
        path: '/locale/{locale}',
        name: 'switch_locale',
        requirements: ['locale' => '%supported_locales%'],
        methods: Request::METHOD_GET
    )]
    public function __invoke(string $locale): RedirectResponse
    {
        $response = $this->redirectToRoute(IndexController::ROUTE_NAME);
        $response->headers->setCookie($this->createCookie($locale));

        return $response;
    }

    public function createCookie(string $locale): Cookie
    {
        return Cookie::create(self::LOCALE_KEY)
            ->withExpires(new \DateTime('+1 year'))
            ->withValue($locale)
            ->withSecure();
    }
}
