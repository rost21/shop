<?php
defined('myshop') or die('Доступ запрещен!');

$db_host = 'localhost';
$db_user = 'admin';
$db_pass = 'admin';
$db_name = 'db_shop';

$link = new mysqli($db_host, $db_user, $db_pass, $db_name);
if (mysqli_connect_error()) {
    die('Ошибка подключения ' . mysqli_connect_error());
}
mysqli_set_charset($link, "UTF8");
?>