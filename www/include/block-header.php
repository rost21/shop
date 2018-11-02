<!-- Основной верхний блок -->
<div id="block-header">
    <!-- Верхний блок с навигацией -->
    <div id="header-top-block">
        <!-- Список с навигацией -->
        <ul id="header-top-menu">
            <li>Ваш город - <span>Одесса</span></li>
            <li><a href="aboutUs.php">О нас</a></li>
            <li><a href="shops.php">Магазины</a></li>
            <li><a href="contacts.php">Контакты</a></li>
        </ul>
        <!-- Вход и регистрация -->

        <?php

            if (isset($_SESSION['auth']) && $_SESSION['auth'] == 'yes_auth') {

                echo "<p id='auth-user-info' align='right'><img src='images/user.png'> Здравствуйте," . $_SESSION['auth_name'] . "! </p>";
            } else {
                echo "<p id='reg-auth-title' align='right'><a href='#' class='top-auth'>Вход</a>
                    <a href='registration.php'>Регистрация</a> </p>";
            }

        ?>


        <div id="block-top-auth">
            <div class="corner"></div>
            <form method="post">
                <ul id="input-email-pass">
                    <h3>Вход</h3>
                    <p id="message-auth">Неверный логин или пароль</p>
                    <li><center><input type="text" id="auth_login" placeholder="Логин или e-mail"/></center></li>
                    <li><center><input type="password" id="auth_password" placeholder="Пароль"/><span id="button-password-show-hide" class="pass-show"></span></center></li>
                    <ul id="list-auth">
                        <li><input type="checkbox" name="rememberMe" id="rememberMe"><label for="rememberMe">Запомнить меня</label> </li>
                        <li><a id="remindPassword" href="#">Забыли пароль?</a> </li>
                    </ul>
                    <p align="right" id="button-auth"><a>Войти</a></p>
                    <p align="right" class="auth-loading"><img src="images/loading.gif"/></p>
                </ul>
            </form>

            <div id="block-remind">
                <h3>Восстановление<br/> пароля</h3>
                <p id="message-remind" class="message-remind-success"></p>
                <center><input type="text" id="remind-email" placeholder="Введите ваш email"/></center>
                <p id="button-remind" align="right"><a>Готово</a></p>
                <p align="right" class="auth-loading"><img src="images/loading.gif"/></p>
                <p id="prev-auth">Назад</p>
            </div>


        </div>
    </div>
    <!-- Линия -->
    <div class="top-line"></div>

    <div id="block-user">
        <div class="corner2"></div>
        <ul>
            <li><img src="images/user_info.png"/><a href="profile.php">Профиль</a></li>
            <li><img src="images/logout.png"/><a id="logout">Выход</a></li>
        </ul>
    </div>



    <!-- Логотип -->
    <img src="images/logo.png" width="350px"/>
    <!-- Информационный блок -->
    <div id="personal-info">
        <p align="right">Наш телефон:</p>
        <h3 align="right">8 (800) 555-35-35</h3>
        <img src="images/phone.png" width="50px"/>
        <br/>
        <p align="right">Режим работы: </p>
        <p align="right">Вторник - воскресенье: 8:00 - 13:00</p>
        <p align="right">Выходной: понедельник</p>
        <img src="images/clock.png" width="50px">
    </div>

    <!-- Поиск товаров -->
    <div id="block-search">
        <form method="get" action="search.php?q=">
            <input type="text" id="input-search" name="q" placeholder="Введите что-то для поиска" required>
            <input type="submit" id="button-search" value="Поиск">
        </form>
    </div>
</div>
<!-- Средний блок -->
<div id="top-menu">
    <ul>
        <li><img src="images/home.png" width="40px"/><a href="index.php">Главная</a> </li>
        <li><img src="images/new2.png" width="50px"/><a href="#">Новинки</a></li>
        <li><img src="images/best price.png" width="50px"/><a href="#">Лидеры продаж</a></li>
        <li><img src="images/sale.png" width="50px"/><a href="#">Распродажа</a></li>
    </ul>
    <p align="right" id="block-basket"><img src="images/basket.png" width="40px"/> <a href="#">Корзина пуста</a></p>
    <!-- Линия -->

</div>
<div class="line"></div>