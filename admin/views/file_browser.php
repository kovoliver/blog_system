<?php
    use Models\Files as Files;
    require "../models/init.php";
    $files = new Files();
    if(isset($_POST["fileUpload"])) {
        $files->UploadFiles();
    }
    if(isset($_POST["delete_images"])) {
        $files->DeleteFiles();
    }
    $images = $files->GetFiles("image");
    $fileFiles = $files->GetFiles("file");
    
?>
<!DOCTYPE html>
<html>
<?php
    $baseUrl = $_SERVER['SERVER_PROTOCOL'] == 'HTTP/1.1' ? 'http://' : 'https://'; 
    $baseUrl .= $_SERVER['HTTP_HOST'];
    if($_SERVER['HTTP_HOST'] == 'localhost')
        $baseUrl .= '/blog/admin';
    else 
        $baseUrl .= '/admin';
    include "../common/head.php";
?>
<body>
    <main>
        <h1>Feltöltés</h1>
        <form method="POST" action="" enctype="multipart/form-data">
            <input type="file" class="input" name="files[]" multiple>

            <button class="input" name="fileUpload">feltöltés</button>
        </form>

        <h2>Képek</h2>
        <form method="POST" action="">
            <?php foreach($images as $image) { ?>
                <div class="file_cube">
                    <h4 style="min-height:40px;"><?=$image["filename"]?></h4>
                    <label>
                        <img src="<?=$baseUrl . "/uploads/" . $image["filename"]?>">
                        <input type="checkbox" style="display:block;margin:150px auto;" value="<?=$image["file_id"]?>" name="fileid[]">
                    </label>
                    <button type="button" class="input image_button" filename="<?=$baseUrl?>/uploads/<?=$image["filename"]?>" style="margin-top:-130px;">küldés</button>
                    <input type="text" class="input" style="width:140px;" value="<?=$baseUrl?>/uploads/<?=$image["filename"]?>">
                </div>
            <?php } ?>
            <div class="clearfix" style="height:80px;"></div>

            <button class="input" name="delete_images">törlés</button>
        </form>

        <h2>Fájlok</h2>
        <form method="POST" action="">
            <?php foreach($fileFiles as $file) { ?>
                <div class="file_cube files_height">
                    <h4 style="min-height:40px;"><?=$file["filename"]?></h4>
                    <label>
                    <?php
                        $fontAwesome = "";
                        $extension = pathinfo($file["filename"], PATHINFO_EXTENSION);
                        switch($extension) {
                            case "docx":
                                $fontAwesome = "fa-file-word";
                                break;
                            case "xlsx":
                                $fontAwesome = "fa-file-excel";
                                break;
                            case "pdf":
                                $fontAwesome = "fa-file-pdf";
                                break;
                            case "rar":
                                $fontAwesome = "fa-file-archive";
                                break;
                        }
                    ?>
                        <div style="text-align:center;font-size:16px;">
                            <i class="far <?=$fontAwesome?>"></i>
                        </div>
                        <input type="checkbox" style="display:block;margin:20px auto;" value="<?=$file["file_id"]?>" name="fileid[]">
                    </label>
                    <button type="button" class="input image_button" filename="<?=$baseUrl?>/uploads/<?=$file["filename"]?>" style="margin-top:32px;">küldés</button>
                    <input type="text" class="input" style="width:140px;" value="<?=$baseUrl?>/uploads/<?=$file["filename"]?>">
                </div>
            <?php } ?>
            
            <div class="clearfix"></div>

            <button class="input" name="delete_images">törlés</button>
        </form>
    </main>
</body>
</html>