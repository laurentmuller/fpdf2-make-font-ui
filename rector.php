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

use Rector\Config\RectorConfig;
use Rector\PHPUnit\CodeQuality\Rector\Class_\PreferPHPUnitThisCallRector;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Set\ValueObject\SetList;

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
    ])->withSets([
        // global
        SetList::PHP_82,
        SetList::CODE_QUALITY,
        SetList::PRIVATIZATION,
        SetList::INSTANCEOF,
        SetList::STRICT_BOOLEANS,
        // PHP-Unit
        PHPUnitSetList::PHPUNIT_110,
        PHPUnitSetList::PHPUNIT_CODE_QUALITY,
        PHPUnitSetList::ANNOTATIONS_TO_ATTRIBUTES,
    ]);
