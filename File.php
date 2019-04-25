<?php

require_once "config.php";

class File {
    public $isImage = false;
    public $id = "", $insertid = 0, $filename = "", $name = "", $extension = "", $correctpath = "";

    public function __construct(string $id){
        global $mysql;
        $query = $mysql->query("SELECT * FROM fileupload WHERE f_dir = '$id'");
        $row = $query->fetch_row();
        $this->insertid = (int)$row[0];
        $this->filename = $row[1];
        $this->id = $id;
        $this->check();
    }

    public function check(): void{
        global $path;
        $this->correctpath = $path.DIRECTORY_SEPARATOR.$this->id.DIRECTORY_SEPARATOR.$this->filename;
        $explode = explode(".", $this->filename);
        if(empty($explode))
            $this->name = $this->filename;
        else
            $this->name = $explode[0];
        $info = pathinfo($this->correctpath);
        $imgtype = ["png", "jpg", "jpeg"];
        $ext = $info["extension"];
        if(in_array($ext, $imgtype)){
            $this->extension = $ext;
            $this->isImage = true;
        }
    }
}