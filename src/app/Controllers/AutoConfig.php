<?php

/**
 * @author Constan van Suchtelen van de Haere <constan@hostingbe.com>
 * @copyright 2023 HostingBE
 */

namespace HostingBE\Autodiscover\App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

class AutoConfig {

protected $view;
protected $logger;
protected $settings;


public function __construct(Twig $view,$logger,$settings) {
	$this->view = $view; 
      $this->logger = $logger;
      $this->settings = $settings;
      }


/**
 * handles autoconfig requests
 */
public function show(Request $request,Response $response) {

$config = new \HostingBE\Autodiscover\App\Interfaces\FileInterface();
$domain = $this->getDomain($email);
$imap = $config->getimap();
$pop = $config->getpop3();
$smtp = $config->getsmtp();

$info = array('name' => 'mailbox ' . $this->getName($email),'url' => $this->settings['supporturl']);

$this->logger->info(get_class() . ': V1 autodiscover for email address' . $email);

$xml = $this->view->fetch('/xml/autoconfig.xml',['email' => $email, 'domain' => $domain, 'info'=> $info, 'imap' => $imap,'pop'=> $pop,'smtp' => $smtp]);
      
$response->getBody()->write($xml);
return $response->withHeader('Content-Type', 'application/xml');

      }



}

?>