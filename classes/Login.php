<?php

class Login implements Controller
{
	public function __construct($var=[]){
	}	

	public function index($var=[]){
		ob_start();

		include dirname(__FILE__, 2).DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."login.php";

		$page = ob_get_contents();
		ob_get_clean();

		return $page;
	}
}