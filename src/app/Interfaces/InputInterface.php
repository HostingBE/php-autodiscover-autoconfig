<?php

/**
 * @author Constan van Suchtelen van de Haere <constan@hostingbe.com>
 * @copyright 2023 HostingBE
 */

namespace HostingBE\Autodiscover\App\Interfaces;

interface InputInterface {

public function getimap();

public function getpop3();

public function getsmtp();

}


?>