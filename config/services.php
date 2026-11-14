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

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use fpdf\FontMaker;
use fpdf\Translator;

$path = __DIR__ . '/../src/';

return App::config([
    'parameters' => [
        'supported_locales' => \implode('|', Translator::ALLOWED_LOCALES),
    ],
    'services' => [
        FontMaker::class => [FontMaker::class],
        'App\\' => [
            'resource' => $path . '*/*',
            'exclude' => [
                $path . 'Kernel.php',
            ],
        ],
    ],
]);
