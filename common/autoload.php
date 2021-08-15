<?php

// set server time to india
date_default_timezone_set('Asia/Kolkata');

include_once 'config'.DIRECTORY_SEPARATOR.'config.php';

spl_autoload_register(function ($class_name) {
	// check in classes folder otherwise raise exception
	$name = dirname(__FILE__, 2).DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.$class_name.".php";
	$iterator = dirname(__FILE__, 2).DIRECTORY_SEPARATOR.'Iterators'.DIRECTORY_SEPARATOR.$class_name.".php";
	$models = dirname(__FILE__, 2).DIRECTORY_SEPARATOR.'Model'.DIRECTORY_SEPARATOR.$class_name.".php";
	if (file_exists($name)) {
		include_once $name;
	}elseif (file_exists($iterator)) {
		include_once $iterator;
	}elseif (file_exists($models)) {
		include_once $models;
	} else {
		throw new Exception("Class $class_name not found");
	}
});
// database and router global access
include_once 'helper/Database.php';
include_once 'helper/Router.php';
include_once 'classes/Auth.php';
include_once 'classes/Interfaces/Controller.php';

$PDO = Database::connect();