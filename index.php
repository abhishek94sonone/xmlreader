<?php
session_start();
// Loading config, database, router and autoload function
include_once 'common/autoload.php';

// error reporting setting
// error_reporting(E_ALL);
// ini_set("display_errors", 1);

// HTTP request parts
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$host = $_SERVER['HTTP_HOST'];

// routing for cron base url and other urls 
$router = new Router($uri, $host, $method);
$router->route();
