<?php

namespace App\EventListener;

use App\Exception\ApiException;
use App\Service\ApiResponse;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionListener {
	public function __construct(
		private ApiResponse $api
	){}

	#[asEventListener(event: KernelEvents::EXCEPTION)]
	public function onKernelException(ExceptionEvent $event):void{
		$exception = $event->getThrowable();
		$statusCode = 500;
		if($exception instanceof ApiException){
			$statusCode = $exception->getCode();
		}
		$json = $this->api->error($statusCode, $exception->getMessage());
		$event->setResponse($json);
	}
}
