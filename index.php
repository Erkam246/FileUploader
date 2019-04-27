<?php
include_once "config.php";

if(!isset($_GET["id"])){
    include_once "pages/404.php";
    return;
}
$id = $_GET["id"];
if(strlen($id) !== 16){
    include_once "pages/404.php";
    return;
}
if(!fileIdExist($id)){
    include_once "pages/404.php";
    return;
}
$file = getFileById($id);
?>
<html lang="deu">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="File: <?= $file->filename ?>">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">
    <title><?= $title ?> » <?= $file->name ?></title>
</head>
<body ondragstart="return false;" oncontextmenu="return false;" class="noselection">
<div class="highlight-clean">
    <div class="container">
        <div class="intro">
            <h4 class="text-monospace text-center"><?= $file->filename ?></h4>
            <p class="text-monospace text-center border rounded shadow">File Informations:<br>
                File uploaded at: <?= date("d.m.Y H:i", filemtime($file->correctpath)) ?><br>
                File Size: <?= number_format(round($file->size / 1024, 3), 3, ".", ".") ?> KB
            </p>
        </div>
        <div class="buttons">
            <a class="btn btn-light text-white bg-dark" role="button" href="<?= $file->correctpath ?>" download>Download</a>
        </div>
        <?php
        if($preview){
            if($file->isImage){
                ?>
                <div class="text-center">
                    <p>Image Preview:</p>
                    <img src="<?= $file->correctpath ?>" alt="" class="img-thumbnail w-auto">
                </div>
                <?php
            }elseif($file->isCode){
                ?>
                <div>
                    <div class="text-center">
                        <p>Code Preview:</p>
                    </div>
                    <div class="card card-body">
                        <p><?= highlight_file($file->correctpath, true) ?></p>
                    </div>
                </div>
                <?php
            }elseif($file->isAudio){
                ?>
                <div class="text-center">
                    <p>Audio Preview:</p>
                    <audio src="<?= $file->correctpath ?>" controls></audio>
                </div>
                <?php
            }
        }
        ?>
    </div>
</div>
</body>
</html>