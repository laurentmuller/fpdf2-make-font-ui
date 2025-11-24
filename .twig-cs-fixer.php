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
use TwigCsFixer\File\Finder;
use TwigCsFixer\Rules\Delimiter\EndBlockNameRule;
use TwigCsFixer\Ruleset\Ruleset;
use TwigCsFixer\Standard\TwigCsFixer;

$cacheFile = __DIR__ . '/var/cache/twig-cs-fixer/.twig-cs-fixer.cache';

$ruleset = new Ruleset();
$ruleset->addStandard(new TwigCsFixer());
$ruleset->addRule(new EndBlockNameRule());

$finder = Finder::create()
    ->in('templates');

$config = new Config();
$config->allowNonFixableRules()
    ->setCacheFile($cacheFile)
    ->setRuleset($ruleset)
    ->setFinder($finder);

return $config;
