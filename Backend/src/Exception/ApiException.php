<?php

namespace App\Exception;

class ApiException extends \Exception {
	public function __construct(string $message = "Exception de l'application", int $code = 500) {
		parent::__construct($message, $code);
	}

	public static function noData(string $message = "Infos manquantes", int $code = 400): self{
		return new self($message, $code);
	}
}
