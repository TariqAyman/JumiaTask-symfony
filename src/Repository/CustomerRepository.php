<?php

namespace App\Repository;

use App\Entity\Country;
use App\Entity\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Customer>
 *
 * @method Customer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customer[]    findAll()
 * @method Customer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerRepository extends ServiceEntityRepository
{
    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customer::class);

        $this->getEntityManager()
            ->getConnection()
            ->getNativeConnection()
            ->sqliteCreateFunction('REGEXP', function ($pattern, $value) {
                mb_regex_encoding('UTF-8');
                return (mb_ereg($pattern, $value)) !== false ? 1 : 0;
            });
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Customer $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Customer $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @param $countryCode
     * @return array Returns an array of Customer objects
     */

    public function findByCountryCode($countryCode): array
    {
        return $this->createQueryBuilder('customer')
            ->andWhere('customer.phone LIKE :countryCode')
            ->setParameter('countryCode', '(' . $countryCode . ')%')
            ->getQuery()
            ->getResult();
    }

    /**
     * Fetch phone numbers records from database according to the given filters
     *
     * @param array $filters
     * @return Query - filtered phone number
     */
    public function queryFetchFilterPhoneNumbers(array $filters)
    {
        $countryId = $filters['selectedCountry'] ?? null;

        $state = $filters['selectedState'] ?? null;

        $queryBuilder = $this->createQueryBuilder('c')
            ->select([
                'c.id as id',
                'REGEXP(c.phone,cr.regex) AS state',
                'cr.name AS countryName',
                'cr.code AS  countryCode',
                "SUBSTRING(c.phone,instr(c.phone,' ') +1) AS number"
            ])
            ->leftJoin(Country::class, 'cr', 'WITH', "instr(SUBSTRING(c.phone, 1,instr(c.phone,' ') -1),cr.code)>0");


        if ($countryId) {
            $queryBuilder->where('cr.id = :countryId');
            $queryBuilder->setParameter('countryId', $countryId);
        }

        if (!in_array($state, [null, 'null'])) {
            $queryBuilder->andWhere('REGEXP(c.phone,cr.regex) = :isValid');
            $queryBuilder->setParameter('isValid', $state, \PDO::PARAM_BOOL);
        }

        if (!empty($filters['length']) && (int) $filters['length'] > -1) {
            $queryBuilder->setFirstResult($filters['start']);
            $queryBuilder->setMaxResults((int) $filters['length']);
        }

        return $queryBuilder->getQuery()->getResult();
    }
}
