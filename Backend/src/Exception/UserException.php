<?php

namespace App\Exception;

class UserException extends ApiException {
	public function __construct(string $message = "Exception de l'utilisateur", int $code = 500) {
		parent::__construct($message, $code);
	}

	public static function noUser(string $message = "Aucun utilisateur à cet id", int $code = 404):self{
		return new self($message, $code);
	}

	public static function alreadyExisting(string $message = "Il existe déjà un utilisateur sous ce pseudo", int $code = 403): self{
		return new self($message, $code);
	}

	public static function badInfos(string $message = "Informations de connexion erronnées", int $code = 400):self{
		return new self($message, $code);
	}
}
