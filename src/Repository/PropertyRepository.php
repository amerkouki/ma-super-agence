<?php

namespace App\Repository;

use App\Entity\Property;
use App\Entity\PropertySearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }

    /**
     *
     * @return Query
     */
    public function findAllVisibeQuery(PropertySearch $search): Query
    {
        $qurey= $this->createQueryBuilder('p');
        if($search->getMaxPrice()){
            $qurey->andWhere('p.price <= :maxprice');
            $qurey->setParameter('maxprice' , $search->getMaxPrice());
        }
        if($search->getMinSurface()){
            $qurey->andWhere('p.surface >= :minsurface');
            $qurey->setParameter('minsurface' , $search->getMinSurface());
        }
    
        if($search->getOptions()->count() > 0)
        {
            $k =0;
            foreach($search->getOptions() as $option){
                $k++;
                $qurey=$qurey->andWhere(":option$k MEMBER OF p.options");
                $qurey->setParameter("option$k" , $option);
            }
        }
            return $qurey->getQuery();
          
    }

    /**
     *
     * @return Property[]
     */
    public function findLast(): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.sold = false')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }


    private function findVisibeQuery()
    {
        return $this->createQueryBuilder('p')
            ->where('p.sold = false')
            ->getQuery()
            ->getResult();
    }
    // /**
    //  * @return Property[] Returns an array of Property objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Property
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
