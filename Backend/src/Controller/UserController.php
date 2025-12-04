<?php

namespace App\Controller;

use App\Service\ApiResponse;
use App\Service\TokenService;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route("/user", name: "api.user.")]
class UserController extends AbstractController {
	private UserService $service;
	private TokenService $tokenService;
	private ApiResponse $api;

	public function __construct(
		UserService $service,
		TokenService $tokenService,
		ApiResponse $api
	){
		$this->service = $service;
		$this->tokenService = $tokenService;
		$this->api = $api;
	}

	#[Route("/signin",
		name: "signin",
		options: ["no_password_check" => true],
		methods: ["POST"]
	)]
	public function signIn(Request $req): Response{
		$data = json_decode($req->getContent(), true);
		$pseudo = $data["pseudo"] ?? "";
		$password = $data["password"] ?? "";

		$user = $this->service->createUser($pseudo, $password);
		return $this->api->success($this->tokenService->createToken($user->id), 201);
	}

	#[Route("/login",
		name: "login",
		options: ["no_password_check" => true],
		methods: ["POST"]
	)]
	public function login(Request $req): Response{
		$data = json_decode($req->getContent(), true);
		$pseudo = $data["pseudo"] ?? "";
		$password = $data["password"] ?? "";

		$user = $this->service->login($pseudo, $password);
		return $this->api->success($this->tokenService->createToken($user->id));
	}

	#[Route("/{id}",
		name: "show",
		methods: ["GET"]
	)]
	public function show(int $id): Response{
		return $this->api->success($this->service->getById($id));
	}
}
