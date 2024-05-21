<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php require("php/config.php"); ?>
    <?php require("php/functions.php"); ?>

    <h2>
        <a href="index.php">Вернуться назад</a>
    </h2>

    <?php
    if (isset($_GET['id'])) {
        if ($result = getImageById($connect, $_GET['id'])) {
            $row = mysqli_fetch_assoc($result);

            $path = $row['path'];
            $views = $row['views'];

            echo '<img src="' . $path . '">';

            updateImageViews($connect, $_GET['id'], $views + 1);

            echo '<p>' . getWordingForViews($views) . '</p>';
        }
    }
    ?>

</body>

</html>