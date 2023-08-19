<?php

/**
 * @author Constan van Suchtelen van de Haere <constan@hostingbe.com>
 * @copyright 2023 HostingBE
 */


use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use HostingBE\Autodiscover\App\Controllers\MainPage;
use HostingBE\Autodiscover\App\Controllers\AutoDiscover;
use HostingBE\Autodiscover\App\Controllers\AutoConfig;
use HostingBE\Autodiscover\App\Controllers\MobileConfig;

$app->get('/', MainPage::class . ':showHomePage')->setName('mainpage.showhomepage');
$app->get('/automatic', MainPage::class . ':showAutoMatic')->setName('mainpage.showautomatic');
$app->get('/ios', MainPage::class . ':showIos')->setName('mainpage.showios');
$app->get('/manual', MainPage::class . ':showManual')->setName('mainpage.showmanual');

$app->post('/manual', MainPage::class . ':postManual');

# email mobileconfig
$app->get('/email.mobileconfig',MobileConfig::class . ':show')->setName('mobileconfig.show');

# Autoconfig thunderbird like
$app->get('/.well-known/autoconfig/mail/config-v1.1.xml',AutoConfig::class . ':show')->setName('autoconfig.show');

$app->group('/autodiscover', function($autodis) {

# Autodiscover version 1
$autodis->get('/autodiscover.json/v1.0/{email}',AutoDiscover::class . ':show_v1')->setName('autodiscover.show_v1');

# Autodiscover version 2
$autodis->post('/autodiscover.xml',AutoDiscover::class . ':show_v2')->setName('autodiscover.show_v2');
});

?>