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

final class NonceServiceTest extends TestCase
{
    public function testLength(): void
    {
        $service = new NonceService();
        $cspNonce = $service->getCspNonce();
        self::assertSame(32, \strlen($cspNonce));
    }
}
