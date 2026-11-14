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

use fpdf\Translator;

return App::config([
    'framework' => [
        'secret' => '%env(APP_SECRET)%',
        'csrf_protection' => true,
        'default_locale' => Translator::DEFAULT_LOCALE,
        'enabled_locales' => Translator::ALLOWED_LOCALES,

        'session' => [
            'name' => 'MAKE_FONT_SESSION_ID',
            'enabled' => true,
        ],

        'form' => [
            'csrf_protection' => [
                'enabled' => true,
                'field_name' => 'csrf_token',
            ],
        ],

        'property_info' => [
            'with_constructor_extractor' => true,
        ],
    ],

    'when@prod' => [
        'framework' => [
            'router' => [
                'strict_requirements' => null,
            ],
        ],
    ],

    'when@test' => [
        'framework' => [
            'test' => true,
            'session' => [
                'storage_factory_id' => 'session.storage.factory.mock_file',
            ],
        ],
    ],
]);
