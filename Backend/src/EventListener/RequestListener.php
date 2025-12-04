<?php

namespace App\EventListener;

use App\Exception\TokenException;
use App\Service\TokenService;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;

class RequestListener {
	public function __construct(
		private TokenService $tokenService,
		private RouterInterface $router
	){}

	#[asEventListener(event: KernelEvents::REQUEST)]
	public function onKernelEvent(RequestEvent $event): void{
		$req = $event->getRequest();
		$routeOptions = $this->router->getRouteCollection()->get($req->attributes->get("_route"))->getOptions();

		// Route free
		if(isset($routeOptions["no_password_check"]) && $routeOptions["no_password_check"]){
			return;
		}

		// Verif token headers
		$headerPassword = $req->headers->get("Authorization");
		if($headerPassword == null){
			throw TokenException::noToken();
		}
		$this->tokenService->readToken($headerPassword);
	}
}
