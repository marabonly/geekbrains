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
    <title>Account</title>
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

    <h1>Вход в аккаунт</h1>

    <?php
    register($connect);
    login($connect);
    logout($connect);
    ?>

    <div class="centered">

        <?php if (isset($_SESSION["user_login"])) : ?>

            <p>Здравствуйте, <?= ($_SESSION["is_admin"] == true) ? "администратор" : "пользователь"; ?> <?= $_SESSION["user_login"]; ?></p>

            <form method="POST">
                <input type="hidden" name="logout-form" value="">
                <div class="new-line">
                    <input type="submit" value="Выйти">
                </div>
            </form>

            <div class="centered">
                <?php printOrders($connect); ?>
            </div>

        <?php elseif ((isset($_GET["mode"])) && ($_GET["mode"] == "register")) : ?>

            <form method="POST">
                <input type="hidden" name="register-form" value="">
                <div class="new-line">
                    <label for="login">Логин</label>
                    <input id="login" name="login" required>
                </div>
                <div class="new-line">
                    <label for="password">Пароль</label>
                    <input id="password" type="password" name="password" required>
                </div>
                <div class="new-line">
                    <label for="password2">Повторите пароль</label>
                    <input id="password2" type="password" name="password2" required>
                </div>
                <div class="new-line">
                    <input type="submit" value="Зарегистрироваться">
                </div>
            </form>

            <p>Если вы уже зарегистрированы, выполните <a href="account.php">вход в аккаунт</a></p>

        <?php else : ?>

            <form method="POST">
                <input type="hidden" name="login-form" value="">
                <div class="new-line">
                    <label for="login">Логин</label>
                    <input id="login" name="login" required>
                </div>
                <div class="new-line">
                    <label for="password">Пароль</label>
                    <input id="password" type="password" name="password" required>
                </div>
                <div class="new-line">
                    <input type="submit" value="Войти">
                </div>
            </form>

            <p>Если вы не зарегистрированы, пройдите <a href="account.php?mode=register">регистрацию</a></p>

        <?php endif; ?>

    </div>

</body>

</html>