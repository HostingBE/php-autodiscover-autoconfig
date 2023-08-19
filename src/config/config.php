<?php

return [
   'settings' => [ 
                   'displayErrorDetails' => true,
                   'logErrorDetails' => true,
                   'debug' => true,
                   'version' => '1.0.0',
                   'logger' => [
                   'name' => 'php-autodiscover',
                   'path' => __DIR__ . '/../logs/'.date('d-m-Y').'-app.log',
                   'level' => 'DEBUG',
                        ],
                    'db' => [
     'host' => 'localhost',
     'username' => 'research_emailre',
     'database' => 'research_emailreseller_com',
     'password' => 'fpnCcqHW7lgHAyY',
                 ],
                    'supporturl' => 'https://emailreseller.com/help-support',
                    'sitename' => 'EmailReseller',
                    'url' => 'emailreseller.com',
                    ],
         
]

?>