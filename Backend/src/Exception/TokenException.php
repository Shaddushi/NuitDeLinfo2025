<?php

namespace App\Exception;

class TokenException extends ApiException {
	public function __construct(string $message = "Exception du token", int $code = 500) {
		parent::__construct($message, $code);
	}

	public static function noToken(string $message = "Pas de token entré", int $code = 401): self {
		return new self($message, $code);
	}

	public static function unknownToken(string $message = "Token inconnu", $code = 404): self {
		return new self($message, $code);
	}

	public static function invalidToken(string $message="Token incorrect", $code=400): self {
		return new self($message, $code);
	}

	public static function expiredToken(string $message = "Le token a expiré", int $code = 401): self {
		return new self($message, $code);
	}
}
