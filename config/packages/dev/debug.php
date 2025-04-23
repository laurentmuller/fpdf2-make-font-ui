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

use Symfony\Config\DebugConfig;

return static function (DebugConfig $config): void {
    $config->dumpDestination('tcp://%env(VAR_DUMPER_SERVER)%');
};
