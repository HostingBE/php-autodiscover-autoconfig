<?php

/**
 * @author Constan van Suchtelen van de Haere <constan@hostingbe.com>
 * @copyright 2023 HostingBE
 */

require __DIR__ . '/../../vendor/autoload.php';

require __DIR__ . '/container.php';
require __DIR__ . '/middleware.php';
require __DIR__ . '/../routes/web.php';

$app->run();

?>