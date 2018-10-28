<?php

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    //define('myeshop', true);
    include('db_connect.php');
    include('../functions/functions.php');

    $login = clear_string($_POST["login"]);

    $password = md5(clear_string($_POST["password"]));
    $password = strrev($password);
    $password = strtolower("9nm2rv8q".$password."2yo6z");

    if (isset($_POST["rememberMe"]) && $_POST["rememberMe"] == "yes")
    {
        setcookie("rememberMe",$login.'+'.$password,time()+3600*24*31, "/");
    }



    $result = mysqli_query($link,"SELECT * FROM reg_user WHERE (login = '$login' OR email = '$login') AND password = '$password'");
    if (mysqli_num_rows($result) > 0)
    {
        $row = mysqli_fetch_array($result);
        session_start();
        $_SESSION['auth'] = 'yes_auth';
        $_SESSION['auth_password'] = $row["password"];
        $_SESSION['auth_login'] = $row["login"];
        $_SESSION['auth_surname'] = $row["surname"];
        $_SESSION['auth_name'] = $row["name"];
        $_SESSION['auth_patronymic'] = $row["patronymic"];
        $_SESSION['auth_address'] = $row["address"];
        $_SESSION['auth_phone'] = $row["phone"];
        $_SESSION['auth_email'] = $row["email"];
        echo true;

    }else {
        echo false;
    }
}

?>