<?php

require_once "config.php";

class File {
    public $isImage = false, $isCode = false, $isAudio = false;
    public $id = "", $insertid = 0, $filename = "", $name = "", $extension = "", $correctpath = "", $size = 0;

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
        $this->correctpath = $path.DIRECTORY_SEPARATOR.$this->id.DIRECTORY_SEPARATOR.urlencode($this->filename);
        $this->size = filesize($this->correctpath);
        $info = pathinfo($this->correctpath);
        $imgtype = ["png", "jpg", "jpeg"];
        $codetype = ["php"];
        $audiotype = ["mp3"];
        if(isset($info["extension"])){
            $ext = $info["extension"];
            $explode = explode(".".$ext, $this->filename);
            $this->name = $explode[0];
            if(in_array($ext, $imgtype)){
                $this->isImage = true;
            }elseif(in_array($ext, $codetype)){
                $this->isCode = true;
            }elseif(in_array($ext, $audiotype)){
                $this->isAudio = true;
            }
            $this->extension = $ext;
        }else{
            $this->name = $this->filename;
        }
    }
}