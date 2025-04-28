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

use fpdf\FontMaker;
use fpdf\Translator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();
    $services->defaults()
        ->autowire()
        ->autoconfigure();
    $services->set(FontMaker::class, FontMaker::class);

    $path = __DIR__ . '/../src/';
    $services->load('App\\', $path . '*')
        ->exclude($path . 'Kernel.php');

    $container->parameters()
        ->set('supported_locales', \implode('|', Translator::ALLOWED_LOCALES));
};
