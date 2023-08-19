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
     'username' => 'username',
     'database' => 'database',
     'password' => 'password',
                 ],
                    'supporturl' => 'https://yourdomain.com/help-support',
                    'sitename' => 'YourDomain',
                    'url' => 'yourdomain.com',
                    ],
         
]

?>