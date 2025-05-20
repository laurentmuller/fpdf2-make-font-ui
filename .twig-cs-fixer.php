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

use TwigCsFixer\Config\Config;

$cacheFile = __DIR__ . '/var/cache/twig-cs-fixer/.twig-cs-fixer.cache';

$config = new Config();
$config->allowNonFixableRules()
    ->setCacheFile($cacheFile)
    ->getFinder()
    ->in('templates');

return $config;
