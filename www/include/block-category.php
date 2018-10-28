<div id="block-category">
    <p class="header-title">Категории товаров</p>
    <ul>
        <li><a id="index1"><img src="images/topor.png" width="30px" id="topor-images"/>Топоры</a></li>
            <ul class="category-section">
                <li><a href="view_cat.php?type=topor"><strong>Все модели</strong></a></li>
                <?php
                    $result = mysqli_query($link,"SELECT * FROM category WHERE type='topor'");
                    if (mysqli_num_rows($result)>0) {
                        $row = mysqli_fetch_array($result);
                        do {
                            echo '<li><a href="view_cat.php?cat='.strtolower($row["brand"]).'&type='.$row["type"].'">'.$row["brand"].'</a></li>';
                        } while ($row = mysqli_fetch_array($result));
                    }
                ?>
            </ul>
        <li><a id="index2"><img src="images/lopata.png" width="30px" id="lopata-images"/>Лопаты</a></li>
            <ul class="category-section">
                <li><a href="view_cat.php?type=lopata"><strong>Все модели</strong></a> </li>
                <?php
                $result = mysqli_query($link,"SELECT * FROM category WHERE type='lopata'");
                if (mysqli_num_rows($result)>0) {
                    $row = mysqli_fetch_array($result);
                    do {
                        echo '<li><a href="view_cat.php?cat='.strtolower($row["brand"]).'&type='.$row["type"].'">'.$row["brand"].'</a></li>';
                    } while ($row = mysqli_fetch_array($result));
                }
                ?>
            </ul>
        <li><a id="index3"><img src="images/grabli.png" width="30px" id="grabli-images"/>Грабли</a></li>
            <ul class="category-section">
                <li><a href="view_cat.php?type=grabli"><strong>Все модели</strong></a> </li>
                <?php
                $result = mysqli_query($link,"SELECT * FROM category WHERE type='grabli'");
                if (mysqli_num_rows($result)>0) {
                    $row = mysqli_fetch_array($result);
                    do {
                        echo '<li><a href="view_cat.php?cat='.strtolower($row["brand"]).'&type='.$row["type"].'">'.$row["brand"].'</a></li>';
                    } while ($row = mysqli_fetch_array($result));
                }
                ?>
            </ul>
    </ul>
</div>