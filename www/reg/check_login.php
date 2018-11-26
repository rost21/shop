<?php
define('myshop', true);
include "../include/db_connect.php";
include "../functions/functions.php";
/*if (isset($_POST["reg_login"])){
    $login = $_POST["reg_login"];
} else {
    $login = "";
}*/
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $login = clear_string($_POST["reg_login"]);


    $result = mysqli_query($link, "SELECT login FROM reg_user WHERE login = '$login'");
    if (mysqli_num_rows($result) > 0) {
        echo false;
    } else {
        echo 'true';
    }
}
?>