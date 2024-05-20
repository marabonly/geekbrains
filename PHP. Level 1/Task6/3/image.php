<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        .review-line {
            margin-bottom: 10px;
        }

        .review-line label {
            display: inline-block;
            width: 100px;
        }

        .review-line input,
        .review-line textarea,
        .review-line span {
            display: inline-block;
            width: 250px;
        }

        .review-line textarea {
            min-height: 50px;
        }

        .review-submit {
            left: 50%;
        }
    </style>
</head>

<body>

    <?php require("php/config.php"); ?>
    <?php require("php/functions.php"); ?>

    <h2>
        <a href="index.php">Вернуться назад</a>
    </h2>

    <?php
    if (!isset($_GET['id'])) {
        echo 'Не выбрана картинка';
        exit;
    }

    $image_id = htmlspecialchars($_GET['id']);

    if ($result = getImageById($connect, $_GET['id'])) {
        $row = mysqli_fetch_assoc($result);

        $path = $row['path'];
        $views = $row['views'];

        echo '<img src="' . $path . '">';

        updateImageViews($connect, $_GET['id'], $views + 1);

        echo '<p>' . getWordingForViews($views) . '</p>';
    }
    ?>

    <?php
    if (isset($_POST['message'])) {
        $form_next_id = htmlspecialchars($_POST['form_next_id']);
        $name = htmlspecialchars($_POST['name']);
        $message = htmlspecialchars($_POST['message']);

        if (($name != '') && ($message != '')) {
            addReviewToDatabase($connect, $form_next_id, $image_id, $name, $message);
        }
    }
    ?>

    <h3>Отзывы</h3>

    <?php

    $result = getReviewsFromDatabase($connect, $image_id);

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="review-line">';
        echo '<label>Имя</label>';
        echo '<span>' . $row['name'] . '</span>';
        echo '</div>';

        echo '<div class="review-line">';
        echo '<label>Дата</label>';
        echo '<span>' . $row['date'] . '</span>';
        echo '</div>';

        echo '<div class="review-line">';
        echo '<label>Отзыв</label>';
        echo '<span>' . $row['message'] . '</span>';
        echo '</div>';

        echo '<br>';
    }

    $next_id = 1;

    if ($result = getNextIDForReviews($connect)) {
        $row = mysqli_fetch_assoc($result);
        $next_id = $row["AUTO_INCREMENT"];
    }

    ?>

    <h3>Оставить отзыв:</h3>

    <form method="post">

        <input type="hidden" name="form_next_id" value="<?= $next_id; ?>" />

        <div class="review-line">
            <label for="name">Имя</label>
            <input type="text" id="name" name="name">
        </div>

        <div class="review-line">
            <label for="message">Сообщение</label>
            <textarea id="message" name="message"></textarea>
        </div>

        <div class="review-submit">
            <input type="submit" value="Отправить">
        </div>

    </form>

</body>

</html>