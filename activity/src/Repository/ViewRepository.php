<?php

namespace App\Repository;

use App\Entity\View;
use Doctrine\Persistence\ManagerRegistry;

class ViewRepository extends CustomRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, View::class);
    }

    public function getItemsGroupedByUrl(
        ?array $orderBy = null,
        ?int $limit = null,
        ?int $offset = null
    ): array {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $entity = self::ENTITY;
        $qb->select("{$entity}.url, MAX({$entity}.date) AS lastView, COUNT({$entity}.url) AS viewsCount")
            ->from($this->getEntityName(), self::ENTITY)
            ->groupBy("{$entity}.url");

        if (null !== $orderBy) {
            $qb = $this->parseOrder($qb, $orderBy);
        }

        if (null !== $limit) {
            $qb->setMaxResults($limit);
        }
        if (null !== $offset) {
            $qb->setFirstResult($offset);
        }

        return $qb->getQuery()->getArrayResult();
    }
}
