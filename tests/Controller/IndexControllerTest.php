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
use Symfony\Component\Filesystem\Path;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class IndexControllerTest extends WebTestCase
{
    public function testFontMakerException(): void
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

    public function testPostEmbed(): void
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

    public function testPostPFB(): void
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

    public function testPostTTF(): void
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

    private function createUploadedFile(string $name): UploadedFile
    {
        $directory = (string) \realpath(__DIR__ . '/../Fixtures/Fonts');

        return new UploadedFile(
            path: Path::join($directory, $name),
            originalName: $name
        );
    }

    /**
     * @param array<string, UploadedFile|string|bool|null> $values
     */
    private function submitForm(array $values): void
    {
        $client = static::createClient();
        $client->request('POST', '/');
        self::assertResponseIsSuccessful();
        $client->submitForm('Generate', $values);
    }
}
