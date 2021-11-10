<?php

namespace App\Method;

use App\Entity\View;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Yoanm\JsonRpcServer\Domain\Exception\JsonRpcException;
use Yoanm\JsonRpcServer\Domain\Exception\JsonRpcInternalErrorException;
use Yoanm\JsonRpcServer\Domain\Exception\JsonRpcInvalidParamsException;
use Yoanm\JsonRpcServer\Domain\JsonRpcMethodInterface;

class UrlViewMethod implements JsonRpcMethodInterface
{
    protected EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function apply(array $paramList = null): string
    {
        if (empty($paramList['url']) || empty($paramList['date'])) {
            throw new JsonRpcException(JsonRpcInvalidParamsException::CODE, "Empty 'url' or 'date'.");
        }

        try {
            $date = new DateTime($paramList['date']);
        } catch (Exception $e) {
            throw new JsonRpcException(JsonRpcInvalidParamsException::CODE, 'Invalid date format.');
        }

        /** @var ?View $item */
        $item = $this->entityManager->getRepository(View::class)->find($paramList['url']);
        if (null !== $item) {
            $item->increment()
                ->setLastView($date);
        } else {
            $item = (new View())
                ->setUrl($paramList['url'])
                ->setViewsCount(1)
                ->setLastView($date);
        }
        try {
            $this->entityManager->persist($item);
            $this->entityManager->flush();
        } catch (Exception $e) {
            throw new JsonRpcException(JsonRpcInternalErrorException::CODE, 'Failed save in DB.');
        }

        return 'Success';
    }
}
