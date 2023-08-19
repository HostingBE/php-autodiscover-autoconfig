<?php

/**
 * @author Constan van Suchtelen van de Haere <constan@hostingbe.com>
 * @copyright 2023 HostingBE
 */

namespace HostingBE\Autodiscover\App\Interfaces;

use PDO;


class dbaseInterface implements InputInterface {

protected $settings;
protected $records;
protected $email;


public function __construct($settings, $email) {
	$this->settings = $settings;
	$this->email = $email;
    $this->records = $this->getrecords();
	}

private function getrecords() {

list($email, $domain) = explode('@', $this->email);

$sql = $this->db()->prepare("SELECT b.hostname,b.imapprotocol,b.imapport,b.popprotocol,b.popport,b.calendar,b.smtp,b.smtpprotocol,b.smtpport FROM emails AS a LEFT JOIN servers AS b ON b.id=a.server LEFT JOIN domains AS c ON c.id=a.domain WHERE a.email=:email AND c.domain=:domain");
$sql->bindparam(":domain",$domain,PDO::PARAM_STR);
$sql->bindparam(":email",$email,PDO::PARAM_STR);
$sql->execute();
$serverinfo = $sql->fetch(PDO::FETCH_OBJ);
if (!is_object($serverinfo)) {
	die("No such email " . $this->email . " found");
	}


return $serverinfo;	
}


public function getimap() {

if ($this->records->imapprotocol == 'ssl') {
	$ssl = 'on';
	}

return array('host' => $this->records->hostname,'port' => $this->records->imapport,'encryption' => $this->records->imapprotocol,'ssl'=> $ssl);	
}

public function getpop3() {
	
	if ($this->records->popprotocol == 'ssl') {
	$ssl = 'on';
	}

	return array('host' => $this->records->hostname,'port' => $this->records->popport,'encryption' => $this->records->popprotocol,'ssl'=> $ssl);	
}


public function getsmtp() {
	if ($this->records->smtpprotocol == 'ssl') {
	$ssl = 'on';
	}
	return array('host' => $this->records->smtp,'port' => $this->records->smtpport,'encryption' => $this->records->smtpprotocol,'ssl'=> $ssl);		
	}

private function db() {
       try {
       $db = new PDO('mysql:host='.$this->settings['host'].';dbname='.$this->settings['database'],$this->settings['username'],$this->settings['password']);
       } catch (\Exception $e) {
       echo 'Error: database connection error ',  $e->getMessage() , "\n";
       exit;
       }
       return $db;
    }


}


?>