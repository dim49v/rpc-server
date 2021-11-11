<?php

namespace App\EventListener;

use App\Controller\BaseController;
use App\Interfaces\ListenControllerInterface;
use DateTime;
use DateTimeInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class KernelControllerListener
{
    protected HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function onKernelController(ControllerEvent $event)
    {
        $controller = $event->getController();
        if (is_array($controller) && $controller[0] instanceof ListenControllerInterface) {
            $query = [
                'jsonrpc' => '2.0',
                'method' => 'url_view',
                'params' => [
                    'url' => $event->getRequest()->getPathInfo(),
                    'date' => (new DateTime())->format(DateTimeInterface::ISO8601),
                ],
                'id' => 1,
            ];
            $request = $this->client->request(
                'POST',
                BaseController::JSON_RPC_URL,
                [
                    'json' => [$query],
                ]
            );
            $this->client->stream([$request], 0);
        }
    }
}
