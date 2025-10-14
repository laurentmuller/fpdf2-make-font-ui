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

use Rector\CodingStyle\Rector\ArrowFunction\StaticArrowFunctionRector;
use Rector\CodingStyle\Rector\Closure\StaticClosureRector;
use Rector\Config\RectorConfig;
use Rector\Php83\Rector\ClassMethod\AddOverrideAttributeToOverriddenMethodsRector;
use Rector\PHPUnit\CodeQuality\Rector\Class_\PreferPHPUnitThisCallRector;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Set\ValueObject\SetList;
use Rector\Symfony\Set\TwigSetList;

return RectorConfig::configure()
    ->withCache(__DIR__ . '/var/cache/rector')
    ->withRootFiles()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
        __FILE__,
    ])->withSkip([
        PreferPHPUnitThisCallRector::class,
        __DIR__ . '/tests/sources',
        __DIR__ . '/tests/targets',
    ])->withComposerBased(
        twig: true,
        phpunit: true,
        symfony: true,
    )->withPhpSets(
        php82: true
    )->withSets([
        // global
        SetList::PHP_82,
        SetList::CODE_QUALITY,
        SetList::DEAD_CODE,
        SetList::INSTANCEOF,
        SetList::PRIVATIZATION,
        SetList::STRICT_BOOLEANS,
        SetList::TYPE_DECLARATION,
        // PHP-Unit
        PHPUnitSetList::PHPUNIT_110,
        PHPUnitSetList::PHPUNIT_CODE_QUALITY,
        PHPUnitSetList::ANNOTATIONS_TO_ATTRIBUTES,
        // twig
        TwigSetList::TWIG_24,
        TwigSetList::TWIG_UNDERSCORE_TO_NAMESPACE,
    ])->withRules([
        // static closure and arrow functions
        StaticClosureRector::class,
        StaticArrowFunctionRector::class,
        // must be removed when using SetList::PHP_83
        AddOverrideAttributeToOverriddenMethodsRector::class,
    ]);
