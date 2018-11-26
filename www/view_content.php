<?php
define('myshop', true);
session_start();

include("functions/functions.php");
include("include/auth_cookie.php");
include("include/db_connect.php");

mysqli_set_charset($link, "UTF8");

if (isset($_GET['id'])) {
    $id = clear_string($_GET['id']);
} else {
    $id = "";
}

if (isset($_SESSION['count_id']) && $id != $_SESSION['count_id']) {
    $query_count = mysqli_query($link, "SELECT count FROM table_products WHERE product_id='$id'");
    $result_count = mysqli_fetch_array($query_count);

    $new_count = $result_count['count'] + 1;

    $update = mysqli_query($link, "UPDATE table_products SET count='$new_count' WHERE product_id='$id'");
}

$_SESSION['count_id'] = $id;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="css/reset.css" rel="stylesheet" type="text/css"/>
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
    <link href="fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css">
    <link href="trackbar/trackbar.css" rel="stylesheet" type="text/css"/>

    <script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" src="js/jcarousellite_1.0.1.js"></script>
    <script type="text/javascript" src="js/shop-script.js"></script>
    <script type="text/javascript" src="js/jquery.cookie-1.4.1.min.js"></script>
    <script type="text/javascript" src="trackbar/jquery.trackbar.js"></script>
    <script type="text/javascript" src="js/TextChange.js"></script>
    <script type="text/javascript" src="fancybox/jquery.fancybox.js"></script>
    <script type="text/javascript" src="js/jTabs.js"></script>
    <title>Интернет магазин</title>


    <script type="text/javascript">
        $(document).ready(function () {
            $(".image-modal").fancybox();
            $("ul.tabs").jTabs({
                content: ".tabs-content",
                animate: true,
                effect: "fade"
            });
            $(".send-review").fancybox();
        });
    </script>
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
        $result1 = mysqli_query($link, "SELECT * FROM table_products WHERE product_id='$id' AND visible='1'");
        if (mysqli_num_rows($result1) > 0) {

            $row1 = mysqli_fetch_array($result1);
            do {
                if (strlen($row1["image"]) > 0 && file_exists("./uploads/" . $row1["image"])) {
                    $img_path = './uploads/' . $row1["image"];
                    $max_width = 250;
                    $max_height = 250;
                    list($width, $height) = getimagesize($img_path);
                    $ratioh = $max_height / $height;
                    $ratiow = $max_width / $width;
                    $ratio = min($ratioh, $ratiow);

                    $width = intval($ratio * $width);
                    $height = intval($ratio * $height);
                } else {
                    $img_path = "images/no-image.png";
                    $width = 110;
                    $height = 200;
                }

                // Количество отзывов
                $query_reviews = mysqli_query($link, "SELECT * FROM table_reviews WHERE product_id = '$id' AND moderate='1'");
                $count_reviews = mysqli_num_rows($query_reviews);


                echo '
     
                    <div id="block-breadcrumbs-and-rating">
                        <p id="nav-breadcrumbs"><a href="index.php">Главная</a> \ <span>' . $row1["brand"] . '</span></p>
                    </div>
                     
                    <div id="block-content-info">
                     
                        <img src="' . $img_path . '" width="' . $width . '" height="' . $height . '" />
                         
                        <div id="block-mini-description">
                         
                            <p id="content-title">' . $row1["title"] . '</p>
                             
                            <ul class="reviews-and-counts-content">
                                <li><img src="images/eye_icon.png" /><p>' . $row1["count"] . '</p></li>
                                <li><img src="images/coments_icon.png" /><p>' . $count_reviews . '</p></li>
                            </ul>
                             
                             
                            <p id="style-price">' . $row1["price"] . ' грн
                             
                            <a class="add-cart" id="add-cart-view" dbid="' . $row1["product_id"] . '" >Купить</a></p>
                             
                            <p id="content-text">' . $row1["mini_description"] . '</p>
                     
                        </div>
                    </div>
                     
                    ';


            } while ($row1 = mysqli_fetch_array($result1));


            $result = mysqli_query($link, "SELECT * FROM uploads_images WHERE product_id='$id'");
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result);
                echo '<div id="block-img-slide">
                        <ul>
                    ';
                do {

                    $img_path = './uploads/' . $row["image"];
                    $max_width = 70;
                    $max_height = 70;
                    list($width, $height) = getimagesize($img_path);
                    $ratioh = $max_height / $height;
                    $ratiow = $max_width / $width;
                    $ratio = min($ratioh, $ratiow);

                    $width = intval($ratio * $width);
                    $height = intval($ratio * $height);


                    echo '
                            <li>
                                <a class="image-modal" rel="group" href="#image' . $row["id"] . '"><img src="' . $img_path . '" width="' . $width . '" height="' . $height . '" /></a>
                            </li>
                            <a style="display:none;" class="image-modal"  id="image' . $row["id"] . '" ><img  src="./uploads/' . $row["image"] . '" /></a>
                        ';
                } while ($row = mysqli_fetch_array($result));
                echo '
                        </ul>
                        </div>    
                    ';
            }

            $result = mysqli_query($link, "SELECT * FROM table_products WHERE product_id='$id' AND visible='1'");
            $row = mysqli_fetch_array($result);

            echo '
                        <ul class="tabs">
                            <li><a class="active" href="#" >Описание</a></li>
                            <li><a href="#" >Характеристики</a></li>
                            <li><a href="#" >Отзывы</a></li>   
                        </ul>
                         
                        <div class="tabs-content">
                         
                        <div>' . $row["description"] . '</div>
                        <div>' . $row["features"] . '</div>
                        <div>
                        <p id="link-send-review" ><a class="send-review" href="#send-review">Написать отзыв</a></p>
                        ';

            $query_reviews = mysqli_query($link, "SELECT * FROM table_reviews WHERE product_id='$id' AND moderate='1' ORDER BY id DESC");

            if (mysqli_num_rows($query_reviews) > 0) {
                $row_reviews = mysqli_fetch_array($query_reviews);
                do {

                    echo '
                        <div class="block-reviews">
                            <p class="author-date" ><strong>' . $row_reviews["name"] . '</strong>, ' . $row_reviews["date"] . '</p>
                            <img src="images/add.png" />
                            <p class="textrev" >' . $row_reviews["good_reviews"] . '</p>
                            <img src="images/minus.png" />
                            <p class="textrev" >' . $row_reviews["bad_reviews"] . '</p>
                             
                            <p class="text-comment">' . $row_reviews["comments"] . '</p>
                        </div>
                         
                        ';

                } while ($row_reviews = mysqli_fetch_array($query_reviews));
            } else {
                echo '<p class="title-no-info" >Отзывов нет</p>';
            }


            echo '
    </div>
     
    </div>
     
     
        <div id="send-review">
         
            <p align="right" id="title-review">Публикация отзыва производится после предварительной модерации.</p>
             
            <ul>
                <li><p align="right"><label id="label-name" >Имя<span>*</span></label><input maxlength="15" type="text" id="name_review" /></p></li>
                <li><p align="right"><label id="label-good" >Достоинства<span>*</span></label><textarea id="good_review" ></textarea></p></li>    
                <li><p align="right"><label id="label-bad" >Недостатки<span>*</span></label><textarea id="bad_review" ></textarea></p></li>     
                <li><p align="right"><label id="label-comment" >Комментарий</label><textarea id="comment_review" ></textarea></p></li>     
            </ul>
            <p id="reload-img"><img src="images/loading.gif"/></p>
            <p id="button-send-review" review_id="' . $id . '" >Отправить</p>
        </div>
    ';

        }
        ?>
    </div>

    <?php
    include("include/block-footer.php");
    ?>
</div>
</body>
</html>