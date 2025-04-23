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

namespace App\Tests\Service;

use App\Service\NonceService;
use PHPUnit\Framework\TestCase;

class NonceServiceTest extends TestCase
{
    private NonceService $service;

    /**
     * @throws \Exception
     */
    #[\Override]
    protected function setUp(): void
    {
        $this->service = new NonceService();
    }

    public function testLength32(): void
    {
        $nonce = $this->service->getNonce(32);
        self::assertSame(64, \strlen($nonce));
    }

    public function testLengthDefault(): void
    {
        $nonce = $this->service->getNonce();
        self::assertSame(32, \strlen($nonce));
    }
}
