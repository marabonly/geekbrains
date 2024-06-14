<?php
session_start();

if (!isset($_SESSION["goods"])) {
    $_SESSION["goods"] = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php require("php/config.php"); ?>
    <?php require("php/functions.php"); ?>

    <div class="menu">
        <a href="index.php"><img src="/images/goods.png"></a>
        <a href="cart.php"><img src="/images/cart.png"></a>
    </div>

    <h1>Все товары</h1>

    <?php
    addGoodToBasket();
    ?>

    <div class="grid-container">
        <?php
        $result = getGoodsFromDatabase($connect);

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="grid-item">';
            echo '<img src="/images/' . $row['filename'] . '">';
            echo '<form method="POST">';
            echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
            echo '<button>Добавить в корзину</button>';
            echo '</form>';
            echo '</div>';
        }
        ?>
    </div>

</body>

</html>