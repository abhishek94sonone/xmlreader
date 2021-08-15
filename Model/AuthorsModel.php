<?php

class AuthorsModel {
	protected $pdo;
	protected $author;
	public function __construct(){
		global $PDO;
		$this->pdo = $PDO;
	}

	public function add($data) {
		$stmt = $this->pdo->prepare("INSERT INTO authors (author) VALUES (?)");
		try{
			$stmt->execute([$data['name']]); 
			return $this->pdo->lastInsertId();
		}catch (Exception $e) {
			echo $e->getMessage();
		}
		return 0;
	}
	
	public function getAuthorID($data) {
		$stmt = $this->pdo->prepare("SELECT * FROM authors WHERE author = ?");
		try{
			$stmt->execute([$data['name']]); 
			$author_info = $stmt->fetch(PDO::FETCH_ASSOC);
			if(!empty($author_info)) {
				return $author_info['id'];
			}else {
				return $this->add($data);
			}
		}catch (Exception $e) {
			error_log($e->getMessage());
		}
		return 0;
	}
}