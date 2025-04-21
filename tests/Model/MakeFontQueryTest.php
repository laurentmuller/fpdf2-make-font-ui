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

namespace App\Tests\Model;

use App\Model\MakeFontQuery;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Path;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilderInterface;

class MakeFontQueryTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testValidateWithBoth(): void
    {
        $fontFile = $this->createUploadedFile('font.pfb');
        $afmFile = $this->createUploadedFile('font.afm');
        $query = new MakeFontQuery();
        $query->fontFile = $fontFile;
        $query->afmFile = $afmFile;
        $context = $this->createContext($query, false);
        $query->validate($context);
    }

    /**
     * @throws Exception
     */
    public function testValidateWithoutAFM(): void
    {
        $fontFile = $this->createUploadedFile('font.pfb');
        $query = new MakeFontQuery();
        $query->fontFile = $fontFile;
        $context = $this->createContext($query, true);
        $query->validate($context);
    }

    /**
     * @throws Exception
     */
    public function testValidateWithTTF(): void
    {
        $fontFile = $this->createUploadedFile('font.ttf');
        $query = new MakeFontQuery();
        $query->fontFile = $fontFile;
        $context = $this->createContext($query, false);
        $query->validate($context);
    }

    /**
     * @throws Exception
     */
    private function createContext(MakeFontQuery $query, bool $expectedViolation): MockObject&ExecutionContextInterface
    {
        $context = $this->createMock(ExecutionContextInterface::class);
        $context->expects(self::once())
            ->method('getObject')
            ->willReturn($query);

        if ($expectedViolation) {
            $violation = $this->createMock(ConstraintViolationBuilderInterface::class);
            $violation->expects(self::once())
                ->method('atPath')
                ->willReturn($violation);
            $violation->expects(self::once())
                ->method('addViolation');
            $context->expects(self::once())
                ->method('buildViolation')
                ->willReturn($violation);
        } else {
            $context
                ->expects(self::never())
                ->method('buildViolation');
        }

        return $context;
    }

    private function createUploadedFile(string $name): UploadedFile
    {
        return new UploadedFile(
            path: Path::join(__DIR__, $name),
            originalName: $name,
            error: \UPLOAD_ERR_INI_SIZE
        );
    }
}
