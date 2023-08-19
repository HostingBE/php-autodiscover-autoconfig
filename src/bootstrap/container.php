<?php

/**
 * @author Constan van Suchtelen van de Haere <constan@hostingbe.com>
 * @copyright 2023 HostingBE
 */


use DI\Container;
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Csrf\Guard;
use Slim\Views\TwigMiddleware;
use Slim\Views\TwigExtension;


use HostingBE\Autodiscover\App\Controllers\MainPage;
use HostingBE\Autodiscover\App\Controllers\AutoDiscover;
use HostingBE\Autodiscover\App\Controllers\AutoConfig;
use HostingBE\Autodiscover\App\Controllers\MobileConfig;

$containerBuilder = new ContainerBuilder();


$containerBuilder->addDefinitions(__DIR__ . '/../config/config.php');

$container = $containerBuilder->build();
AppFactory::setContainer($container);

$app = AppFactory::create();


  $container->set('logger', function($container) {
	$settings = $container->get('settings')['logger'];
	$logger = new Monolog\Logger($settings['name']);
	$logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'],$settings['level'])); 
  return $logger;
  });

$container->set('view', function($container) {

    $templatedir = __DIR__ . '/../templates';

    $loader =  new \Twig\Loader\FilesystemLoader($templatedir);
   $view = new \Slim\Views\Twig($loader, [
      'debug' => $container->get('settings')['debug'],
      'cache' => __DIR__. '/../cache'
    ]);
    $view->addExtension(new \Twig\Extension\DebugExtension());
   
    return $view;	
});

$container->get("view")->getEnvironment()->addGlobal('sitename', $container->get('settings')['sitename']); 
$container->get("view")->getEnvironment()->addGlobal('url', $container->get('settings')['url']);

$container->set(MainPage::class, function($container) {
return new MainPage(
      $container->get('view'),
      $container->get('logger'),
      $container->get('settings'),  
              );
       });
$container->set(AutoDiscover::class, function($container) {
return new AutoDiscover(
      $container->get('view'),
      $container->get('logger'),
      $container->get('settings'),      
           );
       });
$container->set(AutoConfig::class, function($container) {
return new AutoConfig(
      $container->get('view'),
      $container->get('logger'),
      $container->get('settings'),      
           );
       });
$container->set(MobileConfig::class, function($container) {
return new MobileConfig(
      $container->get('view'),
      $container->get('logger'),
      $container->get('settings'),      
           );
       });

?>