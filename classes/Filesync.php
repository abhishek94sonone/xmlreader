<?php

include_once 'Interfaces/CronProcess.php';

class Filesync implements CronProcess {

	protected $author;
	protected $book;
	protected $relation = [];

	public function __construct()
	{
		$this->author = new AuthorsModel();
		$this->book = new BooksModel();
		/*global $PDO;
		// $tes = $PDO->execute("SELECT * FROM authors");
		$tes = $PDO->query("SELECT * FROM authors")->fetch();
		echo "<pre>";var_dump($tes);exit;*/
	}

	public function exec() {
		$files = new FsIterator();
		foreach($files as $file) {
			// reading file as a string
			$content = file_get_contents($file);

			try {
				// for internal xml errors
				libxml_use_internal_errors(true);
				// reading file content as xml
				$data = simplexml_load_string($content);
				
				$errors = libxml_get_errors();
	    		libxml_clear_errors();
			} catch (Exception $e) {
				error_log(__CLASS__." ".__METHOD__." >> ".$e->getMessage());
			}

			/*
			* accessing author and name parameter of the xml
			* first checking xml validity
			*/
			if(count($errors)==0 && !empty($data->book)) {
				foreach($data->book as $bookObj) {
					if(!empty($bookObj->author)) {
						if(!isset($this->relation[$bookObj->author->__toString()])) {
							$this->relation[$bookObj->author->__toString()] = array();
						}

						$book = ($bookObj->name->__toString()) ? : "";

						if(!in_array($book, $this->relation[$bookObj->author->__toString()])) {
							$this->relation[$bookObj->author->__toString()][] = $book;
						}
					}
				}
			}
		}

		foreach ($this->relation as $author_name => $books) {
			$auth_id = $this->author->getAuthorID(["name" => $author_name]);

			$books = array_filter($books);
			foreach ($books as $book) {
				$this->book->upsert(["auth_id"=>$auth_id, "book"=>$book]);
			}
		}

	}
}