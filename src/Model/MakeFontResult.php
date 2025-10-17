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

use fpdf\Log;
use fpdf\LogLevel;
use fpdf\MakeFontException;

readonly class MakeFontResult
{
    /**
     * @param ?string            $fileName  the generated file (.json or .zip)
     * @param Log[]              $logs      the log entries
     * @param ?MakeFontException $exception the exception
     */
    public function __construct(
        public ?string $fileName = null,
        public array $logs = [],
        public ?MakeFontException $exception = null,
    ) {
    }

    /**
     * Create an instance with the given exception.
     *
     * @param MakeFontException $exception the exception
     */
    public static function errorInstance(MakeFontException $exception): self
    {
        return new self(exception: $exception);
    }

    /**
     * Gets the log level that have the maximum value.
     */
    public function getMaxLevel(): LogLevel
    {
        if (!$this->isLogs()) {
            return LogLevel::INFO;
        }

        $levels = \array_map(static fn (Log $log): LogLevel => $log->level, $this->logs);

        return LogLevel::max(...$levels);
    }

    /**
     * @phpstan-assert-if-true !null $this->exception
     */
    public function getMessage(): ?string
    {
        return $this->exception?->getMessage();
    }

    /**
     * Gets the base name of this file or an empty string if none.
     */
    public function getName(): string
    {
        return \basename($this->fileName ?? '');
    }

    /**
     * @phpstan-assert-if-true non-empty-array<Log> $this->logs
     */
    public function isLogs(): bool
    {
        return [] !== $this->logs;
    }

    /**
     * @phpstan-assert-if-true null $this->exception
     * @phpstan-assert-if-true string $this->fileName
     */
    public function isSuccess(): bool
    {
        return !$this->exception instanceof MakeFontException && null !== $this->fileName;
    }

    /**
     * Create an instance with the given file name and log entries.
     *
     * @param string $fileName the generated file (.json or .zip)
     * @param Log[]  $logs     the log entries
     */
    public static function successInstance(string $fileName, array $logs): self
    {
        return new self(fileName: $fileName, logs: $logs);
    }
}
