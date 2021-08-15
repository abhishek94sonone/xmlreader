<?php

class Database {

	private static $db = [];

	private final function __construct($type = "pgsql")
	{
		$name = "connect_$type";
		$conn = null;
		if(method_exists($this, $name)){
			$conn = $this->$name();
		}
		self::$db[$type] = $conn;
	}

	public static function connect($type = "pgsql")
	{
		if (empty(self::$db[$type])) {
			new Database();
		}
		return self::$db[$type];
	}

	private function connect_pgsql()
	{
		// static::$db["pgsql"]
		$dsn = "pgsql:host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME.";";
		// make a database connection
		try {
			return new PDO($dsn, DB_USER, DB_PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
		} catch (Exception $e) {
			error_log($e->getMessage());
		}
		return null;
	}

}