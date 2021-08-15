<?php

class Router {

	protected $uri;
	protected $host;
	protected $method;
	protected $allowed_methods = ["GET", "POST"];
	protected $refine_words = [PROJECT_NAME, "index.php"];
	protected $class_name = "Home";
	protected $class_method = "index";

	public function __construct(string $uri='index.php', string $host='http', string $method='GET'){
		$this->uri = $uri;
		$this->host = $host;
		$this->method = $method;
	}

	public function route() {
		$parsed = parse_url($this->uri);
		$parts = array_values(
			array_filter(
				explode("/", $parsed['path'])
			)
		);

		$parts = $this->refine($parts);

		if(!empty($parts) && $parts[0] == "cron"){
			if(count($parts)<2) {
				$parts[1] = DEFAULT_CRON_CLASS;
			}
			$class = ucfirst(trim($parts[1]));
			try {
				$handler = new $class();
			} catch (Exception $e) {
				error_log(__CLASS__." ".__METHOD__." >> ".$e->getMessage());
				header("HTTP/1.1 404 Not Found", true, 404);
				exit;
			}
			$handler->exec();
		} else {
			$params = [];
			$error = [];
			if(!in_array(strtoupper($this->method), $this->allowed_methods)){
				header("HTTP/1.1 403 Forbidden", true, 403);
				exit;
			}
			if(!empty($parts)) {
				$this->class_name = "Home";
				$this->class_method = "index";
			} 
			if(Auth::getSession() === false && strtoupper($this->method)=="POST"){
				// login form
				$auth = new Auth();
				$username = $_POST['username'];
				$password = $_POST['password'];
				if(!isset($username)){
					$error['username'] = "Username Required";
				}
				if(!isset($password)){
					$error['password'] = "Password Required";
				}
				$res = $auth->authenticate($username, $password);
				if ($res['status'] == 'error') {
					unset($res['status']);
					foreach($res as $key=>$val) {
						$params[$key] = $val;
					}
				}
			} elseif (Auth::getSession() === false) {
				$this->class_name = "Login";
				$this->class_method = "index";				
			} elseif (Auth::getSession() && !empty($_REQUEST)) {
				if(array_key_exists('logout', $_REQUEST)) {
					Auth::logout();
				}
				foreach($_REQUEST as $key=>$value) {
					$params[$key]=$value;
				}
			}

			$handler = new $this->class_name();
			// viewing page
			echo $handler->{$this->class_method}($params);
		}
	}

	public function refine(array $parts): array {
		if(empty($parts)){
			return [];
		}
		$sanitized = $parts;
		$pointer = 0;
		while ($pointer<count($parts) && in_array($parts[$pointer++], $this->refine_words)) {
			array_shift($sanitized);
		}
		return $sanitized;
	}
}