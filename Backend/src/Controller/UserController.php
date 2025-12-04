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

	#[Route("/",
		name: "self",
		methods: ["GET"]
	)]
	public function showSelf(Request $req): Response{
		$token = $req->headers->get("Authorization");
		$uid = $this->tokenService->readToken($token)->id;
		$user = $this->service->getById($uid);
		return $this->api->success($user);
	}

	#[Route("/avancement",
		name: "avancement",
		methods: ["POST", "PUT"]
	)]
	public function updateAvancement(Request $req): Response{
		$token = $req->headers->get("Authorization");
		$uid = $this->tokenService->readToken($token)->id;
		$data = json_decode($req->getContent(), true);
		$avancement = $data["avancement"] ?? null;
		if($avancement != null){
			$avancement = intval($avancement);
		}
		$waifu = $data["waifu"] ?? null;
		if($waifu != null){
			$waifu = intval($waifu);
		}
		return $this->api->success(
			$this->service->updateAvancement($uid, $avancement, $waifu),
			202
		);
	}

	#[Route("/score",
		name: "score",
		methods: ["POST", "PUT"]
	)]
	public function updateScore(Request $req): Response{
		$token = $req->headers->get("Authorization");
		$uid = $this->tokenService->readToken($token)->id;
		$data = json_decode($req->getContent(), true);
		$avancement = $data["score"] ?? 0;
		return $this->api->success(
			$this->service->updateScore($uid, $avancement),
			202
		);
	}

	#[Route("/score/tab",
		name: "score_tab",
		options: ["no_password_check" => true],
		methods: ["GET"]
	)]
	public function getScores(): Response{
		return $this->api->success($this->service->getAllScores());
	}

	#[Route("/{id}",
		name: "show",
		methods: ["GET"]
	)]
	public function show(int $id): Response{
		return $this->api->success($this->service->getById($id));
	}
}
