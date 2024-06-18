<?php

function getGoodsFromDatabase($connect)
{
    $sql = "SELECT id, filename FROM good";

    if (!($result = mysqli_query($connect, $sql))) {
        outputMessage("An error ocurred when getting goods from the database");
    }

    return $result;
}

function addGoodToBasket()
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST["id"];

        if (!in_array($id, $_SESSION["goods"])) {
            $_SESSION["goods"][] = $id;
        }
    }
}

function getGoodsFromBasket($connect)
{
    foreach ($_SESSION["goods"] as $id) {
        if (!isset($id_list)) {
            $id_list = "";
        } else {
            $id_list .= ",";
        }
        $id_list .= "'" . $id . "'";
    }

    if (isset($id_list) && $id_list != "") {
        $sql = "SELECT id, filename FROM good WHERE id IN (" . $id_list . ")";

        if (!($result = mysqli_query($connect, $sql))) {
            outputMessage("An error ocurred when getting goods from the cart");
        }
    } else {
        $result = false;
    }

    return $result;
}

function removeGoodFromBasket()
{
    if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST["remove-item-form"]))) {
        $id = $_POST["id"];

        if (in_array($id, $_SESSION["goods"])) {
            $_SESSION["goods"] = array_diff($_SESSION["goods"], [$id]);
        }
    }
}

function placeOrder($connect)
{
    if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST["place-order-form"]))) {
        $items = implode(" ", $_SESSION["goods"]);

        if ($items == "") {
            return;
        }

        $sql = "INSERT INTO `order` (user_id, items) VALUES ('" . $_SESSION["user_id"] . "', '" . $items . "')";

        $result = mysqli_query($connect, $sql);

        if ($result == false) {
            echo 'Ошибка размещения заказа';
            return;
        }

        $_SESSION["goods"] = [];
    }
}

function printOrders($connect)
{
    if ((isset($_SESSION["user_id"])) && (isset($_SESSION["is_admin"]))) {
        if ($_SESSION["is_admin"] == true) {

            $sql = "SELECT `order`.id, login, items FROM `order` LEFT JOIN user ON `order`.user_id = user.id";

            if (!($result = mysqli_query($connect, $sql))) {
                outputMessage("An error ocurred when getting orders from the database");
                return;
            }

            while ($row = mysqli_fetch_assoc($result)) {
                echo 'Order No. ' . $row['id'] . ' by ' . $row['login'] . ' for items ' . $row['items'] . '<br>';
            }
        } else {
            $sql = "SELECT id, items FROM `order` WHERE user_id = " . $_SESSION["user_id"];

            if (!($result = mysqli_query($connect, $sql))) {
                outputMessage("An error ocurred when getting orders from the database");
                return;
            }

            while ($row = mysqli_fetch_assoc($result)) {
                echo 'Order No. ' . $row['id'] . ' for items ' . $row['items'] . '<br>';
            }
        }
    }
}

function outputMessage($message)
{
    echo $message . "<br>";
}

function register($connect)
{
    if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST["register-form"]))) {
        $login = htmlspecialchars($_POST["login"]);
        $password = htmlspecialchars($_POST["password"]);
        $password2 = htmlspecialchars($_POST["password2"]);

        if ($password != $password2) {
            echo 'Пароли не совпадают';
            return;
        }

        $password = md5($password);

        $sql = "SELECT id FROM user WHERE login = '" . $login . "'";

        $result = mysqli_query($connect, $sql);

        if (mysqli_affected_rows($connect) > 0) {
            echo 'Введённый логин уже зарегистрирован';
            return;
        }

        $sql = "INSERT INTO user (login, password, is_admin) VALUES ('" . $login . "', '" . $password . "', 0)";

        $result = mysqli_query($connect, $sql);

        if ($result == false) {
            echo 'Ошибка регистрации пользователя';
            return;
        }

        $_SESSION["user_id"] = mysqli_insert_id($connect);
        $_SESSION["user_login"] = $login;
        $_SESSION["is_admin"] = 0;
    }
}

function login($connect)
{
    if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST["login-form"]))) {
        $login = htmlspecialchars($_POST["login"]);
        $password = md5(htmlspecialchars($_POST["password"]));

        $sql = "SELECT id, login, is_admin FROM user WHERE login = '" . $login . "' AND password = '" . $password . "'";

        $result = mysqli_query($connect, $sql);

        if ($result != false) {
            $row = mysqli_fetch_assoc($result);
            if ($row != false) {
                $_SESSION["user_id"] = $row["id"];
                $_SESSION["user_login"] = $row["login"];
                $_SESSION["is_admin"] = $row["is_admin"];
            }
        }
    }
}

function logout($connect)
{
    if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST["logout-form"]))) {
        unset($_SESSION["user_id"]);
        unset($_SESSION["user_login"]);
        unset($_SESSION["is_admin"]);
    }
}
