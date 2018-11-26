<?php
defined('myshop') or die('Доступ запрещен!');

?>
<div id="block-parameter">
    <p class="header-title">Поиск по параметрам</p>
    <p class="title-filter">Стоимость</p>
    <form method="get" action="search_filter.php">
        <div id="block-input-price">
            <ul>
                <li><p>от</p></li>
                <li><input type="text" id="start-price" name="start_price" value="1"></li>
                <li><p>до</p></li>
                <li><input type="text" id="end-price" name="end_price" value="1000"></li>
                <li><p>грн</p></li>
            </ul>
        </div>
        <div id="block-trackbar">
        <script type="text/javascript">
            $('#block-trackbar').trackbar(
                {
                    onMove : function() {
                        document.getElementById("start-price").value = this.leftValue;
                        document.getElementById("end-price").value = this.rightValue;
                    },
                    width : 160,
                    leftLimit : 50,
                    leftValue : <?php
                    if ((int)isset($_GET["start_price"]) && (int)$_GET["start_price"]>=50 && (int)$_GET["start_price"]<=1000) {
                        echo (int)$_GET["start_price"];
                    } else
                        echo "50";

                    ?> ,
                    rightLimit : 1000,
                    rightValue : <?php
                    if ((int)isset($_GET["end_price"]) && $_GET["end_price"]>=50 && $_GET["end_price"]<=1000) {
                        echo (int)$_GET["end_price"];
                    } else {
                        echo '700';
                    }
                    ?>,
                    roundUp : 10
                },
                "block-trackbar"
            );

        </script>
        </div>
        <p class="title-filter">Производители</p>
        <ul class="checkbox-brand">
            <?php
            mysqli_set_charset($link, "UTF8");
            $result = mysqli_query($link,"SELECT * FROM category");
            if (mysqli_num_rows($result)>0){
                $row = mysqli_fetch_array($result);
                do {
                    $checked_brand = "";
                    if (isset($_GET["brand"])){
                        if (in_array($row["id"],$_GET["brand"])){
                            $checked_brand = "checked";
                        }
                    }

                    echo "<li><input ".$checked_brand." type='checkbox' name='brand[]' value='".$row['id']."' id='check-brand".$row['id']."'/>
<label for='check-brand'".$row['id'].">".$row['brand']."</label></li>";
                } while ($row = mysqli_fetch_array($result));
            }
            ?>

        </ul>
        <center><input type="submit" name="submit" id="button-param-search" value="Поиск"/></center>
    </form>
</div>