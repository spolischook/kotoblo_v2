<?php

namespace App\Repository;

use App\Entity\Thread;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ThreadRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Thread::class);
    }

    public function getNumberComments()
    {
        return $this->createQueryBuilder('th')
            ->select('th.id, th.numComments')
            ->indexBy('th', 'th.id')
            ->getQuery()
            ->getArrayResult()
        ;
    }
}
