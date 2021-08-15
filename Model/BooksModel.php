<?php

class BooksModel {
	protected $pdo;

	public function __construct()
	{
		global $PDO;
		$this->pdo = $PDO;
	}

	public function add($data)
	{
		$stmt = $this->pdo->prepare("INSERT INTO books (auth_id, book) VALUES (?, ?)");
		try{
			$stmt->execute([$data['auth_id'], $data['book']]); 
			return $this->pdo->lastInsertId();
		}catch (Exception $e) {
			echo $e->getMessage();
		}
		return 0;
	}

	public function upsert($data)
	{
		$stmt = $this->pdo->prepare("UPDATE books SET book = ? WHERE auth_id = ? AND book = ?");
		try{
			$stmt->execute([$data['book'], $data['auth_id'], $data['book']]); 
			if($stmt->rowCount()) {
				return true;
			}else {
				$this->add($data);
				return true;
			}
		}catch (Exception $e) {
			error_log($e->getMessage());
		}
		return 0;
	}

	public function searchByAuthor($author)
	{
		$author = (trim($author))? "$author%":"%";
		$stmt = $this->pdo->prepare("SELECT a.author as author, b.book as book FROM books as b RIGHT JOIN authors as a ON a.id=b.auth_id WHERE a.author ILIKE ?");
		try{
			$stmt->execute([$author]); 
			$books_by_author = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if(!empty($books_by_author)) {
				return $books_by_author;
			}else {
				return [];
			}
		}catch (Exception $e) {
			error_log($e->getMessage());
		}
		return [];
	}

}