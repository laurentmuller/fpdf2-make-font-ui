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

use fpdf\FontMaker;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class MakeFontQuery
{
    /**
     * @param ?UploadedFile $fontFile the font file (.ttf, .otf, .pfb)
     * @param ?UploadedFile $afmFile  the AFM file for a Type 1 PostScript font (.pfb).
     * @param string        $encoding the font encoding
     * @param bool          $embed    the embedded font
     * @param bool          $subset   the sub-setting characters
     */
    public function __construct(
        #[Assert\NotNull(message: 'query.fontFile')]
        public ?UploadedFile $fontFile = null,
        public ?UploadedFile $afmFile = null,
        #[Assert\NotBlank]
        #[Assert\Choice(callback: [FontMaker::class, 'getEncodings'], message: 'query.encoding')]
        public string $encoding = FontMaker::DEFAULT_ENCODING,
        public bool $embed = true,
        public bool $subset = true
    ) {
    }

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
