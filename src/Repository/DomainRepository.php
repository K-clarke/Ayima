<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Domain;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Domain|null find($id, $lockMode = null, $lockVersion = null)
 * @method Domain|null findOneBy(array $criteria, array $orderBy = null)
 * @method Domain[]    findAll()
 * @method Domain[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DomainRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Domain::class);
    }

    public function findOneLikeName($name)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.name like :val')
            ->setParameter('val', $name . '%')
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
