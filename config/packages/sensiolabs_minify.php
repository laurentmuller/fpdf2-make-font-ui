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

use Symfony\Config\SensiolabsMinifyConfig;

return static function (SensiolabsMinifyConfig $sensiolabsMinify): void {
    $sensiolabsMinify->minify()
        ->downloadBinary(true);

    $sensiolabsMinify->assetMapper()
        ->ignorePaths(['*.min.js', '*.min.css'])
        ->ignoreVendor(false);
};
