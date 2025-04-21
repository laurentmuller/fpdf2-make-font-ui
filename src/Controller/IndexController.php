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

use App\Form\MakeFontQueryType;
use App\Model\MakeFontQuery;
use fpdf\FontMaker;
use fpdf\MakeFontException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    public function __construct(
        #[Autowire('%kernel.project_dir%')]
        private readonly string $projectDir,
        private readonly FontMaker $fontMaker,
    ) {
    }

    #[Route('/', name: 'index')]
    public function __invoke(Request $request): Response
    {
        $error = null;
        $content = null;

        $query = new MakeFontQuery();
        $form = $this->createForm(MakeFontQueryType::class, $query);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $afmFile = null;
            /** @phpstan-var UploadedFile $fontFile */
            $fontFile = $query->fontFile;
            $ext = $fontFile->getClientOriginalExtension();
            if ('pfb' === $ext) {
                $afmFile = $query->afmFile;
            }

            $targetPath = $this->getTargetPath();
            $this->cleanDirectory($targetPath);
            $fontFile = $this->moveUploadedFile($targetPath, $fontFile);
            $this->moveUploadedFile($targetPath, $afmFile);

            try {
                \chdir($targetPath);
                $fontFileName = $fontFile->getBasename();
                $baseName = \substr($fontFileName, 0, -3);
                $phpFile = $targetPath . '/' . $baseName . 'php';
                $compressedFile = $targetPath . '/' . $baseName . 'z';
                $content = $this->makeFont($fontFileName, $query);

                if (\is_file($compressedFile)) {
                    $zipFile = $targetPath . '/' . $baseName . '.zip';
                    $this->createZipFile(
                        $zipFile,
                        $phpFile,
                        $compressedFile
                    );

                    return $this->file($zipFile);
                }

                return $this->file($phpFile);
            } catch (MakeFontException $e) {
                $error = $e->getMessage();
            }
        }

        return $this->render('index.html.twig', [
            'form' => $form,
            'error' => $error,
            'content' => $content,
        ]);
    }

    private function cleanDirectory(string $directory): void
    {
        /** @phpstan-var string[] $files */
        $files = (array) \glob($directory . '/*.*');
        foreach ($files as $file) {
            \unlink($file);
        }
    }

    private function createZipFile(string $zipFile, string $phpFile, string $compressedFile): void
    {
        $zip = new \ZipArchive();
        $zip->open($zipFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
        $zip->addFile($phpFile);
        $zip->addFile($compressedFile);
        $zip->close();
    }

    private function getTargetPath(): string
    {
        return Path::join($this->projectDir, 'uploads');
    }

    private function makeFont(string $fontFileName, MakeFontQuery $query): ?string
    {
        try {
            \ob_start();
            $this->fontMaker->makeFont(
                $fontFileName,
                $query->encoding,
                $query->subset,
                $query->embed,
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
}
