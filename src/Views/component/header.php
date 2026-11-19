<?php
require_once dirname(__DIR__, 2) . '/src/Config/env.php';
$appName = $_ENV['APP_NAME'];
?>
<h1><a href="/"><?= $appName; ?></a></h1>