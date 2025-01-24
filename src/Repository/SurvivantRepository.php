<?php

namespace App\Repository;

use App\Entity\Survivant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Survivant>
 */
class SurvivantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Survivant::class);
    }

       /**
        * @return Survivant[] Returns an array of Survivant objects
        */
       public function filterZA(): array
       {
           return $this->createQueryBuilder('s')
               ->orderBy('s.nom', 'DESC')
               ->getQuery()
               ->getResult()
           ;
       }

        /**
         *  @return Survivant[] Returns an array of Survivant objects
         */
        public function filterNain($name): array
        {
            return $this->createQueryBuilder('s')
                ->leftJoin('s.race', 'ra')
                ->andWhere('ra.race_name = :raceName')
                ->setParameter('raceName', $name)
                // ->orderBy('s.nom', 'ASC')
                // ->setMaxResults(10)
                ->getQuery()
                ->getResult()
            ;
        }


        /**
         *  @return Survivant[] Returns an array of Survivant objects
         */
        public function filterElfe25($name, $power): array
        {
            return $this->createQueryBuilder('s')
                ->leftJoin('s.race', 'ra')
                ->andWhere('ra.race_name = :raceName')
                ->setParameter('raceName', $name)
                ->andWhere('s.puissance >= :power')
                ->setParameter('power', $power)
                // ->orderBy('s.nom', 'ASC')
                // ->setMaxResults(10)
                ->getQuery()
                ->getResult()
            ;
        }

        /**
         *  @return Survivant[] Returns an array of Survivant objects
         */
        public function filterNotHuman($name, $cname): array
        {
            return $this->createQueryBuilder('s')
                ->join('s.race', 'ra')
                ->andWhere('ra.race_name != :raceName')
                ->setParameter('raceName', $name)
                ->join('s.classe', 'cl')
                ->andWhere('cl.class_name = :className')
                ->setParameter('className', $cname)
                // ->orderBy('s.nom', 'ASC')
                // ->setMaxResults(10)
                ->getQuery()
                ->getResult()
            ;
        }

        // /**
        //  *  @return Survivant[] Returns an array of Survivant objects
        //  */
        // public function filterFormPower($power): array
        // {
        //     return $this->createQueryBuilder('s')
        //         ->andWhere('s.puissance >= :power')
        //         ->setParameter('power', $power)
        //         ->getQuery()
        //         ->getResult()
        //     ;
        // }

        // public function filterFormRace($race): array
        // {
        //     return $this->createQueryBuilder('s')
        //         ->leftJoin('s.race', 'ra')
        //         ->andWhere('ra.race_name = :raceName')
        //         ->setParameter('raceName', $race)
        //         ->getQuery()
        //         ->getResult()
        //     ;
        // }

        // public function filterFormClass($class): array
        // {
        //     return $this->createQueryBuilder('s')
        //         ->join('s.classe', 'cl')
        //         ->andWhere('cl.class_name = :className')
        //         ->setParameter('className', $class)
        //         ->getQuery()
        //         ->getResult()
        //     ;
        // }

        public function filterForm($power, $race, $class): array
        {
            $qb = $this->createQueryBuilder('s')
                ->andWhere('s.puissance >= :power')
                ->setParameter('power', $power);

                if ($race != null){
                    $qb = $qb
                        ->join('s.race', 'ra')
                        ->andWhere('ra.race_name = :race')
                        ->setParameter('race', $race)
                ;}

                if ($class != null){
                    $qb = $qb
                        ->join('s.classe', 'cl')
                        ->andWhere('cl.class_name = :class')
                        ->setParameter('class', $class)
                ;}

                // ->orderBy('s.nom', 'ASC')
                // ->setMaxResults(10)

            ;
            return $qb ->getQuery()->getResult();
        }


    //    public function findOneBySomeField($value): ?Survivant
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }


}
