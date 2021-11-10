<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

abstract class CustomRepository extends ServiceEntityRepository
{
    public const ENTITY = 'entity';

    /**
     * {@inheritdoc}
     */
    public function __construct(ManagerRegistry $registry, $entityClass)
    {
        parent::__construct($registry, $entityClass);
    }

    protected function parseOrder(QueryBuilder $qb, array $orderBy): QueryBuilder
    {
        $entity = self::ENTITY;

        foreach ($orderBy as $field => $order) {
            if ($this->getClassMetadata()->hasField($field)) {
                $qb->addOrderBy("{$entity}.{$field}", $order);
            }
        }

        return $qb;
    }

    protected function createParsedQueryBuilder(
        ?array $orderBy = null,
        ?int $limit = null,
        ?int $offset = null
    ): QueryBuilder {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select(self::ENTITY)
            ->from($this->getEntityName(), self::ENTITY);

        if (null !== $orderBy) {
            $qb = $this->parseOrder($qb, $orderBy);
        }

        if (null !== $limit) {
            $qb->setMaxResults($limit);
        }
        if (null !== $offset) {
            $qb->setFirstResult($offset);
        }

        return $qb;
    }

    /**
     * @return object[]|Paginator
     */
    public function findPaginated(
        ?array $orderBy = null,
        ?int $limit = null,
        ?int $offset = null
    ): Paginator {
        $qb = $this->createParsedQueryBuilder($orderBy, $limit, $offset);

        return new Paginator($qb, true);
    }
}
