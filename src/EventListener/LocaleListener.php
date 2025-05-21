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

namespace App\EventListener;

use App\Controller\LocaleController;
use fpdf\Translator;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

readonly class LocaleListener
{
    #[AsEventListener(event: KernelEvents::REQUEST, priority: 100)]
    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $locale = $request->cookies->getString(LocaleController::LOCALE_KEY, Translator::DEFAULT_LOCALE);
        if (Translator::isAllowedLocale($locale)) {
            $request->setLocale($locale);
        }
    }
}
