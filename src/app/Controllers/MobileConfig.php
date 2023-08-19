<?php

/**
 * @author Constan van Suchtelen van de Haere <constan@hostingbe.com>
 * @copyright 2023 HostingBE
 */

namespace HostingBE\Autodiscover\App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;

class MobileConfig {

protected $view;
protected $logger;
protected $settings;


public function __construct(Twig $view,$logger,$settings) {
      $this->view = $view; 
      $this->logger = $logger;
      $this->settings = $settings;
      }

/**
 * handles mobileconfig requests
 */
public function show(Request $request,Response $response) {

if ($request->getQueryParams()) {
      if (isset($request->getQueryParams()['email'])) {
      $email = $request->getQueryParams()['email'];
      }
}

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


$imap['imapssl'] = "false";
if ($imap['ssl'] == "on")  { $imap['imapssl'] = "true"; }

$pop['popssl'] = "false";
if ($pop['ssl'] == "on")  { $pop['popssl'] = "true"; }

$pop['smtpssl'] = "false";
if ($smtp['ssl'] == "on")  { $smtp['smtpssl'] = "true"; }

$filename = $domain.'.mobileconfig';

$xml = $this->view->fetch('/xml/mobile.xml',['email' => $email, 'domain' => $domain, 'info'=> $info, 'imap' => $imap,'pop'=> $pop,'smtp' => $smtp]);

$this->logger->info(get_class() . ': mobileconfig file request for email address' . $email);
      
$response->getBody()->write($xml);
return $response->withHeader('Content-Type', 'application/x-apple-aspen-config; charset=utf-8')->withHeader('Content-Disposition','attachment; filename="'.$filename.'"');
      }
private function getName($email) { 
      return explode('@',$email)[0];
      }

private function getDomain($email) { 
      return explode('@',$email)[1];
      }


}

?>