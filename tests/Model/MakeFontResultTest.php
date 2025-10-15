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
use fpdf\Log;
use fpdf\LogLevel;
use fpdf\MakeFontException;
use PHPUnit\Framework\TestCase;

class MakeFontResultTest extends TestCase
{
    public function testIsLogs(): void
    {
        $result = new MakeFontResult();
        $actual = $result->isLogs();
        self::assertFalse($actual);

        $logs = [
            new Log('Info', LogLevel::INFO),
            new Log('Warning', LogLevel::WARNING),
        ];
        $result = new MakeFontResult(logs: $logs);
        $actual = $result->isLogs();
        self::assertTrue($actual);
    }

    public function testMaxLevelDefault(): void
    {
        $result = new MakeFontResult();
        $actual = $result->getMaxLevel();
        self::assertSame(LogLevel::INFO, $actual);
    }

    public function testMaxLevelError(): void
    {
        $logs = [
            new Log('Info', LogLevel::INFO),
            new Log('Warning', LogLevel::WARNING),
            new Log('Error', LogLevel::ERROR),
        ];
        $result = new MakeFontResult(logs: $logs);
        $actual = $result->getMaxLevel();
        self::assertSame(LogLevel::ERROR, $actual);
    }

    public function testMaxLevelWarning(): void
    {
        $logs = [
            new Log('Info', LogLevel::INFO),
            new Log('Warning', LogLevel::WARNING),
        ];
        $result = new MakeFontResult(logs: $logs);
        $actual = $result->getMaxLevel();
        self::assertSame(LogLevel::WARNING, $actual);
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
        self::assertEmpty($actual->logs);
        self::assertNull($actual->exception);
        self::assertNull($actual->getMessage());
        self::assertFalse($actual->isSuccess());
    }
}
