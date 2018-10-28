<?php
include("include/db_connect.php");
include("functions/functions.php");
session_start();
include ("include/auth_cookie.php");
if (isset($_GET["cat"])){
    $cat = clear_string($_GET["cat"]);
} else {
    $cat = "";
}

if (isset($_GET["type"])){
    $type = clear_string($_GET["type"]);
} else {
    $type = "";
}


?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8"/>
    <link href="css/reset.css" rel="stylesheet" type="text/css"/>
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
    <link href="trackbar/trackbar.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="js/jcarousellite_1.0.1.js"></script>
    <script type="text/javascript" src="js/shop-script.js"></script>
    <script type="text/javascript" src="js/jquery.cookie-1.4.1.min.js"></script>
    <script type="text/javascript" src="trackbar/jquery.trackbar.js"></script>
    <title>Поиск по параметрам</title>
</head>
<body>
<div id="block-body">
    <?php
    include("include/block-header.php");
    ?>

    <div id="block-right">
        <?php
        include("include/block-category.php");
        include("include/block-parameter.php");
        //include("include/block-news.php");
        ?>
    </div>
    <div id="block-content">

        <?php

        if (isset($_GET["brand"])){
            $check_brand = implode(',',$_GET["brand"]);
        }

        $start_price = (int)$_GET["start_price"];
        $end_price = (int)$_GET["end_price"];
        $query_brand = "";
        $query_price = "";
        if (!empty($check_brand) OR !empty($end_price)){
            if (!empty($check_brand)){
                $query_brand = " AND brand_id IN ($check_brand)";
            }
            if (!empty($end_price)){
                $query_price = " AND price BETWEEN $start_price AND $end_price";
            }
        }

        $result = mysqli_query($link, "SELECT * FROM table_products  WHERE visible='1' $query_brand $query_price ORDER BY product_id DESC");
        if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);

        echo "<div id=\"block-sorting\">
            <p id=\"nav-breadcrumbs\"><a href=\"index.php\">Главная страница</a> \ <span>Все товары</span></p>
            <ul id=\"option-list\">
                <li>Вид:</li>
                <li><img id=\"style-grid\" src=\"images/grid.png\"/></li>
                <li><img id=\"style-list\" src=\"images/list.png\"/></li>
                
            </ul>
        </div>
        <ul id=\"block-tovar-grid\">";

        do {

            if ($row["image"] != "" && file_exists("./uploads/" . $row["image"])) {
                $img_path = './uploads/' . $row["image"];
                $max_width = 130;
                $max_height = 130;
                list($width, $height) = getimagesize($img_path);
                $ratioh = $max_height / $height;
                $ratiow = $max_width / $width;
                $ratio = min($ratioh, $ratiow);
                $width = intval($ratio * $width);
                $height = intval($ratio * $height);
            } else {
                $img_path = "images/no-image.png";
                $width = 150;
                $height = 150;
            }
            echo('
                        <li>
                            <div class="block-images-grid">
                                <img src="' . $img_path . '" width="' . $width . '" height="' . $height . '"/>
                            </div>
                            <p class="style-title-grid"><a href="#">' . $row["title"] . '</a></p>
                            <ul class="reviews-and-counts-grid">
                                <li><img src="images/eye_icon.png"/><p>0</p></li>
                                <li><img src="images/coments_icon.png"/><p>0</p></li>
                            </ul>
                            <a class="add-cart-style-grid">Купить</a>
                            <p class="style-price-grid"><b>' . $row["price"] . '</b> грн.</p>
                            <div class="mini-features">
                                ' . $row["mini_features"] . '
                            </div>
                        </li>
                        
                        ');
        } while ($row = mysqli_fetch_array($result));

        ?>
        </ul>
        <ul id="block-tovar-list">
            <?php
            $result = mysqli_query($link, "SELECT * FROM table_products  WHERE visible='1' $query_brand $query_price ORDER BY product_id DESC");
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result);
                do {

                    if ($row["image"] != "" && file_exists("./uploads/" . $row["image"])) {
                        $img_path = './uploads/' . $row["image"];
                        $max_width = 150;
                        $max_height = 150;
                        list($width, $height) = getimagesize($img_path);
                        $ratioh = $max_height / $height;
                        $ratiow = $max_width / $width;
                        $ratio = min($ratioh, $ratiow);
                        $width = intval($ratio * $width);
                        $height = intval($ratio * $height);
                    } else {
                        $img_path = "images/no-image.png";
                        $width = 200;
                        $height = 200;
                    }
                    echo('
                        <li>
                            <div class="block-images-list">
                                <img src="' . $img_path . '" width="' . $width . '" height="' . $height . '"/>
                            </div>
                            
                            <ul class="reviews-and-counts-list">
                                <li><img src="images/eye_icon.png"/><p>0</p></li>
                                <li><img src="images/coments_icon.png"/><p>0</p></li>
                            </ul>
                            
                            <p class="style-title-list"><a href="#">' . $row["title"] . '</a></p>
                            
                            <a class="add-cart-style-list">Купить</a>
                            <p class="style-price-list"><b>' . $row["price"] . '</b> грн.</p>
                            <div class="style-text-list">
                                ' . $row["mini_description"] . '
                            </div>
                        </li>
                        
                        ');
                } while ($row = mysqli_fetch_array($result));
            }
            } else {
                echo "<h3>Товаров этой категории нет.</h3>";
            }
            ?>
        </ul>
    </div>

    <?php
    include("include/block-footer.php");
    ?>
</div>
</body>
</html>