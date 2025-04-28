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
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    public const ROUTE_NAME = 'index';
    public const ROUTE_URL = '/';

    #[Route(path: self::ROUTE_URL, name: self::ROUTE_NAME)]
    public function __invoke(Request $request, MakeFontService $service): Response
    {
        $result = null;
        $query = new MakeFontQuery();
        $form = $this->createForm(MakeFontQueryType::class, $query);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
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

    private function sendFile(string $file): BinaryFileResponse
    {
        return $this->file($file)
            ->deleteFileAfterSend();
    }
}
