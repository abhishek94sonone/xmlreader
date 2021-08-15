<?php

// Loading config, database, router and autoload function
include_once 'common/autoload.php';

// error reporting setting
// error_reporting(E_ALL);
// ini_set("display_errors", 1);

$handler = new Filesync();
$handler->exec();
echo "Execution completed";exit;