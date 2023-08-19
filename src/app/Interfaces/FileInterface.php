<?php

/**
 * @author Constan van Suchtelen van de Haere <constan@hostingbe.com>
 * @copyright 2023 HostingBE
 */

namespace HostingBE\Autodiscover\App\Interfaces;

class FileInterface implements InputInterface {

public function getimap() {
 return array('host' => 'server05.hostingbe.com','port' => '993','encryption' => 'ssl','ssl'=> 'on');	
}

public function getpop3() {
 return array('host' => 'server05.hostingbe.com','port' => '995','encryption' => 'ssl','ssl'=> 'on');	
}


public function getsmtp() {
return array('host' => 'smtp01.emailreseller.com','port' => '465','encryption' => 'ssl','ssl'=> 'on');	
	}

}


?>