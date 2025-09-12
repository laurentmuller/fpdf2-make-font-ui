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

$file = \dirname(__DIR__) . '/var/cache/prod/App_KernelProdContainer.preload.php';
if (\file_exists($file)) {
    include $file;
}
