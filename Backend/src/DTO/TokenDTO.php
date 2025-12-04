<?php

namespace App\DTO;

readonly class TokenDTO {
	public string $token;

	public function __construct(
		string $token
	){
		$this->token = $token;
	}
}
