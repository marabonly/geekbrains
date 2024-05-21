<?php

function resize_image($file, $w, $h, $extension, $crop = FALSE)
{
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width - ($width * abs($r - $w / $h)));
        } else {
            $height = ceil($height - ($height * abs($r - $w / $h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w / $h > $r) {
            $newwidth = $h * $r;
            $newheight = $h;
        } else {
            $newheight = $w / $r;
            $newwidth = $w;
        }
    }

    switch ($extension) {
        case "jpg":
            $src = imagecreatefromjpeg($file);
            break;
        case "png":
            $src = imagecreatefrompng($file);
            break;
        case "gif":
            $src = imagecreatefromgif($file);
            break;
    }

    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    return $dst;
}

function acceptImage($connect)
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $filename = $_FILES["image"]["name"];
        $size = $_FILES["image"]["size"];
        $tmpPath = $_FILES["image"]["tmp_name"];
        $error = $_FILES["image"]["error"];

        if ($error !== 0) return;

        $targetDirBig = "uploads/big";
        $targetFileBig = $targetDirBig . "/" . $filename;

        $extension = strtolower(pathinfo($targetFileBig, PATHINFO_EXTENSION));

        $targetDirSmall = "uploads/small";
        $targetFileSmall = $targetDirSmall . "/" . $filename;

        addBigImage($filename, $targetDirBig, $targetFileBig, $extension, $tmpPath);

        addSmallImage($targetFileBig, $targetDirSmall, $targetFileSmall, $extension);

        addImageToDatabase($connect, $filename, $targetFileBig, $size);
    }
}

function addBigImage($filename, $targetDirBig, $targetFileBig, $extension, $tmpPath)
{
    if (!file_exists($targetDirBig)) {
        mkdir($targetDirBig, 0777, true);
    }

    if (!file_exists($targetFileBig)) {

        if ($extension != "jpg" && $extension != "png" && $extension != "jpeg" && $extension != "gif") {
            outputMessage("Only JPG, JPEG, PNG & GIF files are allowed.");
            return;
        }

        if ($extension == "jpeg") {
            $extension = "jpg";
        }

        if (move_uploaded_file($tmpPath, $targetFileBig)) {
            outputMessage("The file " . htmlspecialchars($filename) . " has been uploaded.");
        } else {
            outputMessage("An error ocurred when uploading your file.");
            return;
        }
    }
}

function addSmallImage($targetFileBig, $targetDirSmall, $targetFileSmall, $extension)
{
    if (!file_exists($targetDirSmall)) {
        mkdir($targetDirSmall, 0777, true);
    }

    if (!file_exists($targetFileSmall)) {

        $smallImage = resize_image($targetFileBig, 400, 300, $extension);

        switch ($extension) {
            case "jpg":
                imagejpeg($smallImage, $targetFileSmall);
                break;
            case "png":
                imagepng($smallImage, $targetFileSmall);
                break;
            case "gif":
                imagegif($smallImage, $targetFileSmall);
                break;
        }
    }
}

function addImageToDatabase($connect, $filename, $targetFileBig, $size)
{
    $sql = "INSERT INTO image(name, path, size, views) VALUES('" . $filename . "','" . $targetFileBig . "'," . $size . ",0)";

    if (!mysqli_query($connect, $sql)) {
        outputMessage("An error ocurred when inserting the image into the database");
        return;
    }

    outputMessage("The image has been added to the database successfully.");
}

function getImagesFromDatabase($connect)
{
    $sql = "SELECT id, path, views FROM image ORDER BY views DESC";

    if (!($result = mysqli_query($connect, $sql))) {
        outputMessage("An error ocurred when getting images from the database");
    }

    return $result;
}

function getImageById($connect, $id)
{
    $sql = "SELECT path, views FROM image WHERE id = " . $id;

    if (!($result = mysqli_query($connect, $sql))) {
        outputMessage("An error ocurred when getting an image by id");
    }

    return $result;
}

function outputMessage($message)
{
    echo $message . "<br>";
}

function updateImageViews($connect, $id, $newViews)
{
    $sql = "UPDATE image SET views = " . $newViews . " WHERE id = " . $id;

    if (!($result = mysqli_query($connect, $sql))) {
        outputMessage("An error ocurred when updating image views.");
    }

    return $result;
}

function getWordingForViews($views)
{
    if (($views % 100 >= 10) && ($views % 100 <= 20))
        $word = 'просмотров';
    elseif ($views % 10 == 1)
        $word = 'просмотр';
    elseif (($views % 10 >= 2) && ($views % 10 <= 4))
        $word = 'просмотра';
    else
        $word = 'просмотров';

    return $views . ' ' . $word;
}

// REVIEWS

function addReviewToDatabase($connect, $new_id, $image_id, $name, $message)
{
    $sql = "SELECT id FROM review WHERE id = " . $new_id . " AND image_id = " . $image_id;

    if (!($result = mysqli_query($connect, $sql)) || mysqli_affected_rows($connect) > 0) {
        return;
    }

    date_default_timezone_set('UTC');

    $date = date('Y-m-d H:i:s');

    $sql = "INSERT INTO review(image_id, name, date, message) VALUES('" . $image_id . "','" . $name . "','" . $date . "','" . $message . "')";

    if (!mysqli_query($connect, $sql)) {
        outputMessage("An error ocurred when inserting a review into the database");
        return;
    }

    outputMessage("A review has been added to the database successfully.");
}

function getReviewsFromDatabase($connect, $image_id)
{
    $sql = "SELECT id, name, date, message FROM review WHERE image_id = " . $image_id;

    if (!($result = mysqli_query($connect, $sql))) {
        outputMessage("An error ocurred when getting reviews from the database");
    }

    return $result;
}

function getNextIDForReviews($connect)
{
    $sql = "SELECT AUTO_INCREMENT
            FROM  information_schema.TABLES
            WHERE TABLE_SCHEMA = 'geekbrains'
            AND   TABLE_NAME   = 'review'";

    if (!($result = mysqli_query($connect, $sql))) {
        outputMessage("An error ocurred when getting next ID for reviews");
    }

    return $result;
}
