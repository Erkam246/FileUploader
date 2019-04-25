<?php
include_once "config.php";

if(!isset($_GET["id"])){
    include_once "pages/404.php";
    return;
}
$id = (int)$_GET["id"];
if(!is_int($id)){
    include_once "pages/404.php";
    return;
}
if(!fileIdExist($id)){
    include_once "pages/404.php";
    return;
}
$file = getFileById($id);
$filename = getFileName($id);
$fwithpath = getFileWithPath($id);
?>
<html lang="deu">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/styles.min.css">
    <title><?= $title ?> » <?= getFileName($id); ?></title>
</head>
<body>
<div class="highlight-clean">
    <div class="container">
        <div class="intro">
            <h2 class="display-2 text-monospace text-center"><?= $file ?></h2>
            <p class="text-monospace text-center border rounded shadow">File uploaded at: <?= date("d.m.Y H:i", filemtime($fwithpath)) ?></p>
        </div>
        <div class="buttons">
            <a class="btn btn-light text-white bg-dark" role="button" href="<?= $fwithpath ?>" download>Download</a>
        </div>
    </div>
</div>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>