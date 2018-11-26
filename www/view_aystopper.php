<?php
define('myshop',true);
session_start();

include("functions/functions.php");
include("include/auth_cookie.php");
include("include/db_connect.php");

mysqli_set_charset($link, "UTF8");

if (isset($_GET['go'])) {
    $go = clear_string($_GET['go']);

    switch ($go) {
        case "news":
            $query_aystopper = "WHERE visible = '1' AND new = '1'";
            $name_aystopper = "Новинки товаров";
            break;
        case "leaders":
            $query_aystopper = "WHERE visible = '1' AND leader = '1'";
            $name_aystopper = "Лидеры продаж";
            break;
        case "sale":
            $query_aystopper = "WHERE visible = '1' AND sale = '1'";
            $name_aystopper = "Распродажа товаров";
            break;
        default:
            $query_aystopper = "";
            break;
    }
}

if (isset($_GET['sort'])) {
    $sorting = $_GET['sort'];

    switch ($sorting) {
        case 'low-to-high':
            $sortingType = 'price ASC';
            $sort_name = 'По возрастанию цены';
            break;
        case 'high-to-low':
            $sortingType = 'price DESC';
            $sort_name = 'По убыванию цены';
            break;
        case 'popular':
            $sortingType = 'count DESC';
            $sort_name = 'Популярное';
            break;
        case 'news':
            $sortingType = 'datetime DESC';
            $sort_name = 'Новинки';
            break;
        default:
            $sortingType = 'product_id DESC';
            $sort_name = 'Без сортировки';
            break;
    }
} else {
    $sortingType = 'product_id DESC';
    $sorting = '';
    $sort_name = 'Без сортировки';
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="css/reset.css" rel="stylesheet" type="text/css"/>
    <link href="css/style.css" rel="stylesheet" type="text/css"/>

    <!-- load jQuery 1.8.2 -->
    <script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
    <script type="text/javascript">
        console.log($().jquery);
    </script>

    <link href="trackbar/trackbar.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="js/jcarousellite_1.0.1.js"></script>
    <script type="text/javascript" src="js/shop-script.js"></script>
    <script type="text/javascript" src="js/jquery.cookie-1.4.1.min.js"></script>
    <script type="text/javascript" src="trackbar/jquery.trackbar.js"></script>
    <script type="text/javascript" src="js/TextChange.js"></script>
    <title>Интернет магазин</title>
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
            if ($query_aystopper != ""){

            $num = 4; //Количество выводимых товаров
            if (isset($_GET['page'])) {
                $page = (int)($_GET['page']);
            } else {
                $page = 1;
            }

            $count = mysqli_query($link, "SELECT COUNT(*) FROM table_products $query_aystopper");
            $temp = mysqli_fetch_array($count);

            if ($temp[0] > 0) {
                $tempCount = $temp[0];

                //Общее число страниц
                $total = intval((($tempCount - 1) / $num) + 1);
                $total = intval($total);

                $page = intval($page);

                if (empty($page) || $page < 0) $page = 1;

                if ($page > $total) $page = $total;

                //С какого номера надо выводить
                $start = $page * $num - $num;
                $query_start_num = "LIMIT $start, $num";
            }

            if ($temp[0] > 0) {

                ?>


            <div id="block-sorting">
                <p id="nav-breadcrumbs"><a href="index.php">Главная страница</a> \ <span><?php echo $name_aystopper;?></span></p>
                <ul id="option-list">
                    <li>Вид:</li>
                    <li><img id="style-grid" src="images/grid.png"/></li>
                    <li><img id="style-list" src="images/list.png"/></li>
                    <li>Сортировка:</li>
                    <li><a id="select-sort"><?php echo $sort_name; ?></a>
                        <ul id="sorting-list">
                            <li><a href="view_aystopper.php?go=<?php echo $go; ?>&sort=low-to-high">От дешевых к дорогим</a></li>
                            <li><a href="view_aystopper.php?go=<?php echo $go; ?>&sort=high-to-low">От дорогих к дешевых</a></li>
                            <li><a href="view_aystopper.php?go=<?php echo $go; ?>&sort=popular">Популярное</a></li>
                            <li><a href="view_aystopper.php?go=<?php echo $go; ?>&sort=news">Новинки</a></li>
                            <li><a href="view_aystopper.php?go=<?php echo $go; ?>&sort=brand">От А до Я</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

            <ul id="block-tovar-grid">

            <?php

            $result = mysqli_query($link, "SELECT * FROM table_products $query_aystopper ORDER BY $sortingType $query_start_num");
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
                        $width = 150;
                        $height = 150;
                    }

                    // Количество отзывов
                    $query_reviews = mysqli_query($link,"SELECT * FROM table_reviews WHERE product_id = '{$row['product_id']}' AND moderate='1'");
                    $count_reviews = mysqli_num_rows($query_reviews);
                    echo'
                        <li>
                            <div class="block-images-grid">
                                <img src="'.$img_path.'" width="'.$width.'" height="'.$height.'"/>
                            </div>
                            <p class="style-title-grid"><a href="view_content.php?id=' . $row["product_id"] . '">'.$row["title"].'</a></p>
                            <ul class="reviews-and-counts-grid">
                                <li><img src="images/eye_icon.png"/><p>'.$row['count'].'</p></li>
                                <li><img src="images/coments_icon.png"/><p>'.$count_reviews.'</p></li>
                            </ul>
                            <a class="add-cart-style-grid" dbid="' . $row["product_id"] . '">Купить</a>
                            <p class="style-price-grid"><b>'.$row["price"].'</b> грн.</p>
                            <div class="mini-features">
                                '.$row["mini_features"].'
                            </div>
                        </li>
                        
                        ';
                } while ($row = mysqli_fetch_array($result));
            }
            ?>
        </ul>
        <ul id="block-tovar-list">
            <?php
            $result = mysqli_query($link, "SELECT * FROM table_products $query_aystopper ORDER BY $sortingType $query_start_num");
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

                    // Количество отзывов
                    $query_reviews = mysqli_query($link,"SELECT * FROM table_reviews WHERE product_id = '{$row['product_id']}' AND moderate='1'");
                    $count_reviews = mysqli_num_rows($query_reviews);
                    echo'
                        <li>
                            <div class="block-images-list">
                                <img src="'.$img_path.'" width="'.$width.'" height="'.$height.'"/>
                            </div>
                            
                            <ul class="reviews-and-counts-list">
                                <li><img src="images/eye_icon.png"/><p>'.$row['count'].'</p></li>
                                <li><img src="images/coments_icon.png"/><p>'.$count_reviews.'</p></li>
                            </ul>
                            
                            <p class="style-title-list"><a href="view_content.php?id=' . $row["product_id"] . '">'.$row["title"].'</a></p>
                            
                            <a class="add-cart-style-list" dbid="' . $row["product_id"] . '">Купить</a>
                            <p class="style-price-list"><b>'.$row["price"].'</b> грн.</p>
                            <div class="style-text-list">
                                '.$row["mini_description"].'
                            </div>
                        </li>
                        
                        ';
                } while ($row = mysqli_fetch_array($result));
            }
            echo '</ul>';
            } else {
                echo "<p>Товаров нет!</p>";
                $total =0;
            }

            } else {
                echo "<p>Данная категория не найдена!</p>";
            }
            global $pstr_prev, $pstr_next, $page1left, $page2left, $page3left, $page4left, $page5left,
                   $page1right, $page2right, $page3right, $page4right, $page5right;

            if ($page != 1) $pstr_prev = '<li><a class="pstr-prev" href="view_aystopper.php?go='.$go.'&sort=' . $sorting . '&page=' . ($page - 1) . '">&lt;</a></li>';
            if ($page != $total) $pstr_next = '<li><a class="pstr-next" href="view_aystopper.php?go='.$go.'&sort=' . $sorting . '&page=' . ($page + 1) . '">&gt;</a></li>';

            // Формируем ссылки со страницами
            if ($page - 5 > 0) $page5left = '<li><a href="view_aystopper.php?go='.$go.'&sort=' . $sorting . '&page=' . ($page - 5) . '">' . ($page - 5) . '</a></li>';
            if ($page - 4 > 0) $page4left = '<li><a href="view_aystopper.php?go='.$go.'&sort=' . $sorting . '&page=' . ($page - 4) . '">' . ($page - 4) . '</a></li>';
            if ($page - 3 > 0) $page3left = '<li><a href="view_aystopper.php?go='.$go.'&sort=' . $sorting . '&page=' . ($page - 3) . '">' . ($page - 3) . '</a></li>';
            if ($page - 2 > 0) $page2left = '<li><a href="view_aystopper.php?go='.$go.'&sort=' . $sorting . '&page=' . ($page - 2) . '">' . ($page - 2) . '</a></li>';
            if ($page - 1 > 0) $page1left = '<li><a href="view_aystopper.php?go='.$go.'&sort=' . $sorting . '&page=' . ($page - 1) . '">' . ($page - 1) . '</a></li>';

            if ($page + 5 <= $total) $page5right = '<li><a href="view_aystopper.php?go='.$go.'&sort=' . $sorting . '&page=' . ($page + 5) . '">' . ($page + 5) . '</a></li>';
            if ($page + 4 <= $total) $page4right = '<li><a href="view_aystopper.php?go='.$go.'&sort=' . $sorting . '&page=' . ($page + 4) . '">' . ($page + 4) . '</a></li>';
            if ($page + 3 <= $total) $page3right = '<li><a href="view_aystopper.php?go='.$go.'&sort=' . $sorting . '&page=' . ($page + 3) . '">' . ($page + 3) . '</a></li>';
            if ($page + 2 <= $total) $page2right = '<li><a href="view_aystopper.php?go='.$go.'&sort=' . $sorting . '&page=' . ($page + 2) . '">' . ($page + 2) . '</a></li>';
            if ($page + 1 <= $total) $page1right = '<li><a href="view_aystopper.php?go='.$go.'&sort=' . $sorting . '&page=' . ($page + 1) . '">' . ($page + 1) . '</a></li>';


            if ($page + 5 < $total) {
                $strtotal = '<li><p class="nav-point">...</p></li><li><a href="view_aystopper.php?go='.$go.'&sort=' . $sorting . '&page=' . $total . '">' . $total . '</a></li>';
            } else {
                $strtotal = "";
            }


            if ($total > 1) {
                echo '<div class="pstrnav"><ul>';
                echo $pstr_prev . $page5left . $page4left . $page3left . $page2left . $page1left . "
                <li><a class='pstr-active' href='view_aystopper.php?go='.$go.'&sort=" . $sorting . "&page=" . $page . "'>" . $page . "</a></li>" . $page1right . $page2right . $page3right . $page4right . $page5right . $strtotal . $pstr_next;
                echo '</ul></div>';
            }

        ?>

    </div>

    <?php
    include("include/block-footer.php");
    ?>
</div>
</body>
</html>