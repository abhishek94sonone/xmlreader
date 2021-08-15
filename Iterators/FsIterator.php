<?php

class FsIterator implements Iterator {
	private $position = 0;
	private $array = [];
	private $folders = [FOLDER_LOCATION];

	public function __construct()
	{
        $this->position = 0;
    }

    public function rewind()
    {
        $this->position = 0;
        $this->array = [];
        $folder = array_shift($this->folders);
        if(!empty($folder)) {
	        $this->listDirectories($folder);
            if(!count($this->array)) {
                $this->rewind();
            }
        }
    }

    public function current()
    {
        return $this->array[$this->position];
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        ++$this->position;
    }

    public function valid()
    {
    	if(!array_key_exists($this->position, $this->array)) {
    		$this->rewind();
    	}
        return isset($this->array[$this->position]);
    }

    private function listDirectories($location = FOLDER_LOCATION)
    {
    	foreach(scandir($location) as $file) {
    		if(in_array($file, [".", ".."])){
    			continue;
    		}
			$name = $location.DIRECTORY_SEPARATOR.$file;
			$type = mime_content_type($name);

			// processing files (non empty)
			if(!is_dir($name) && stripos($type, "empty")===false){
				$this->array[] = $name;
			} elseif(is_dir($name)) {
				$this->folders[] = $name;
			}
    	}
    }

    public function setFolders(array $folders=[]) {
    	$this->folders = array_merge($this->folders, $folders);
    	return $this;
    }
}