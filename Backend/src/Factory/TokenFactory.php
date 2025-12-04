<?php

namespace App\Factory;

use App\DTO\TokenDTO;

class TokenFactory {
	public function toDTO(string $token): TokenDTO{
		return new TokenDTO(
			$token
		);
	}
}
