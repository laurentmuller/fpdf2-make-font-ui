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

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionFactory;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class IndexControllerTest extends WebTestCase
{
    public function testDownloadWithContent(): void
    {
        $client = static::createClient();
        $session = $this->getSession($client);
        $session->set('file_name', 'font.ttf');
        $session->set('file_content', 'content');
        $session->save();
        $client->request(Request::METHOD_GET, '/download');
        self::assertResponseStatusCodeSame(Response::HTTP_OK);
        self::assertResponseIsSuccessful();
    }

    public function testDownloadWithoutContent(): void
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, '/download');
        self::assertResponseStatusCodeSame(Response::HTTP_FOUND);
        self::assertResponseRedirects('/');
    }

    public function testIndexEmbed(): void
    {
        $values = [
            'fontFile' => $this->createUploadedFile('helvetica.ttf'),
            'afmFile' => null,
            'encoding' => 'cp1252',
            'embed' => true,
            'subset' => true,
        ];
        $this->submitForm($values);
    }

    public function testIndexFontPFB(): void
    {
        $values = [
            'fontFile' => $this->createUploadedFile('FontType1.pfb'),
            'afmFile' => $this->createUploadedFile('FontType1.afm'),
            'encoding' => 'cp1252',
            'embed' => false,
            'subset' => false,
        ];
        $this->submitForm($values);
    }

    public function testIndexFontTTF(): void
    {
        $values = [
            'fontFile' => $this->createUploadedFile('helvetica.ttf'),
            'afmFile' => null,
            'encoding' => 'cp1252',
            'embed' => false,
            'subset' => true,
        ];
        $this->submitForm($values);
    }

    public function testIndexThrowException(): void
    {
        $values = [
            'fontFile' => $this->createUploadedFile('otto_header.ttf'),
            'afmFile' => null,
            'encoding' => 'cp1252',
            'embed' => false,
            'subset' => false,
        ];
        $this->submitForm($values);
    }

    private function createUploadedFile(string $name): UploadedFile
    {
        $directory = (string) \realpath(__DIR__ . '/../Fixtures/Fonts');
        $path = Path::join($directory, $name);

        return new UploadedFile(
            path: $path,
            originalName: $name
        );
    }

    private function getSession(KernelBrowser $client): SessionInterface
    {
        /** @phpstan-var SessionFactory $factory */
        $factory = static::getContainer()->get('session.factory');
        $session = $factory->createSession();
        $cookieJar = $client->getCookieJar();

        $cookie = $cookieJar->get('MOCKSESSID');
        if ($cookie instanceof Cookie) {
            $session->setId($cookie->getValue());
            $session->start();

            return $session;
        }

        $session->start();
        $session->save();
        $cookie = new Cookie(
            name: $session->getName(),
            value: $session->getId(),
            domain: 'localhost',
        );
        $cookieJar->set($cookie);

        return $session;
    }

    /**
     * @param array<string, UploadedFile|string|bool|null> $values
     */
    private function submitForm(array $values): void
    {
        $client = static::createClient();
        $client->request(Request::METHOD_POST, '/');
        self::assertResponseStatusCodeSame(Response::HTTP_OK);
        self::assertResponseIsSuccessful();
        $client->submitForm('Generate', $values);
    }
}
