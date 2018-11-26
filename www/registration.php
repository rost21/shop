<?php
define('myshop', true);
include "include/db_connect.php";
include "functions/functions.php";
session_start();
include("include/auth_cookie.php");

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
    <script type="text/javascript" src="js/jquery.form.js"></script>
    <script type="text/javascript" src="js/jquery.validate.js"></script>
    <script type="text/javascript" src="js/TextChange.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#form_reg').validate(
                {
                    // правила для проверки
                    rules: {
                        "reg_login": {
                            required: true,
                            minlength: 5,
                            maxlength: 15,
                            remote: {
                                type: "post",
                                url: "reg/check_login.php"
                            }
                        },
                        "reg_password": {
                            required: true,
                            minlength: 7,
                            maxlength: 15
                        },
                        "reg_surname": {
                            required: true,
                            minlength: 3,
                            maxlength: 15
                        },
                        "reg_name": {
                            required: true,
                            minlength: 3,
                            maxlength: 15
                        },
                        "reg_patronymic": {
                            required: true,
                            minlength: 3,
                            maxlength: 25
                        },
                        "reg_email": {
                            required: true
                            //email:true
                        },
                        "reg_phone": {
                            required: true
                        },
                        "reg_address": {
                            required: true
                        }/*,
                         "reg_captcha":{
                         required:false,
                         remote: {
                         type: "post",
                         url: "reg/check_captcha.php"

                         }

                         }*/
                    },

                    // выводимые сообщения при нарушении соответствующих правил
                    messages: {
                        "reg_login": {
                            required: "Укажите Логин!",
                            minlength: "От 5 до 15 символов!",
                            maxlength: "От 5 до 15 символов!",
                            remote: "Логин занят!"
                        },
                        "reg_password": {
                            required: "Укажите Пароль!",
                            minlength: "От 7 до 15 символов!",
                            maxlength: "От 7 до 15 символов!"
                        },
                        "reg_surname": {
                            required: "Укажите вашу Фамилию!",
                            minlength: "От 3 до 20 символов!",
                            maxlength: "От 3 до 20 символов!"
                        },
                        "reg_name": {
                            required: "Укажите ваше Имя!",
                            minlength: "От 3 до 15 символов!",
                            maxlength: "От 3 до 15 символов!"
                        },
                        "reg_patronymic": {
                            required: "Укажите ваше Отчество!",
                            minlength: "От 3 до 25 символов!",
                            maxlength: "От 3 до 25 символов!"
                        },
                        "reg_email": {
                            required: "Укажите свой E-mail"
                            //email:"Не корректный E-mail"
                        },
                        "reg_phone": {
                            required: "Укажите номер телефона!"
                        },
                        "reg_address": {
                            required: "Необходимо указать адрес доставки!"
                        }/*,
                         "reg_captcha":{
                         required:"Введите код с картинки!",
                         remote: "Не верный код проверки!"
                         }*/
                    },

                    submitHandler: function (form) {
                        $(form).ajaxSubmit({
                            success: function (data) {

                                if (data == true) {

                                    $("#block-form-registration").fadeOut(300, function () {

                                        $("#reg_message").addClass("reg_message_good").fadeIn(400).html("Вы успешно зарегистрированы!");
                                        $("#form-submit").hide();

                                    });

                                }
                                else {
                                    $("#reg_message").addClass("reg_message_error").fadeIn(400).html(data);
                                }
                            }
                        });
                    }
                });
        });

    </script>
    <title>Регистрация</title>
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
        <h2 class="h2-title">Регистрация</h2>

        <form method="post" id="form_reg" action="reg/handler_reg.php">
            <p id="reg_message"></p>
            <div id="block-form-registration">
                <ul id="form-registation">
                    <li>
                        <label>Логин</label>
                        <span class="star">*</span>
                        <input type="text" name="reg_login" id="reg_login" placeholder="Введите логин"/>
                    </li>
                    <li>
                        <label>Пароль</label>
                        <span class="star">*</span>
                        <input type="text" name="reg_password" id="reg_password" placeholder="Введите пароль"/>
                        <span id="genpass">Сгенерировать</span>
                    </li>
                    <li>
                        <label>Фамилия</label>
                        <span class="star">*</span>
                        <input type="text" name="reg_surname" id="reg_surname" placeholder="Введите фамилию"/>
                    </li>
                    <li>
                        <label>Имя</label>
                        <span class="star">*</span>
                        <input type="text" name="reg_name" id="reg_name" placeholder="Введите имя"/>
                    </li>
                    <li>
                        <label>Отчество</label>
                        <span class="star">*</span>
                        <input type="text" name="reg_patronymic" id="reg_patronymic" placeholder="Введите отчество"/>
                    </li>
                    <li>
                        <label>E-mail</label>
                        <span class="star">*</span>
                        <input type="text" name="reg_email" id="reg_email" placeholder="Введите email"/>
                    </li>
                    <li>
                        <label>Мобильный телефон</label>
                        <span class="star">*</span>
                        <input type="text" name="reg_phone" id="reg_phone" placeholder="Введите мобильный телефон"/>
                    </li>
                    <li>
                        <label>Адрес доставки</label>
                        <span class="star">*</span>
                        <input type="text" name="reg_address" id="reg_address" placeholder="Введите адрес доставки"/>
                    </li>
                    <!--
                    <li>
                        <div class="g-recaptcha" data-sitekey="6LeS63QUAAAAAOU6hDHVWfNI7P49jiDVdecEYnP7"></div>

                        <div id="block-captcha">
                            <img src="reg/reg_captcha.php" />
                            <input type="text" name="reg_captcha" id="reg_captcha"/>
                            <p id="reloadcaptcha">Обновить</p>
                        </div>

                    </li>
                    -->
                </ul>
            </div>
            <p align="right"><input type="submit" name="reg_submit" id="form-submit" value="Регистрация"/></p>
        </form>
    </div>

    <?php
    include("include/block-footer.php");
    ?>
</div>
</body>
</html>