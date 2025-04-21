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

namespace App\Tests\Twig;

use App\Service\NonceService;
use App\Twig\NonceExtension;
use PHPUnit\Framework\MockObject\Exception;

class NonceExtensionTest extends IntegrationTestCase
{
    /**
     * @throws Exception
     */
    #[\Override]
    protected function getExtensions(): array
    {
        $service = $this->createMock(NonceService::class);
        $service->method('getNonce')
            ->willReturn('nonce');
        $extension = new NonceExtension($service);

        return [$extension];
    }

    #[\Override]
    protected function getFixturesDir(): string
    {
        return __DIR__ . '/../Fixtures/NonceExtension';
    }
}
