<?php

/**
 * @author Constan van Suchtelen van de Haere <constan@hostingbe.com>
 * @copyright 2023 HostingBE
 */

namespace HostingBE\Autodiscover\App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

class MainPage {

protected $view;
protected $logger;
protected $settings;

public function __construct(Twig $view, $logger, $settings) {
	$this->view = $view;
      $this->logger = $logger;
      $this->settings = $settings;
      }
 

public function showAutoMatic(Request $request,Response $response) {
      return $this->view->render($response,'automatic.twig',[]);
      }

public function showIos(Request $request,Response $response) {
      return $this->view->render($response,'ios.twig',[]);
      }


public function postManual(Request $request,Response $response) {

$data = $request->getParsedBody();

if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
      $response->getBody()->write("invalid e-mail!");
          return $response->withStatus(403);
      }


// $config = new \HostingBE\Autodiscover\App\Interfaces\FileInterface();
$config = new \HostingBE\Autodiscover\App\Interfaces\dbaseInterface($this->settings['db'],$data['email']);

$domain = $this->getDomain($data['email']);
$imap = $config->getimap();
$pop = $config->getpop3();
$smtp = $config->getsmtp();
$info = array('name' => 'mailbox ' . $this->getName($data['email']),'url' => $this->settings['supporturl']);

$this->logger->info(get_class() . ': manual page requested for e-mail ' . $data['email'],array('ip-address'=> $_SERVER['REMOTE_ADDR']));
return $this->view->render($response,'manual-settings.twig',['email' => $data['email'], 'domain' => $domain, 'info'=> $info, 'imap' => $imap,'pop'=> $pop,'smtp' => $smtp]);
}

public function showManual(Request $request,Response $response) {

return $this->view->render($response,'manual.twig',[]);
}


public function showHomePage(Request $request,Response $response) {
      return $this->view->render($response,'mainpage.twig',[]);
      }
 
private function getName($email) { 
      return explode('@',$email)[0];
      }

private function getDomain($email) { 
      return explode('@',$email)[1];
      }


 }

?>

