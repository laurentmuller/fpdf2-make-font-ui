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
        $fieldValues = [
            'data[fontFile]' => $this->createUploadedFile('otto_header.ttf'),
            'data[afmFile]' => null,
            'data[encoding]' => 'cp1252',
            'data[embed]' => false,
            'data[subset]' => false,
        ];
        $client = static::createClient();
        $client->request('POST', '/');
        self::assertResponseIsSuccessful();
        $client->submitForm('Generate', $fieldValues);
    }

    public function testPostPFB(): void
    {
        $fieldValues = [
            'data[fontFile]' => $this->createUploadedFile('FontType1.pfb'),
            'data[afmFile]' => $this->createUploadedFile('FontType1.afm'),
            'data[encoding]' => 'cp1252',
            'data[embed]' => false,
            'data[subset]' => false,
        ];

        $client = static::createClient();
        $client->request('POST', '/');
        self::assertResponseIsSuccessful();
        $client->submitForm('Generate', $fieldValues);
    }

    public function testPostTTF(): void
    {
        $fieldValues = [
            'data[fontFile]' => $this->createUploadedFile('helvetica.ttf'),
            'data[afmFile]' => null,
            'data[encoding]' => 'cp1252',
            'data[embed]' => false,
            'data[subset]' => true,
        ];

        $client = static::createClient();
        $client->request('POST', '/');
        self::assertResponseIsSuccessful();
        $client->submitForm('Generate', $fieldValues);
    }

    private function createUploadedFile(string $name): UploadedFile
    {
        $directory = (string) \realpath(__DIR__ . '/../Fixtures/Fonts');

        return new UploadedFile(
            path: Path::join($directory, $name),
            originalName: $name
        );
    }
}
