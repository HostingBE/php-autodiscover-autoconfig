<?php

/**
 * @author Constan van Suchtelen van de Haere <constan@hostingbe.com>
 * @copyright 2023 HostingBE
 */

use Slim\Middleware\ErrorMiddleware;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpForbiddenException;

$errorMiddleware = new ErrorMiddleware(
  $app->getCallableResolver(),
  $app->getResponseFactory(),
  $container->get('settings')['displayErrorDetails'],
  $container->get('settings')['logErrorDetails'],
  $container->get('settings')['logErrorDetails'],
  $container->get('logger')
);

$errorMiddleware->setErrorHandler(HttpForbiddenException::class, function ($request, $exception) use ($container) {
$response = new Response();
return $container->get('view')->render($response->withStatus(403), 'errors/403.twig',['message' => $exception->getMessage()]);  
});


$errorMiddleware->setErrorHandler(HttpNotFoundException::class, function ($request, $exception) use ($container) {
$response = new Response();
return $container->get('view')->render($response->withStatus(404), 'errors/404.twig',['message' => $exception->getMessage()]);  
});


$errorMiddleware->setErrorHandler(RuntimeException::class, function ($request, $exception) use ($container) {
$response = new Response();
return $container->get('view')->render($response->withStatus(500), 'errors/500.twig',['message' => $exception->getMessage(),'line' => $exception->getLine(),'code' => $exception->getCode(), 'file' => $exception->getFile()]); 
});

$app->add($errorMiddleware);
?>