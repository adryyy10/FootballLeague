<?php

namespace App\Infrastructure\Doctrine\Model\Club;

use App\Domain\Club\Club;
use App\Domain\Club\ClubRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Club>
 *
 * @method Club|null find($id, $lockMode = null, $lockVersion = null)
 * @method Club|null findOneBy(array $criteria, array $orderBy = null)
 * @method Club[]    findAll()
 * @method Club[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClubRepository extends ServiceEntityRepository implements ClubRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Club::class);
    }

    public function add(Club $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Club $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByNoCoach(): array
    {
        $qb = $this->createQueryBuilder('c');

        return $qb->select('c')
            ->where($qb->expr()->isNull("c.coach"))
            ->getQuery()->getResult();
    }

    public function findOneByCoachId(int $coachId): ?Club
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.coach = :coach_id')
            ->setParameter('coach_id', $coachId)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function flush()
    {
        $this->getEntityManager()->flush();
    }
}
