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

namespace App\Controller;

use App\Form\MakeFontQueryType;
use App\Model\MakeFontQuery;
use App\Service\MakeFontService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class IndexController extends AbstractController
{
    public const ROUTE_NAME = 'index';
    public const ROUTE_URL = '/';

    #[Route(
        path: self::ROUTE_URL,
        name: self::ROUTE_NAME,
        methods: [Request::METHOD_GET, Request::METHOD_POST],
    )]
    public function __invoke(Request $request, MakeFontService $service): Response
    {
        $result = null;
        $query = new MakeFontQuery();
        $form = $this->createForm(MakeFontQueryType::class, $query);
        if ($this->handleForm($request, $form)) {
            $locale = $request->getLocale();
            $result = $service->generate($query, $locale);
            if ($result->isSuccess()) {
                return $this->sendFile($result->fileName);
            }
        }

        return $this->render('index.html.twig', [
            'result' => $result,
            'form' => $form,
        ]);
    }

    private function handleForm(Request $request, FormInterface $form): bool
    {
        $form->handleRequest($request);

        return $form->isSubmitted() && $form->isValid();
    }

    private function sendFile(string $fileName): BinaryFileResponse
    {
        return $this->file($fileName)
            ->deleteFileAfterSend();
    }
}
