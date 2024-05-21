<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php require("php/config.php"); ?>
    <?php require("php/functions.php"); ?>

    <?php

    acceptImage($connect);

    ?>

    <div class="add-new-image">
        <h2>Добавить новую картинку</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="file" name="image">
            <button>Добавить</button>
        </form>
    </div>

    <div class="grid-container">
        <?php
        $result = getImagesFromDatabase($connect);

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="grid-item">';
            echo '<a href="image.php?id=' . $row['id'] . '"><img src="' . str_replace("/big/", "/small/", $row['path']) . '"></a>';
            echo '<p>' . getWordingForViews($row['views']) . '</p>';
            echo '</div>';
        }
        ?>
    </div>

</body>

</html>