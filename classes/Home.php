<?php

class Home implements Controller
{

	public function __construct($var=[]){
		$this->book = new BooksModel();
	}	

	public function index($var=[])
	{
		if(!array_key_exists("search", $var)){
			$var['search'] = '';
		}
		$list = $this->searchByAuthor($var['search']);
		$var = array_merge($var, ['list'=>$list]);

		ob_start();

		include dirname(__FILE__, 2).DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."home.php";

		$page = ob_get_contents();
		ob_get_clean();

		return $page;
	}

	public function searchByAuthor($author)
	{
		return $this->book->searchByAuthor($author);
	}
}