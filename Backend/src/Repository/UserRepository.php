<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository {

	private EntityManagerInterface $em;

	public function __construct(ManagerRegistry $registry) {
		parent::__construct($registry, User::class);
		$this->em = $this->getEntityManager();
	}

	public function save(User $user): User{
		$this->em->persist($user);
		$this->em->flush();
		return $user;
	}

	public function getById(int $id): ?User{
		return $this->createQueryBuilder('u')
			->where("u.id = :id")
			->setParameter("id", $id)
			->getQuery()
			->getOneOrNullResult();
	}

	public function getByPseudo(string $pseudo): ?User{
		return $this->createQueryBuilder('u')
			->where("u.pseudo = :pseudo")
			->setParameter("pseudo", $pseudo)
			->getQuery()
			->getOneOrNullResult();
	}

	/**
	 * @return User[]
	 */
	public function getAll(): array{
		return $this->createQueryBuilder('u')
			->getQuery()
			->getResult();
	}
}
