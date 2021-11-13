<?php

namespace App\Method;

use App\Entity\View;
use App\Repository\ViewRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Yoanm\JsonRpcServer\Domain\JsonRpcMethodInterface;

class GetViewsListMethod implements JsonRpcMethodInterface
{
    public const DEFAULT_ORDER_BY = ['url' => Criteria::ASC];
    public const DEFAULT_PER_PAGE = 10;
    public const DEFAULT_PAGE = 1;

    protected EntityManagerInterface $entityManager;
    protected SerializerInterface $serializer;

    public function __construct(EntityManagerInterface $entityManager, SerializerInterface $serializer)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    public function apply(array $paramList = null): string
    {
        $orderBy = $paramList['orderBy'] ?? self::DEFAULT_ORDER_BY;
        $perPage = $paramList['perPage'] ?? self::DEFAULT_PER_PAGE;
        $page = $paramList['page'] ?? self::DEFAULT_PAGE;

        $offset = ($page - 1) * $perPage;

        /** @var ViewRepository $repository */
        $repository = $this->entityManager->getRepository(View::class);
        $items = $repository->getItemsGroupedByUrl($orderBy, $perPage, $offset);
        $data = [
            'perPage' => $perPage,
            'page' => $page,
            'items' => $items,
        ];

        return $this->serializer->serialize($data, 'json');
    }
}
