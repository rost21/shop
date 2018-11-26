<script src='https://www.google.com/recaptcha/api.js'></script>
<?php
define('myshop', true);
//require_once "../recaptchalib.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    include("../include/db_connect.php");
    include("../functions/functions.php");

    if (isset($_POST['reg_login'])) {
        $login = iconv("UTF-8", "cp1251", strtolower(clear_string($_POST['reg_login'])));
    } else {
        $login = "1";
    }

    if (isset($_POST['reg_password'])) {
        $password = iconv("UTF-8", "cp1251", strtolower(clear_string($_POST['reg_password'])));
    } else {
        $password = "1";
    }

    if (isset($_POST['reg_surname'])) {
        $surname = clear_string($_POST['reg_surname']);
    } else {
        $surname = "1";
    }

    if (isset($_POST['reg_name'])) {
        $name = clear_string($_POST['reg_name']);
    } else {
        $name = "1";
    }

    if (isset($_POST['reg_patronymic'])) {
        $patronymic = clear_string($_POST['reg_patronymic']);
    } else {
        $patronymic = "1";
    }

    if (isset($_POST['reg_email'])) {
        $email = iconv("UTF-8", "cp1251", clear_string($_POST['reg_email']));
    } else {
        $email = "1";
    }

    if (isset($_POST['reg_phone'])) {
        $phone = iconv("UTF-8", "cp1251", clear_string($_POST['reg_phone']));
    } else {
        $phone = "1";
    }

    if (isset($_POST['reg_address'])) {
        $address = iconv("UTF-8", "cp1251", clear_string($_POST['reg_address']));
    } else {
        $address = "1";
    }

    $error = array();
    //mysqli_query($link,"SET NAMES 'utf8'");
    //mysqli_query($link,"SET CHARACTER SET 'utf8'");
    //mysqli_query($link,"SET SESSION collation_connection = 'utf8_general_ci'");
    //mysqli_set_charset($link,'utf-8');﻿

    if (strlen($login) < 5 or strlen($login) > 15) {
        $error[] = "Логин должен быть от 5 до 15 символов!";
    } else {
        $result = mysqli_query($link, "SELECT login FROM reg_user WHERE login = '$login'");
        if (mysqli_num_rows($result) > 0) {
            $error[] = "Логин занят!";
        }

    }

    if (strlen($password) < 7 or strlen($password) > 15) $error[] = "Укажите пароль от 7 до 15 символов!";
    if (strlen($surname) < 3 or strlen($surname) > 20) $error[] = "Укажите Фамилию от 3 до 20 символов!";
    if (strlen($name) < 3 or strlen($name) > 15) $error[] = "Укажите Имя от 3 до 15 символов!";
    if (strlen($patronymic) < 3 or strlen($patronymic) > 25) $error[] = "Укажите Отчество от 3 до 25 символов!";
    if (!preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", trim($email))) $error[] = "Укажите корректный email!";
    if (!$phone) $error[] = "Укажите номер телефона!";
    if (!$address) $error[] = "Необходимо указать адрес доставки!";

    //if($_SESSION['img_captcha'] != strtolower($_POST['reg_captcha'])) $error[] = "Неверный код с картинки!";
    //unset($_SESSION['img_captcha']);
    /*
    //секретный ключ
    $secret = "6LeS63QUAAAAAOU6hDHVWfNI7P49jiDVdecEYnP7";
    //ответ
    $response = null;
    //проверка секретного ключа
    $reCaptcha = new ReCaptcha($secret);

    if (!empty($_POST)) {

        //Валидация $_POST['name'] и $_POST['email']
        if ($_POST["g-recaptcha-response"]) {
            $response = $reCaptcha->verifyResponse(
                $_SERVER["REMOTE_ADDR"],
                $_POST["g-recaptcha-response"]
            );
        }

        if ($response != null && $response->success) {
            echo "Все хорошо.";
        } else {
            echo "Вы точно человек?";
        }

    }
    */
    if (count($error)) {
        echo implode('<br />', $error);

    } else {
        $password = md5($password);
        $password = strrev($password);
        $password = "9nm2rv8q" . $password . "2yo6z";

        $ip = $_SERVER['REMOTE_ADDR'];

        mysqli_query($link, "INSERT INTO reg_user(login,password,surname,name,patronymic,email,phone,address,datetime,ip)
                        VALUES(
                         
                            '" . $login . "',
                            '" . $password . "',
                            '" . $surname . "',
                            '" . $name . "',
                            '" . $patronymic . "',
                            '" . $email . "',
                            '" . $phone . "',
                            '" . $address . "',
                            NOW(),
                            '" . $ip . "'                          
                        )");
        echo true;
    }


}