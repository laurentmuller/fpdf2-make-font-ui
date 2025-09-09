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

use fpdf\MakeFontException;

class MakeFontResult
{
    /**
     * @param ?string            $fileName  the generated file (.json or .zip)
     * @param ?string            $content   the generated content
     * @param ?MakeFontException $exception the exception
     */
    public function __construct(
        public ?string $fileName = null,
        public ?string $content = null,
        public ?MakeFontException $exception = null,
    ) {
    }

    /**
     * @phpstan-assert-if-true !null $this->exception
     */
    public function getMessage(): ?string
    {
        return $this->exception?->getMessage();
    }

    /**
     * @phpstan-assert-if-true null $this->exception
     * @phpstan-assert-if-true string $this->fileName
     */
    public function isSuccess(): bool
    {
        return !$this->exception instanceof MakeFontException && null !== $this->fileName;
    }
}
