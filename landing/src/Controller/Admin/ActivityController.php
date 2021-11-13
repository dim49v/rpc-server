<?php

namespace App\Controller\Admin;

use App\Controller\BaseController;
use App\Controller\Traits\ExceptionTrait;
use App\Controller\Traits\QueryParamsTrait;
use App\Interfaces\ListenControllerInterface;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @Route("/activity", name="activity_")
 */
class ActivityController extends AbstractController implements ListenControllerInterface
{
    use ExceptionTrait;
    use QueryParamsTrait;

    protected const ACTIVITY_TEMPLATE = 'activity.html.twig';

    protected Request $request;
    protected HttpClientInterface $client;

    /**
     * ActivityController constructor.
     */
    public function __construct(RequestStack $requestStack, HttpClientInterface $client)
    {
        if (null === $request = $requestStack->getCurrentRequest()) {
            throw $this->createBadRequestException('Malformed request.');
        }
        $this->request = $request;
        $this->client = $client;
    }

    /**
     * @Route("", name="get_list", methods={"GET"})
     */
    public function getList(): Response
    {
        $query = BaseController::JSON_RPC_BODY;
        $query['method'] = 'get_views_list';
        $query['params'] = [
            'perPage' => $this->getPerPageParam(),
            'page' => $this->getPageParam(),
        ];

        $response = $this->client->request(
            'POST',
            BaseController::JSON_RPC_URL,
            [
                'json' => [$query],
            ]
        );
        $data = json_decode($response->getContent(), true);
        $result = json_decode($data[0]['result'], true);

        if (!$this->get('twig')->getLoader()->exists(self::ACTIVITY_TEMPLATE)) {
            throw new RuntimeException('Template not found');
        }
        $html = $this->renderView(
            self::ACTIVITY_TEMPLATE,
            ['data' => $result]
        );

        return new Response($html);
    }
}
