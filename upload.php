<?php
include_once "config.php";
?>
<html lang="deu">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Form-Clean.css">
    <title><?= $title ?> » Upload</title>
</head>
<body>
<div class="login-clean" style="background-color: #ffffff;">
    <form class="bg-white border rounded shadow-lg" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <div class="custom-file" id="customFile">
                <input type="file" class="custom-file-input" id="fileInput" aria-describedby="fileUploader" name="file">
                <label class="custom-file-label" for="fileInput">Select file...</label>
            </div>
            <p class="alert-info mt-4">Max. Upload Limit: <?= ini_get("upload_max_filesize"); ?></p>
        </div>
        <div class="form-group">
            <button class="btn btn-danger btn-block btn-sm text-monospace" type="submit" name="uploaded">Upload</button>
        </div>
        <?php
        if(isset($_POST["uploaded"])){
            $tempname = $_FILES["file"]["tmp_name"];
            $fname = basename($_FILES["file"]["name"]);
            if(strlen($fname) >= 255)
                return;
            $id = generateRandomId();
            mkdir(__DIR__.DIRECTORY_SEPARATOR.$path.DIRECTORY_SEPARATOR.$id);
            if(move_uploaded_file($tempname, __DIR__.DIRECTORY_SEPARATOR.$path.DIRECTORY_SEPARATOR.$id.DIRECTORY_SEPARATOR.urlencode($fname))){
                $link = createNewLink(basename($fname), $id);
                ?>
                <a class="alert-warning" target="_blank" href="<?= $link ?>"><?= $link ?></a>
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
<script src="assets/js/jquery-3.4.1.js"></script>
<script>
    $(".custom-file-input").on("change", function(){
        let fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>
</body>
</html>