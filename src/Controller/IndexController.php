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
use App\Model\MakeFontResult;
use App\Service\MakeFontService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    public const ROUTE_NAME = 'index';

    private const KEY_FILE_CONTENT = 'file_content';
    private const KEY_FILE_NAME = 'file_name';

    #[Route(
        path: '/download',
        name: 'download',
        methods: [Request::METHOD_GET]
    )]
    public function download(Request $request): Response
    {
        $session = $request->getSession();
        /** @phpstan-var ?string $fileName */
        $fileName = $session->get(self::KEY_FILE_NAME);
        /** @phpstan-var ?string $fileContent */
        $fileContent = $session->get(self::KEY_FILE_CONTENT);
        $this->clearResult($session);

        if (\is_string($fileName) && \is_string($fileContent)) {
            return $this->getFileResponse($fileName, $fileContent);
        }

        return $this->redirectToRoute(self::ROUTE_NAME);
    }

    #[Route(
        path: '/',
        name: self::ROUTE_NAME,
        methods: [Request::METHOD_GET, Request::METHOD_POST],
    )]
    public function index(Request $request, MakeFontService $service): Response
    {
        $result = null;
        $query = new MakeFontQuery();
        $form = $this->createForm(MakeFontQueryType::class, $query)
            ->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $locale = $request->getLocale();
            $result = $service->generate($query, $locale);
            $this->saveResult($request->getSession(), $result);
        }

        return $this->render('index.html.twig', [
            'result' => $result,
            'form' => $form,
        ]);
    }

    private function clearResult(SessionInterface $session): void
    {
        $session->remove(self::KEY_FILE_NAME);
        $session->remove(self::KEY_FILE_CONTENT);
    }

    private function getFileResponse(string $fileName, string $fileContent): Response
    {
        $disposition = HeaderUtils::makeDisposition(
            HeaderUtils::DISPOSITION_ATTACHMENT,
            \basename($fileName)
        );
        $response = new Response($fileContent);
        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }

    private function saveResult(SessionInterface $session, MakeFontResult $result): void
    {
        if ($result->isSuccess()) {
            $session->set(self::KEY_FILE_NAME, $result->fileName);
            $session->set(self::KEY_FILE_CONTENT, \file_get_contents($result->fileName));
        } else {
            $this->clearResult($session);
        }
    }
}
