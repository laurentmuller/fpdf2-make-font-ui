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

use App\Controller\LocaleController;
use Symfony\Config\FrameworkConfig;

return static function (FrameworkConfig $framework): void {
    $framework->secret('%env(APP_SECRET)%');

    $framework->session()
        ->name('MAKE_FONT_SESSION_ID')
        ->enabled(true);

    $framework->defaultLocale(LocaleController::LOCALE_EN)
        ->enabledLocales([LocaleController::LOCALE_EN, LocaleController::LOCALE_FR]);

    $framework->translator()
        ->defaultPath('%kernel.project_dir%/translations')
        ->fallbacks(LocaleController::LOCALE_EN);

    $framework->csrfProtection()
        ->enabled(true);
    $framework->form()
        ->csrfProtection()
        ->enabled(true)
        ->fieldName('csrf_token');
};
