<?php

namespace App\Service;

use App\DTO\UserDTO;
use App\Entity\User;
use App\Exception\UserException;
use App\Factory\UserFactory;
use App\Repository\UserRepository;


class UserService {
	private UserRepository $rep;
	private UserFactory $factory;

	public function __construct(
		UserRepository $rep,
		UserFactory $factory
	){
		$this->rep = $rep;
		$this->factory = $factory;
	}

	public function getById(int $id): UserDTO{
		$user = $this->rep->getById($id);
		if($user == null){
			throw UserException::noUser();
		}
		return $this->factory->toDTO($user);
	}

	/**
	 * @return UserDTO[]
	 */
	public function getAllScores(): array{
		$users = $this->rep->getOrderByScore();
		return array_map(function($user){
			return $this->factory->toDTO($user);
		}, $users);
	}

	public function createUser(string $pseudo, string $password): UserDTO{
		$pseudo = trim($pseudo);
		$password = trim($password);
		if($pseudo == "" || $password == ""){
			throw UserException::noData();
		}
		$user = $this->rep->getByPseudo($pseudo);
		if($user != null){
			throw UserException::alreadyExisting();
		}
		$hashing = password_hash($password, PASSWORD_DEFAULT);
		$user = new User(
			pseudo: $pseudo,
			password: $hashing
		);
		$user = $this->rep->save($user);
		return $this->factory->toDTO($user);
	}

	public function updateAvancement(int $uid, int $avancement): UserDTO{
		$user = $this->rep->getById($uid);
		if($user == null){
			throw UserException::noUser();
		}
		$user->setAvancement($avancement);
		$this->rep->save($user);
		return $this->factory->toDTO($user);
	}

	public function updateScore(int $uid, int $score): UserDTO{
		$user = $this->rep->getById($uid);
		if($user == null){
			throw UserException::noUser();
		}
		if($user->getScore() < $score){
			$user->setScore($score);
		}
		$this->rep->save($user);
		return $this->factory->toDTO($user);
	}

	public function login(string $pseudo, string $password): UserDTO{
		$pseudo = trim($pseudo);
		$password = trim($password);
		if($pseudo == "" || $password == ""){
			throw UserException::noData();
		}
		$user = $this->rep->getByPseudo($pseudo);
		if($user == null){
			throw UserException::noUser();
		}
		if(!password_verify($password, $user->getPassword())){
			throw UserException::badInfos();
		}
		return $this->factory->toDTO($user);
	}
}
