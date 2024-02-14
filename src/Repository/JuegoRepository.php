<?php

namespace App\Repository;

use App\Entity\Juego;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Juego>
 *
 * @method Juego|null find($id, $lockMode = null, $lockVersion = null)
 * @method Juego|null findOneBy(array $criteria, array $orderBy = null)
 * @method Juego[]    findAll()
 * @method Juego[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JuegoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Juego::class);
    }

    public function findJuegosConCategoria(string $ordenacion, string $tipoOrdenacion)
    {
        $qb = $this->createQueryBuilder('juego');
        $qb->addSelect('categoria')
            ->innerJoin('juego.categoria', 'categoria')
            ->orderBy('juego.' . $ordenacion, $tipoOrdenacion);
        return $qb->getQuery()->getResult();
    }

    public function findJuegosConMejorValoracion()
    {
        $qb = $this->createQueryBuilder('juego');
        $qb->orderBy('juego.rating', 'DESC')
            ->setMaxResults(3);
        return $qb->getQuery()->getResult();
    }

    public function findJuegosConMasDescargas() {
        $qb = $this->createQueryBuilder('juego');
        $qb->orderBy('juego.numDownloads', 'DESC')
            ->setMaxResults(3);
        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return Juego[] Returns an array of Juego objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('j.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Juego
//    {
//        return $this->createQueryBuilder('j')
//            ->andWhere('j.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
