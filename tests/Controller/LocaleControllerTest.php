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

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class LocaleControllerTest extends WebTestCase
{
    public function testLocaleEnglish(): void
    {
        $client = self::createClient();
        $client->followRedirects();
        $client->request('GET', '/locale/en');
        self::assertResponseIsSuccessful();
        self::assertBrowserCookieValueSame('_locale', 'en');
    }

    public function testLocaleFrench(): void
    {
        $client = self::createClient();
        $client->followRedirects();
        $client->request('GET', '/locale/fr');
        self::assertResponseIsSuccessful();
        self::assertBrowserCookieValueSame('_locale', 'fr');
    }

    public function testLocaleInvalid(): void
    {
        $client = self::createClient();
        $client->followRedirects();
        $client->catchExceptions(false);
        $this->expectException(NotFoundHttpException::class);
        $client->request('GET', '/locale/fake');
        self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }
}
