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
    <title>Cart</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php require("php/config.php"); ?>
    <?php require("php/functions.php"); ?>

    <div class="menu">
        <a href="index.php"><img src="/images/goods.png"></a>
        <a href="cart.php"><img src="/images/cart.png"></a>
        <a href="account.php"><img src="/images/account.png"></a>
    </div>

    <h1>Корзина</h1>

    <?php
    removeGoodFromBasket();
    placeOrder($connect);
    ?>

    <div class="grid-container">
        <?php
        $result = getGoodsFromBasket($connect);

        if ($result == false) {
            echo '<p>Нет товаров в корзине</p>';
        } else {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="grid-item">';
                echo '<img src="/images/' . $row['filename'] . '">';
                echo '<form method="POST">';
                echo '<input type="hidden" name="remove-item-form" value="">';
                echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
                echo '<button>Удалить из корзины</button>';
                echo '</form>';
                echo '</div>';
            }
        }
        ?>
    </div>

    <?php if ((isset($_SESSION["goods"])) && (count($_SESSION["goods"]) > 0)) : ?>

        <?php if (!isset($_SESSION["user_id"])) : ?>

            <div class="centered">
                <p>Чтобы оформить заказ, выполните <a href="account.php">вход в аккаунт</a></p>
            </div>

        <?php else : ?>

            <div class="centered">
                <form method="POST">
                    <input type="hidden" name="place-order-form" value="">
                    <input type="submit" value="Оформить заказ" style="font-size: 36px; width: 400px; height: 100px;">
                </form>
            </div>

        <?php endif; ?>

    <?php endif; ?>

</body>

</html>