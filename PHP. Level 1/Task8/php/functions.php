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
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST["id"];

        if (in_array($id, $_SESSION["goods"])) {
            $_SESSION["goods"] = array_diff($_SESSION["goods"], [$id]);
        }
    }
}

function outputMessage($message)
{
    echo $message . "<br>";
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
