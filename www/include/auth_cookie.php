<?php
defined('myshop') or die('Доступ запрещен!');
//include('db_connect.php');

if (!isset($_SESSION['auth']) && isset($_COOKIE["rememberMe"])  ) {
    if ($_COOKIE["rememberMe"]) {

        $str = $_COOKIE["rememberMe"];
        // Вся длина строки
        $all_len = strlen($str);
        // Длина логина
        $login_len = strpos($str, '+');
        // Обрезаем строку до Плюса и получаем Логин
        $login = clear_string(substr($str, 0, $login_len));

        // Получаем пароль
        $password = clear_string(substr($str, $login_len + 1, $all_len));

        $result = mysqli_query($link, "SELECT * FROM reg_user WHERE (login = '$login' or email = '$login') AND password = '$password'");
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);

            $_SESSION['auth'] = 'yes_auth';
            $_SESSION['auth_password'] = $row["password"];
            $_SESSION['auth_login'] = $row["login"];
            $_SESSION['auth_surname'] = $row["surname"];
            $_SESSION['auth_name'] = $row["name"];
            $_SESSION['auth_patronymic'] = $row["patronymic"];
            $_SESSION['auth_address'] = $row["address"];
            $_SESSION['auth_phone'] = $row["phone"];
            $_SESSION['auth_email'] = $row["email"];

        }
    }
}
