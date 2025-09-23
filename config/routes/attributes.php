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

use App\Kernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $config): void {
    $config->import('../../src/Controller/', 'attribute');
    $config->import(Kernel::class, 'attribute');

    if ('dev' === $config->env()) {
        $config->import('@FrameworkBundle/Resources/config/routing/errors.php')
            ->prefix('/_error');
        $config->import('@WebProfilerBundle/Resources/config/routing/wdt.php')
            ->prefix('/_wdt');
        $config->import('@WebProfilerBundle/Resources/config/routing/profiler.php')
            ->prefix('/_profiler');
    }
};
