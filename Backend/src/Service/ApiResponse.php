<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\JsonResponse;

class ApiResponse {
	public function error(int $code, string $message): JsonResponse{
		$data = [
			"code" => $code,
			"message" => $message
		];
		return $this->render($data, $code);
	}

	public function success($data, int $code = 200): JsonResponse{
		return $this->render($data, $code);
	}

	private function render($data, $code): JsonResponse{
		$reponse = new JsonResponse($data, $code);
		$reponse->setEncodingOptions(JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		return $reponse;
	}
}
