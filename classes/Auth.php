<?php

Class Auth
{

	public function authenticate(string $username, string $pass)
	{
		$errors = [];
		$response = [];
		if($username!==AUTH_USER) {
			$errors["username"]="User $username not found";
		}else {
			$response['username'] = $username;
		}
		if(!count($errors) && hash('sha256', $pass)!==AUTH_PASS) {
			$errors["password"]="Password incorrect";
		}

		if(!count($errors)) {
			$response = ['status'=> 'success'];
			$_SESSION['username'] = "admin";
		}else{
			$response['error'] = $errors;
			$response['status'] = 'error';
		}

		return $response;
	}

	public static function getSession()
	{
		if((isset($_SESSION['username']) && !empty($_SESSION['username']))) {
			return $_SESSION;
		}
		return false;
	}

	public static function logout(){
		session_destroy();
		header("location:/xmlreader");
		exit;
	}
}
?>