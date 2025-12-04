<?php

namespace App\Service;

use App\DTO\TokenDTO;
use App\Exception\ApiException;
use App\Exception\TokenException;
use App\Factory\TokenFactory;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class TokenService {
	private Key $key;
	private string $tokenPass;
	private int $tokenExp;
	private string $tokenWebsite;

	private TokenFactory $factory;

	public function __construct(
		string $tokenPass,
		string $tokenExp,
		string $tokenWebsite,
		TokenFactory $factory
	){
		$this->key = new Key($tokenPass, "HS256");
		$this->tokenPass = $tokenPass;
		$this->tokenExp = $tokenExp;
		$this->tokenWebsite = $tokenWebsite;
		$this->factory = $factory;
	}

	public function createToken(int $id): TokenDTO{
		$now = time();
		$exp = $now + $this->tokenExp;

		$data = [
			"id" => $id
		];

		$payload = [
			"iss" => $this->tokenWebsite,
			"aud" => $this->tokenWebsite,
			"iat" => $now,
			"nbf" => $now,
			"exp" => $exp,
			"data" => $data
		];
		return $this->factory->toDTO(JWT::encode($payload, $this->tokenPass, "HS256"));
	}

	public function readToken(string $token): \stdClass{
		try{
			$jwt = JWT::decode($token, $this->key);
			if(time() > $jwt->exp){
				throw TokenException::expiredToken();
			}
			return $jwt->data;
		}catch (ApiException $apie){
			throw $apie;
		}catch (\Exception $e){
			throw TokenException::invalidToken();
		}
	}
}
