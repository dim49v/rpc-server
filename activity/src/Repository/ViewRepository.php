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
}
