<?php

//TITLE in Browser Tab
$title = "FileUploader";

//MySQL Configuration
$myconf = [
    "Host" => "localhost",
    "User" => "fileupload",
    "Password" => "yourpassword",
    "DataBase" => "fileupload",
    "Port" => 3306,
];

//PATH WHERE EVERYTHING WILL BE SAVED
$path = "uploads";

//Image / Code / Audio preview
$preview = true;

require_once "File.php";

$mysql = mysqli_connect($myconf["Host"], $myconf["User"], $myconf["Password"], $myconf["DataBase"], $myconf["Port"]);
if(!$mysql->ping()){
    echo "An MySQL error occurred. Please recheck your configuration!";
    return;
}

$mysql->query("CREATE TABLE IF NOT EXISTS ".$myconf["DataBase"].".fileupload ( `f_id` INT NOT NULL AUTO_INCREMENT, `f_name` VARCHAR(255) NOT NULL, `f_dir` VARCHAR(32) NOT NULL, PRIMARY KEY (`f_id`)) ENGINE = InnoDB;", MYSQLI_USE_RESULT);

function fileIdExist(string $id): bool{
    global $mysql;
    $stmt = $mysql->prepare("SELECT * FROM fileupload WHERE f_dir = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $rows = $stmt->get_result()->num_rows;
    $stmt->close();
    return $rows === 1;
}

function getFileById(string $id): File{
    return new File($id);
}

function createNewLink(string $file, string $dir): string{
    global $mysql;
    $insert = $mysql->prepare("INSERT INTO fileupload (f_name, f_dir) VALUES (?, ?)");
    $insert->bind_param("ss", $file, $dir);
    $insert->execute();
    $insert->close();
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