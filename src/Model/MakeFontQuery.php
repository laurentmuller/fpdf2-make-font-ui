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

namespace App\Model;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class MakeFontQuery
{
    /**
     * The AFM file for a Type 1 PostScript font.
     */
    public ?UploadedFile $afmFile = null;

    /**
     * The embedded font.
     */
    public bool $embed = true;

    /**
     * The font encoding.
     */
    #[Assert\NotBlank]
    public string $encoding = 'cp1252';

    /**
     * The font file.
     */
    #[Assert\NotNull(message: 'query.fontFile')]
    public ?UploadedFile $fontFile = null;

    /**
     * The sub-setting characters.
     */
    public bool $subset = true;

    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context): void
    {
        /** @var MakeFontQuery $object */
        $object = $context->getObject();
        $fontFile = $object->fontFile;
        $ext = $fontFile?->getClientOriginalExtension();
        if ('pfb' !== $ext || null !== $object->afmFile) {
            return;
        }
        $context->buildViolation('query.afmFile')
            ->atPath('afmFile')
            ->addViolation();
    }
}
