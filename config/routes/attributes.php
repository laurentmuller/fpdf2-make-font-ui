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

return static function (RoutingConfigurator $routing): void {
    $routing->import('../../src/Controller/', 'attribute');
    $routing->import(Kernel::class, 'attribute');

    if ('dev' === $routing->env()) {
        $routing->import('@FrameworkBundle/Resources/config/routing/errors.xml')
            ->prefix('/_error');
        $routing->import('@WebProfilerBundle/Resources/config/routing/wdt.xml')
            ->prefix('/_wdt');
        $routing->import('@WebProfilerBundle/Resources/config/routing/profiler.xml')
            ->prefix('/_profiler');
    }
};
