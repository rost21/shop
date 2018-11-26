<?php
define('myshop', true);
session_start();

if (isset($_SESSION['auth']) && $_SESSION['auth'] == 'yes_auth') {
    include("functions/functions.php");
    include("include/db_connect.php");

    mysqli_set_charset($link, "UTF8");

    if (isset($_POST["save_submit"])) {

        $_POST["info_surname"] = clear_string($_POST["info_surname"]);
        $_POST["info_name"] = clear_string($_POST["info_name"]);
        $_POST["info_patronymic"] = clear_string($_POST["info_patronymic"]);
        $_POST["info_address"] = clear_string($_POST["info_address"]);
        $_POST["info_phone"] = clear_string($_POST["info_phone"]);
        $_POST["info_email"] = clear_string($_POST["info_email"]);

        $error = array();

        $password = md5($_POST["info_password"]);
        $password = strrev($password);
        $password = "9nm2rv8q" . $password . "2yo6z";

        if ($_SESSION['auth_password'] != $password) {
            $error[] = 'Неверный текущий пароль!';

        } else {

            if (isset($_POST["info_new_password"]) && $_POST["info_new_password"] != "") {
                if (strlen($_POST["info_new_password"]) < 7 || strlen($_POST["info_new_password"]) > 15) {
                    $error[] = 'Укажите новый пароль от 7 до 15 символов!';
                } else {
                    $newpassword = md5(clear_string($_POST["info_new_password"]));
                    $newpassword = strrev($newpassword);
                    $newpassword = "9nm2rv8q" . $newpassword . "2yo6z";
                    $newpasswordQuery = "password='" . $newpassword . "',";
                }
            }


            if (isset($_POST["info_surname"]) && strlen($_POST["info_surname"]) < 3 || strlen($_POST["info_surname"]) > 15) {
                $error[] = 'Укажите Фамилию от 3 до 15 символов!';
            }


            if (isset($_POST["info_name"]) && strlen($_POST["info_name"]) < 3 || strlen($_POST["info_name"]) > 15) {
                $error[] = 'Укажите Имя от 3 до 15 символов!';
            }


            if (isset($_POST["info_patronymic"]) && strlen($_POST["info_patronymic"]) < 3 || strlen($_POST["info_patronymic"]) > 25) {
                $error[] = 'Укажите Отчество от 3 до 25 символов!';
            }


            if (isset($_POST["info_email"]) && !preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", trim($_POST["info_email"]))) {
                $error[] = 'Укажите корректный email!';
            }

            if (isset($_POST["info_phone"]) && strlen($_POST["info_phone"]) == "") {
                $error[] = 'Укажите номер телефона!';
            }

            if (isset($_POST["info_address"]) && strlen($_POST["info_address"]) == "") {
                $error[] = 'Укажите адрес доставки!';
            }
        }

        if (count($error)) {
            $_SESSION['msg'] = "<p align='left' id='form-error'>" . implode('<br />', $error) . "</p>";
        } else {
            $_SESSION['msg'] = "<p align='left' id='form-success'>Данные успешно сохранены!</p>";


            $dataQuery = $newpasswordQuery . "surname='" . $_POST["info_surname"] . "',name='" . $_POST["info_name"] . "',patronymic='" . $_POST["info_patronymic"] . "',email='" . $_POST["info_email"] . "',phone='" . $_POST["info_phone"] . "',address='" . $_POST["info_address"] . "'";
            $update = mysqli_query($link, "UPDATE reg_user SET $dataQuery WHERE login = '{$_SESSION['auth_login']}'");

            if ($newpassword) {
                $_SESSION['auth_password'] = $newpassword;
            }

            $_SESSION['auth_surname'] = $_POST["info_surname"];
            $_SESSION['auth_name'] = $_POST["info_name"];
            $_SESSION['auth_patronymic'] = $_POST["info_patronymic"];
            $_SESSION['auth_address'] = $_POST["info_address"];
            $_SESSION['auth_phone'] = $_POST["info_phone"];
            $_SESSION['auth_email'] = $_POST["info_email"];

        }

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

            <h2 class="h2-title">Изменение профиля</h2>

            <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>
            <form method="post">
                <ul id="info-profile">
                    <li>
                        <label for="info_password">Текущий пароль</label>
                        <span class="star">*</span>
                        <input type="text" name="info_password" id="info_password"/>
                    </li>
                    <li>
                        <label for="info_new_passord">Новый пароль</label>
                        <span class="star">*</span>
                        <input type="text" name="info_new_password" id="info_new_passord"/>

                    </li>
                    <li>
                        <label for="info_surname">Фамилия</label>
                        <span class="star">*</span>
                        <input type="text" name="info_surname" id="info_surname"
                               value="<?php echo $_SESSION['auth_surname']; ?>"/>
                    </li>
                    <li>
                        <label for="info_name">Имя</label>
                        <span class="star">*</span>
                        <input type="text" name="info_name" id="info_name"
                               value="<?php echo $_SESSION['auth_name']; ?>"/>
                    </li>
                    <li>
                        <label for="info_patronymic">Отчество</label>
                        <span class="star">*</span>
                        <input type="text" name="info_patronymic" id="info_patronymic"
                               value="<?php echo $_SESSION['auth_patronymic']; ?>"/>
                    </li>
                    <li>
                        <label for="info_email">E-mail</label>
                        <span class="star">*</span>
                        <input type="text" name="info_email" id="info_email"
                               value="<?php echo $_SESSION['auth_email']; ?>"/>
                    </li>
                    <li>
                        <label for="info">Мобильный телефон</label>
                        <span class="star">*</span>
                        <input type="text" name="info_phone" id="info_phone"
                               value="<?php echo $_SESSION['auth_phone']; ?>"/>
                    </li>
                    <li>
                        <label for="info_address">Адрес доставки</label>
                        <span class="star">*</span>
                        <textarea name="info_address"><?php echo $_SESSION['auth_address']; ?></textarea>
                    </li>
                </ul>

                <p align="right"><input type="submit" name="save_submit" id="form-submit" value="Сохранить"/></p>
            </form>

        </div>

        <?php
        include("include/block-footer.php");
        ?>
    </div>
    </body>
    </html>
    <?php
} else {
    header("location: index.php");
}
?>