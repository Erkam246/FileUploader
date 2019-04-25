<?php

session_start();

$title = "FileUploader";

$host = "localhost";
$user = "fileupload";
$pw = "";
$db = "fileupload";
$path = "uploads";

$mysql = mysqli_connect($host, $user, $pw, $db);
if(!$mysql->ping()){
    echo "An MySQL error occurred. Please recheck your configuration!";
    return;
}

$mysql->query("CREATE TABLE IF NOT EXISTS `$db`.`fileupload` ( `f_id` INT NOT NULL AUTO_INCREMENT , `f_name` VARCHAR(128) NOT NULL , PRIMARY KEY (`f_id`)) ENGINE = InnoDB;", MYSQLI_USE_RESULT);

function fileIdExist(int $id): bool{
    global $mysql;
    return $mysql->query("SELECT * FROM fileupload WHERE f_id = '$id#'")->num_rows >= 1;
}

function getFileById(int $id): string{
    global $mysql;
    return $mysql->query("SELECT f_name FROM fileupload WHERE f_id = '$id#'")->fetch_row()[0];
}

function getFileName(int $id): string{
    $file = getFileById($id);
    if(strpos(".", $file) !== false){
        return explode(".", $file)[0];
    }else{
        return $file;
    }
}

function getFileWithPath(int $id): string{
    global $path;
    return $path.DIRECTORY_SEPARATOR.getFileById($id);
}

function createNewLink(string $file): int{
    global $mysql;
    $query = "INSERT INTO fileupload (f_name) VALUES ('$file')";
    $mysql->query($query);
    return $mysql->insert_id;
}