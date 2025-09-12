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

use App\Model\MakeFontResult;
use fpdf\MakeFontException;
use PHPUnit\Framework\TestCase;

class MakeFontResultTest extends TestCase
{
    public function testSplitContent(): void
    {
        $expected = ['Line1', 'Line2'];
        $actual = new MakeFontResult(content: \implode('<br>', $expected));
        self::assertSame($expected, $actual->splitContent());
    }

    public function testWithException(): void
    {
        $exception = new MakeFontException('fake');
        $actual = new MakeFontResult(exception: $exception);
        self::assertFalse($actual->isSuccess());
        self::assertSame('fake', $actual->getMessage());
    }

    public function testWithNullValues(): void
    {
        $actual = new MakeFontResult();
        self::assertNull($actual->fileName);
        self::assertNull($actual->content);
        self::assertNull($actual->exception);
        self::assertNull($actual->getMessage());
        self::assertFalse($actual->isSuccess());
        self::assertSame([], $actual->splitContent());
    }
}
