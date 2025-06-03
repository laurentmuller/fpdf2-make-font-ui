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

use fpdf\Translator;
use Symfony\Config\FrameworkConfig;

return static function (FrameworkConfig $framework): void {
    $framework->secret('%env(APP_SECRET)%');

    $framework->session()
        ->name('MAKE_FONT_SESSION_ID')
        ->enabled(true);

    $framework->defaultLocale(Translator::DEFAULT_LOCALE)
        ->enabledLocales(Translator::ALLOWED_LOCALES);

    $framework->translator()
        ->defaultPath('%kernel.project_dir%/translations')
        ->fallbacks(Translator::DEFAULT_LOCALE);

    $framework->csrfProtection()
        ->enabled(true);

    $framework->form()
        ->csrfProtection()
        ->enabled(true)
        ->fieldName('csrf_token');

    $framework->propertyInfo()
        ->withConstructorExtractor(true);
};
