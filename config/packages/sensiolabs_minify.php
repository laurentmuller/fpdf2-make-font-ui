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

return App::config([
    'sensiolabs_minify' => [
        'asset_mapper' => [
            'ignore_paths' => ['*.min.js', '*.min.css'],
            'ignore_vendor' => false,
        ],
        'minify' => [
            'download_binary' => true,
        ],
    ],
    'when@test' => [
        'sensiolabs_minify' => [
            'asset_mapper' => [
                'enabled' => false,
            ],
        ],
    ],
]);
