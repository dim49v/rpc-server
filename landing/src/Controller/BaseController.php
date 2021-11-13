<?php

namespace App\Controller;

use App\Controller\Traits\ExceptionTrait;
use App\Interfaces\ListenControllerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

abstract class BaseController extends AbstractController implements ListenControllerInterface
{
    use ExceptionTrait;

    public const JSON_RPC_URL = 'http://app_activity/json-rpc';
    public const JSON_RPC_BODY = [
        'jsonrpc' => '2.0',
        'method' => '',
        'params' => [],
        'id' => 1,
    ];

    protected Request $request;

    /**
     * BaseController constructor.
     */
    public function __construct(RequestStack $requestStack)
    {
        if (null === $request = $requestStack->getCurrentRequest()) {
            throw $this->createBadRequestException('Malformed request.');
        }
        $this->request = $request;
    }

    /**
     * @Route("/{id}", name="get_page", methods={"GET"})
     */
    public function getPage(string $id): Response
    {
        return new Response(
            "<html><body>Page: {$this->request->getPathInfo()}</body></html>"
        );
    }
}
