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

namespace App\Service;

use Twig\Attribute\AsTwigFunction;

/**
 * Service to generate a nonce value.
 */
class NonceService
{
    /**
     *  The generated nonce.
     */
    private ?string $nonce = null;

    /**
     * Gets the CSP nonce.
     */
    public function getCspNonce(): string
    {
        return \sprintf("'nonce-%s'", $this->getNonce());
    }

    /**
     * Generates a random nonce.
     */
    #[AsTwigFunction(name: 'csp_nonce')]
    public function getNonce(): string
    {
        return $this->nonce ??= \bin2hex(\openssl_random_pseudo_bytes(16));
    }
}
