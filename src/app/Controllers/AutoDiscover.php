<?php

/**
 * @author Constan van Suchtelen van de Haere <constan@hostingbe.com>
 * @copyright 2023 HostingBE
 */

namespace HostingBE\Autodiscover\App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

class AutoDiscover {

protected $view;
protected $logger;
protected $settings;


public function __construct(Twig $view,$logger,$settings) {
	$this->view = $view; 
      $this->logger = $logger;
      $this->settings = $settings;
      }
/**
 * handles V2 autodiscover requests
 */

public function show_v2(Request $request,Response $response) {

$body = $request->getBody();
$xmldata = simplexml_load_string($body);

if ($xmldata === false) {
      $response->getBody()->write("invalid XML!");
      return $response->withStatus(403);      }

$email = $xmldata->Request->EMailAddress;

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $response->getBody()->write("invalid e-mail!");
      return $response->withStatus(403);
      }

$this->logger->info(get_class() . ': V2 autodiscover for email address' . $email);

$config = new \HostingBE\Autodiscover\App\Interfaces\FileInterface();
$domain = $this->getDomain($email);
$imap = $config->getimap();
$pop = $config->getpop3();
$smtp = $config->getsmtp();
$info = array('name' => 'mailbox ' . $this->getName($email),'url' => $this->settings['supporturl']);

$xml = $this->view->fetch('/xml/autodiscover.xml',['email' => $email, 'domain' => $domain, 'info'=> $info, 'imap' => $imap,'pop'=> $pop,'smtp' => $smtp]);

$response->getBody()->write($xml);
return $response->withHeader('Content-Type', 'application/xml');
}
 
/**
 * handles V1 autodiscover requests
 */
public function show_v1(Request $request,Response $response) {
$email = $request->getAttribute('email');

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $response->getBody()->write("invalid e-mail!");
          return $response->withStatus(403);
      }

$config = new \HostingBE\Autodiscover\App\Interfaces\FileInterface();
$domain = $this->getDomain($email);
$imap = $config->getimap();
$pop = $config->getpop3();
$smtp = $config->getsmtp();
$info = array('name' => 'mailbox ' . $this->getName($email),'url' => $this->settings['supporturl']);

$this->logger->info(get_class() . ': V1 autodiscover for email address' . $email);

$xml = $this->view->fetch('/xml/autodiscover.xml',['email' => $email, 'domain' => $domain, 'info'=> $info, 'imap' => $imap,'pop'=> $pop,'smtp' => $smtp]);
      
$response->getBody()->write($xml);
return $response->withHeader('Content-Type', 'application/xml');

      }
private function getName($email) { 
      return explode('@',$email)[0];
      }

private function getDomain($email) { 
      return explode('@',$email)[1];
      }

}

?>