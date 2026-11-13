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

namespace Symfony\Component\Routing\Loader\Configurator;

return Routes::config([
    'controllers' => [
        'resource' => 'routing.controllers',
        'schemes' => 'http',
    ],
    'when@dev' => [
        ' _error' => [
            'resource' => '@FrameworkBundle/Resources/config/routing/errors.php',
            'prefix' => '/_error',
        ],
        'web_profiler_wdt' => [
            'resource' => '@WebProfilerBundle/Resources/config/routing/wdt.php',
            'prefix' => '/_wdt',
        ],
        'web_profiler_profiler' => [
            'resource' => '@WebProfilerBundle/Resources/config/routing/profiler.php',
            'prefix' => '/_profiler',
        ],
    ],
    'when@prod' => [
        'controllers' => [
            'resource' => 'routing.controllers',
            'schemes' => 'https',
        ],
    ],
]);
