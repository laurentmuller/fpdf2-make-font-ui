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

use PhpCsFixer\Config;
use PhpCsFixer\Finder;
use PhpCsFixer\Runner\Parallel\ParallelConfigFactory;

$comment = <<<COMMENT
    This file is part of the 'fpdf2-make-font-ui' package.

    For the license information, please view the LICENSE
    file that was distributed with this source code.

    @author bibi.nu <bibi@bibi.nu>
    COMMENT;

$rules = [
    // --------------------------------------------------------------
    //  Rule sets
    // --------------------------------------------------------------
    '@auto' => true,
    '@auto:risky' => true,
    '@Symfony' => true,
    '@Symfony:risky' => true,
    '@PHP8x2Migration' => true,
    '@PHP8x2Migration:risky' => true,
    '@PHPUnit100Migration:risky' => true,

    // --------------------------------------------------------------
    //  Rules override
    // --------------------------------------------------------------
    'strict_param' => true,
    'php_unit_strict' => true,
    'no_useless_else' => true,
    'no_useless_return' => true,
    'no_unused_imports' => true,
    'strict_comparison' => true,
    'ordered_interfaces' => true,
    'final_internal_class' => true,
    'method_chaining_indentation' => true,
    'concat_space' => ['spacing' => 'one'],
    'list_syntax' => ['syntax' => 'short'],
    'array_syntax' => ['syntax' => 'short'],
    'ordered_class_elements' => ['sort_algorithm' => 'alpha'],
    'phpdoc_to_comment' => ['allow_before_return_statement' => true],
    'php_unit_test_case_static_method_calls' => ['call_type' => 'self'],
    'native_function_invocation' => ['include' => ['@internal', 'all']],
    'new_with_braces' => ['anonymous_class' => false, 'named_class' => true],
    'ordered_imports' => ['imports_order' => ['const', 'class', 'function']],
    'blank_line_before_statement' => ['statements' => ['declare', 'try', 'return']],
    'header_comment' => ['header' => $comment, 'location' => 'after_open', 'separate' => 'bottom'],
];

$finder = Finder::create()
    ->in(__DIR__ . '/config')
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests')
    ->notPath('sources')
    ->notPath('targets')
    ->append([
        __FILE__,
        __DIR__ . '/rector.php',
        __DIR__ . '/public/index.php',
        __DIR__ . '/.twig-cs-fixer.php',
        __DIR__ . '/rector.php',
    ]);

$config = new Config();

return $config
    ->setParallelConfig(ParallelConfigFactory::detect())
    ->setCacheFile(__DIR__ . '/var/cache/php-cs-fixer/.php-cs-fixer.cache')
    ->setRiskyAllowed(true)
    ->setFinder($finder)
    ->setRules($rules);
