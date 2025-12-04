<?php

namespace App\DTO;

readonly class UserDTO {
	public int $id;

	public string $pseudo;

	public int $avancement;

	public function __construct(
		int $id,
		string $pseudo,
		int $avancement
	){
		$this->id = $id;
		$this->pseudo = $pseudo;
		$this->avancement = $avancement;
	}
}
