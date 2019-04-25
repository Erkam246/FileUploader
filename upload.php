<?php
include_once "config.php";
?>
<html lang="deu">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" href="assets/upload/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/upload/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="assets/upload/css/styles.css">
    <script src="assets/js/jquery.min.js"></script>
    <title><?= $title ?> » Upload</title>
</head>
<body>
<div class="login-clean" style="background-color: #ffffff;">
    <form class="bg-white border rounded shadow-lg" method="post" enctype="multipart/form-data" action="">
        <div class="form-group">
            <input type="file" required name="file">
            <span class="alert-info">Max. Upload Limit: <?= ini_get('upload_max_filesize'); ?></span>
        </div>
        <div class="form-group">
            <button class="btn btn-primary btn-block btn-sm text-monospace" type="submit" name="uploaded">Upload
            </button>
        </div>
        <?php
        if(isset($_POST["uploaded"])){
            $fname = $_FILES["file"]["tmp_name"];
            if(move_uploaded_file($fname, __DIR__.DIRECTORY_SEPARATOR.$path.DIRECTORY_SEPARATOR.urlencode(basename($_FILES["file"]["name"])))){
                $name = basename($_FILES["file"]["name"]);
                $id = createNewLink($name);
                $link = "index.php?id=".$id;
                ?>
                <a class="card-link" href="<?= $link ?>"><?= $link ?></a>
                <?php
            }else{
                ?>
                <p class="alert-danger">Can't upload file.</p>
                <?php
            }
        }
        ?>
    </form>
</div>
</body>
</html>