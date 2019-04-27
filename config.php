<?php

//TITLE in Browser Tab
$title = "FileUploader";

//MySQL Configuration
$mysql = [
    "Host" => "localhost",
    "User" => "fileupload",
    "Password" => "yourpassword",
    "DataBase" => "fileupload",
    "Port" => 3306,
];

//PATH WHERE EVERYTHING WILL BE SAVED
$path = "uploads";

//Image / Code preview
$preview = false;

require_once "File.php";

$mysql = mysqli_connect($mysql["Host"], $mysql["User"], $mysql["Password"], $mysql["DataBase"], $mysql["Port"]);
if(!$mysql->ping()){
    echo "An MySQL error occurred. Please recheck your configuration!";
    return;
}

$mysql->query("CREATE TABLE IF NOT EXISTS `$db`.`fileupload` ( `f_id` INT NOT NULL AUTO_INCREMENT , `f_name` VARCHAR(255) NOT NULL , `f_dir` VARCHAR(32) NOT NULL , PRIMARY KEY (`f_id`)) ENGINE = InnoDB;", MYSQLI_USE_RESULT);

function fileIdExist(string $id): bool{
    global $mysql;
    return $mysql->query("SELECT * FROM fileupload WHERE f_dir = '$id'")->num_rows === 1;
}

function getFileById(string $id): File{
    return new File($id);
}

function createNewLink(string $file, string $dir): string{
    global $mysql;
    $query = "INSERT INTO fileupload (f_name, f_dir) VALUES ('$file', '$dir')";
    $mysql->query($query);
    return "index.php?id=".$dir;
}

function generateRandomId(): string{
    generate:
    $abc = "abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMOPQRSTUVWXYZ";
    $string = "";
    for($i = 0; $i < 16; $i++){
        $string .= $abc[mt_rand(0, strlen($abc) - 1)];
    }
    if(fileIdExist($string)){
        goto generate;
    }
    return $string;
}