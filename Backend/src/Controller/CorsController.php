<?php

namespace App\Controller;

use App\Service\ApiResponse;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route("", name: "ws.cors.")]
class CorsController extends AbstractController{

	#[Route('/{catchall}',
		name: "catchall",
		requirements: ["catchall" => ".+"],
		options: ["no_password_check" => true],
		methods: ["OPTIONS"])]
	public function handleCorsPreflight(Request $req): Response{
		$response = new Response();
		$response->headers->set('Access-Control-Allow-Origin', $req->headers->get("Origin"));
		$response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PATCH, OPTIONS');
		$response->headers->set('Access-Control-Allow-Headers', 'Content-Name, Content-Type, Authorization');
		$response->headers->set("Access-Control-Expose-Headers", "Content-Name, Content-Length");
		return $response;
	}
}
