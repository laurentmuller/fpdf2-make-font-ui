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

final class MakeFontResultTest extends TestCase
{
    public function testErrorInstance(): void
    {
        $exception = new MakeFontException('fake');
        $actual = MakeFontResult::errorInstance($exception);
        self::assertFalse($actual->isSuccess());
        self::assertFalse($actual->isLogs());
        self::assertSame('fake', $actual->getMessage());
        self::assertNull($actual->fileName);
    }

    public function testIsLogs(): void
    {
        $result = MakeFontResult::successInstance('fake.json', []);
        $actual = $result->isLogs();
        self::assertFalse($actual);

        $logs = [
            new Log('Info', LogLevel::INFO),
            new Log('Warning', LogLevel::WARNING),
        ];
        $result = MakeFontResult::successInstance('fake.json', $logs);
        $actual = $result->isLogs();
        self::assertTrue($actual);
    }

    public function testMaxLevelDefault(): void
    {
        $result = MakeFontResult::successInstance('fake.json', []);
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
        $result = MakeFontResult::successInstance('fake.json', $logs);
        $actual = $result->getMaxLevel();
        self::assertSame(LogLevel::ERROR, $actual);
    }

    public function testMaxLevelWarning(): void
    {
        $logs = [
            new Log('Info', LogLevel::INFO),
            new Log('Warning', LogLevel::WARNING),
        ];
        $result = MakeFontResult::successInstance('fake.json', $logs);
        $actual = $result->getMaxLevel();
        self::assertSame(LogLevel::WARNING, $actual);
    }

    public function testName(): void
    {
        $exception = new MakeFontException('fake');
        $result = MakeFontResult::errorInstance($exception);
        $actual = $result->getName();
        self::assertSame('', $actual);

        $fileName = 'fake.json';
        $result = MakeFontResult::successInstance($fileName, []);
        $actual = $result->getName();
        self::assertSame($fileName, $actual);
    }

    public function testSuccessInstance(): void
    {
        $fileName = 'fake.json';
        $logs = [
            new Log('Info', LogLevel::INFO),
            new Log('Warning', LogLevel::WARNING),
        ];
        $actual = MakeFontResult::successInstance($fileName, $logs);
        self::assertTrue($actual->isSuccess());
        self::assertSame($fileName, $actual->fileName);
        self::assertSame($logs, $actual->logs);
        self::assertNull($actual->exception);
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
