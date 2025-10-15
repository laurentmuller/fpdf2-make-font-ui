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
use fpdf\Log;
use fpdf\MakeFontException;
use fpdf\Translator;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Service to parse a font query and generate a font result.
 */
readonly class MakeFontService
{
    public function __construct(
        private Filesystem $filesystem,
        private FontMaker $fontMaker,
        private TranslatorInterface $translator,
    ) {
    }

    public function generate(MakeFontQuery $query, string $locale = Translator::DEFAULT_LOCALE): MakeFontResult
    {
        $exception = null;
        $zipFile = null;
        $logs = [];

        $fontFile = $this->getFontFile($query);
        $afmFile = $this->getAfmFile($query);

        $targetPath = $this->getTargetPath();
        $this->registerShutdown($targetPath);

        $fontFile = $this->moveUploadedFile($targetPath, $fontFile);
        $this->moveUploadedFile($targetPath, $afmFile);

        $baseName = $this->getBaseName($fontFile);
        $jsonFile = $this->join($targetPath, $baseName, 'json');
        $compressedFile = $this->join($targetPath, $baseName, 'z');

        try {
            \chdir($targetPath);
            $this->updateLocale($locale);
            $logs = $this->makeFont($fontFile->getBasename(), $query->encoding, $query->embed, $query->subset);

            $zipFile = $jsonFile;
            if ($this->filesystem->exists($compressedFile)) {
                $zipFile = $this->join($targetPath, $baseName, 'zip');
                $this->createZipFile($zipFile, $jsonFile, $compressedFile);
                $logs[] = $this->getLogZip($zipFile);
            }
        } catch (MakeFontException $e) {
            $exception = $e;
        }

        return new MakeFontResult($zipFile, $logs, $exception);
    }

    private function createZipFile(string $zipFile, string $jsonFile, string $compressedFile): void
    {
        $zip = new \ZipArchive();
        $zip->open($zipFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        $zip->addFile($jsonFile, \basename($jsonFile));
        $zip->addFile($compressedFile, \basename($compressedFile));
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

    private function getLogZip(string $zipFile): Log
    {
        $name = \basename($zipFile);
        $message = $this->translator->trans('result.zip', ['%name%' => $name]);

        return new Log($message);
    }

    private function getTargetPath(): string
    {
        return Path::join(\sys_get_temp_dir(), \uniqid('font_'));
    }

    private function join(string $targetPath, string $baseName, string $extension): string
    {
        return Path::join($targetPath, $baseName . $extension);
    }

    /**
     * @return Log[]
     */
    private function makeFont(string $fontFile, string $encoding, bool $embed, bool $subset): array
    {
        $this->fontMaker->makeFont($fontFile, $encoding, $embed, $subset);

        return $this->fontMaker->getLogs();
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
