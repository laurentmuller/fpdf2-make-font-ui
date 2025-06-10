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
use Twig\Extension\AttributeExtension;
use Twig\RuntimeLoader\RuntimeLoaderInterface;

class NonceServiceTest extends IntegrationTestCase implements RuntimeLoaderInterface
{
    private NonceService $service;

    #[\Override]
    protected function setUp(): void
    {
        $this->service = new NonceService();
    }

    #[\Override]
    public function load(string $class): ?object
    {
        if (NonceService::class === $class) {
            return $this->service;
        }

        return null;
    }

    #[\Override]
    protected function getExtensions(): array
    {
        return [new AttributeExtension(NonceService::class)];
    }

    #[\Override]
    protected function getFixturesDir(): string
    {
        return __DIR__ . '/../Fixtures/NonceService';
    }

    #[\Override]
    protected function getRuntimeLoaders(): array
    {
        return [$this];
    }
}
