<?php

if($_SERVER["REQUEST_METHOD"] == "POST") {
    define('myshop', true);
    include('db_connect.php');
    include('../functions/functions.php');

    $int = 0;
    $result = mysqli_query($link,"SELECT * FROM cart WHERE cart_ip = '{$_SERVER['REMOTE_ADDR']}'");
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);

        do {
            $int += ($row["cart_price"] * $row["cart_count"]);

        } while ($row = mysqli_fetch_array($result));

        echo $int;
    }
}