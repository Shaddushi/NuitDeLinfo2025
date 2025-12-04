<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: "users")]
class User {
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type: "integer")]
	private ?int $id=null;

	#[ORM\Column(type: "string", length: 50, unique: true)]
	private string $pseudo;

	#[ORM\Column(type: "string", length: 255)]
	private string $password;

	#[ORM\Column(name: "date_creation", type: "datetime", nullable: false)]
	private \DateTime $dateCreation;

	#[ORM\Column(type: "integer", nullable: false, options: ["default" => 0])]
	private int $avancement;

	public function __construct(
		string $pseudo,
		string $password
	){
		$this->pseudo = $pseudo;
		$this->password = $password;
		$this->dateCreation = new \DateTime();
		$this->avancement = 0;
	}

	public function getId(): ?int {
		return $this->id;
	}

	public function getPseudo(): string {
		return $this->pseudo;
	}
	public function setPseudo(string $pseudo): static {
		$this->pseudo = $pseudo;
		return $this;
	}

	public function getPassword(): string {
		return $this->password;
	}
	public function setPassword(string $password): static {
		$this->password = $password;
		return $this;
	}

	public function getDateCreation(): \DateTime {
		return $this->dateCreation;
	}


	public function getAvancement(): int {
		return $this->avancement;
	}

	/**
	 * @param int $avancement
	 */
	public function setAvancement(int $avancement): static {
		$this->avancement = $avancement;
		return $this;
	}
}
