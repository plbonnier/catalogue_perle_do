<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use InvalidArgumentException;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }


    public function findAllFiltered($orderBy, $direction, $filters): array
    {
        $validOrderBy = ['name', 'rent'];
        $validDirection = ['ASC', 'DESC'];

        if (!in_array($orderBy, $validOrderBy) || !in_array($direction, $validDirection)) {
            throw new InvalidArgumentException('Invalid order by or direction parameter');
        }

        $qb = $this->createQueryBuilder('p')
            ->orderBy('p.' . $orderBy, $direction);

        if (isset($filters['rent']) && $filters['rent'] !== '') {
            $qb->andWhere('p.rent = :rent')
                ->setParameter('rent', $filters['rent']);
        }

        return $qb->getQuery()->getResult();
    }

    //    /**
    //     * @return Product[] Returns an array of Product objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Product
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
