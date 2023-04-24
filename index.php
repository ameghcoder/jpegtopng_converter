<?php

$error = $success = $preview = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_image_file = $_temp_img_path = $_img_error = $_img_type = "";
    $_image_file = $_FILES['image'];

    $_temp_img_path = $_image_file['tmp_name'];
    $_img_error = $_image_file['error'];
    $_img_type = $_image_file['type'];
    $_img_name = $_image_file['name'];

    $_img_name = explode('.', $_img_name)[0];

    $_img_ext = explode('/', $_img_type)[1];

    if ($_img_ext == 'jpg' || $_img_ext == 'jfif' || $_img_ext == 'jif') {
        $_img_ext = 'jpeg';
    }

    if ($_img_error == 0) {
        // create source file
        // create new file using source file
        // save image file

        $_source_image = $_new_image_name = $_final_image = "";
        $_new_image_name = './converted/' . $_img_name . time() . '.png';

        $_source_image = @imagecreatefromjpeg($_temp_img_path);


        if ($_source_image) {
            $_final_image = imagepng($_source_image, $_new_image_name);
            if ($_final_image) {
                $preview = $_new_image_name;
                $success = "Image converted successfully.";
            } else {
                $error = "Something went wrong. Try again.";
            }
        } else {
            $error = "Something went wrong.";
        }
    } else {
        $error = "This type of image is not supported.";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style.css">
    <title>JPEG to PNG Converter</title>
</head>

<body>
    <!-- Create a converted name folder in same directory from where this file is running -->
    <div class="container">
        <div class="container-inside">
            <h1>JPEG to PNG Converter</h1>
            <div class="message">
                <p class="error">
                    <?php
                    if ($error != "") {
                        echo $error;
                    }
                    ?>
                </p>
                <p class="success">
                    <?php
                    if ($success != "") {
                        echo $success;
                    }
                    ?>
                </p>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <input type="file" name="image" accept="image/jpeg, image/jpg, image/jfif, image/jif">
                <button type="submit">Convert</button>
            </form>
            <div class="image">
                <img src="
                <?php
                if ($preview != "") {
                    echo $preview;
                } else {
                    echo "https://i.ytimg.com/vi/7JbaXuFCYjw/maxresdefault.jpg";
                }

                ?>
                " alt="preview image">
                <a href="
                <?php
                if ($preview != "") {
                    echo $preview;
                } else {
                    echo "#";
                }
                ?>
                " download>Download</a>
            </div>
        </div>
    </div>
</body>

</html>
