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

namespace App\Service;

use App\Model\MakeFontQuery;
use App\Model\MakeFontResult;
use fpdf\FontMaker;
use fpdf\MakeFontException;
use fpdf\Translator;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

readonly class MakeFontService
{
    public function __construct(
        private Filesystem $filesystem,
        private FontMaker $fontMaker
    ) {
    }

    public function generate(MakeFontQuery $query, string $locale = Translator::DEFAULT_LOCALE): MakeFontResult
    {
        $content = null;
        $exception = null;
        $fileName = null;

        $fontFile = $this->getFontFile($query);
        $afmFile = $this->getAfmFile($query);

        $targetPath = $this->getTargetPath();
        $this->registerShutdown($targetPath);

        $fontFile = $this->moveUploadedFile($targetPath, $fontFile);
        $this->moveUploadedFile($targetPath, $afmFile);

        $baseName = $this->getBaseName($fontFile);
        $phpFile = Path::join($targetPath, $baseName . 'php');
        $compressedFile = Path::join($targetPath, $baseName . 'z');

        try {
            \chdir($targetPath);
            $this->updateLocale($locale);
            $content = $this->makeFont(
                $fontFile->getBasename(),
                $query->encoding,
                $query->embed,
                $query->subset
            );

            $fileName = $phpFile;
            if ($this->filesystem->exists($compressedFile)) {
                $fileName = Path::join($targetPath, $baseName . 'zip');
                $this->createZipFile(
                    $fileName,
                    $phpFile,
                    $compressedFile
                );
            }
        } catch (MakeFontException $e) {
            $exception = $e;
        }

        return new MakeFontResult(
            $fileName,
            $content,
            $exception,
        );
    }

    private function createZipFile(string $zipFile, string $phpFile, string $compressedFile): void
    {
        $zip = new \ZipArchive();
        $zip->open($zipFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        $zip->addFile($phpFile);
        $zip->addFile($compressedFile);
        $zip->close();
    }

    private function getAfmFile(MakeFontQuery $query): ?UploadedFile
    {
        $ext = $query->fontFile?->getClientOriginalExtension();

        return 'pfb' === $ext ? $query->afmFile : null;
    }

    private function getBaseName(File $file): string
    {
        return $file->getBasename($file->getExtension());
    }

    private function getFontFile(MakeFontQuery $query): UploadedFile
    {
        /** @phpstan-var UploadedFile */
        return $query->fontFile;
    }

    private function getTargetPath(): string
    {
        return Path::join(\sys_get_temp_dir(), \uniqid('font_'));
    }

    private function makeFont(
        string $fontFile,
        string $encoding,
        bool $embed,
        bool $subset
    ): ?string {
        try {
            \ob_start();
            $this->fontMaker->makeFont(
                $fontFile,
                $encoding,
                $embed,
                $subset
            );
            $content = (string) \ob_get_contents();

            return '' === $content ? null : $content;
        } finally {
            \ob_end_clean();
        }
    }

    /**
     * @phpstan-return ($file is null ? null : File)
     */
    private function moveUploadedFile(string $directory, ?UploadedFile $file): ?File
    {
        if ($file instanceof UploadedFile) {
            return $file->move($directory, $file->getClientOriginalName());
        }

        return null;
    }

    private function registerShutdown(string $path): void
    {
        \register_shutdown_function(fn () => $this->filesystem->remove($path));
    }

    private function updateLocale(string $locale): void
    {
        $this->fontMaker->setLocale($locale);
    }
}
