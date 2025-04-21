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

class LocaleControllerTest extends WebTestCase
{
    public function testLocaleEnglish(): void
    {
        $client = static::createClient();
        $client->followRedirects();
        $client->request('GET', '/locale/en');
        self::assertResponseIsSuccessful();
        $locale = $client->getRequest()
            ->getSession()
            ->get('_locale');
        self::assertSame('en', $locale);
    }

    public function testLocaleFrench(): void
    {
        $client = static::createClient();
        $client->followRedirects();
        $client->request('GET', '/locale/fr');
        self::assertResponseIsSuccessful();
        $locale = $client->getRequest()
            ->getSession()
            ->get('_locale');
        self::assertSame('fr', $locale);
    }

    public function testLocaleInvalid(): void
    {
        $client = static::createClient();
        $client->followRedirects();
        $client->request('GET', '/locale/fake');
        self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }
}
