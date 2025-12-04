<?php

namespace App\DTO;

readonly class UserDTO {
	public int $id;

	public string $pseudo;

	public function __construct(
		int $id,
		string $pseudo
	){
		$this->id = $id;
		$this->pseudo = $pseudo;
	}
}
