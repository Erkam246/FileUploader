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
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">
    <title><?= $title ?> » <?= $file->name ?></title>
</head>
<body ondragstart="event.preventDefault();">
<div class="highlight-clean">
    <div class="container">
        <div class="intro">
            <h2 class="display-4 text-monospace text-center"><?= $file->filename ?></h2>
            <p class="text-monospace text-center border rounded shadow">File Informations: <br>File uploaded at: <?= date("d.m.Y H:i", filemtime($file->correctpath)) ?><br><?= round($file->size / 1024, 3) ?> KB</p>
        </div>
        <div class="buttons">
            <a class="btn btn-light text-white bg-dark" role="button" href="<?= $file->correctpath ?>" download>Download</a>
        </div>
        <?php
        if($file->isImage){
            ?>
            <div class="text-center">
                <p>Preview:</p>
                <img src="<?= $file->correctpath ?>" alt="" class="img-thumbnail w-25">
            </div>
            <?php
        }
        ?>
    </div>
</div>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>