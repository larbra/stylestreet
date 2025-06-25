<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Стиль улиц</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Questrial&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="media/logo/logo.png" type="image/x-icon">
</head>

<body>
    <!-- HEADER -->

    <header class="header">
        <div class="header__content wrap">
            <div class="header-bot">
                <a href="{{ route('home') }}"><img class="fff" src="{{ asset('media/logo/logo.jpg') }}"
                        alt="#"></a href="#">
                <style>
                    .fff {
                        width: 80px;
                    }
                </style>
                <nav class="header-top-nav">
                    <ul class="menu-item">
                        <a href="{{ route('catalog') }}">
                            <li class="menu-link-bot">Каталог</li>
                        </a>
                        <a href="{{ route('about') }}">
                            <li class="menu-link-bot">О нас</li>
                        </a>
                        <a href="{{ route('delivery') }}">
                            <li class="menu-link-bot">Доставка</li>
                        </a>
                        <a href="{{ route('orderuniqe') }}">
                            <li class="menu-link-bot">Индивидуальный заказ</li>
                        </a>
                    </ul>
                </nav>
                <div class="icon-box">
                    <div class="icon-item"><a href="{{ route('cart') }}"><img
                                src="{{ asset('media/header/Vector-1.svg') }}" alt="#" class="icon"></a>
                    </div>
                    <div class="btn-box">
                        @if (Route::has('showLogin'))
                            @auth
                                <a class="btn-login" href="{{ route('profile', ['id' => Auth::id()]) }}">Профиль</a>
                                <a class="btn-login" href="{{ route('logout') }}">Выйти</a>
                                @if (Auth::user()->role == 'admin')
                                    <a href="{{ route('admin') }}" class="btn-login">Админ</a>
                                @endif
                            @else
                                <a href="{{ route('showLogin') }}" class="btn-login">Вход</a>
                                <a href="{{ route('showRegister') }}" class="btn-login">Регистрация</a>
                            @endif
                            @endif

                        </div>
                    </div>

                    <div class="menu">
                        <input type="checkbox" id="burger-checkbox" class="burger-checkbox">
                        <label for="burger-checkbox" class="burger"></label>
                        <ul class="menu-list">
                            <li><a href="./index.html" class="menu-itemm">Главная</a>
                            <li>
                            <li><a href="./include/pages/catalog.html" class="menu-itemm">Каталог</a>
                            <li>
                            <li><a href="./include/pages/about.html" class="menu-itemm">О нас</a>
                            <li>
                            <li><a href="{{ route('delivery') }}" class="menu-itemm">Доставка</a>
                            <li>
                            <li><a href="./include/pages/order.html" class="menu-itemm">Индивидуальный заказ</a>
                            <li>
                            <li><a href="./include/pages/favourites.html" class="menu-itemm">Избранное</a>

                            <li>
                            <li><a href="./include/pages/basket.html" class="menu-itemm">Корзина</a>
                            <li>
                            <li><a href="./include/pages/login.html" class="menu-itemm">Войти</a>
                            <li>
                        </ul>
                    </div>

                    <!-- <div class="header-top-btn">
                                    <img src="media/item/profile-icon.svg" alt="icon">
                                    <div class="btn-box">
                                        <a href="#" class="btn-login">Вход</a>
                                    </div>
                                </div> -->
                </div>
                <!-- HEADER-BOT-END -->
            </div>
        </header>

        @yield('content')

        <!-- HEADER-END -->
        <footer class="footer">
            <div class="footer__content wrap">
                <div class="footer__items">
                    <div class="footer__item">
                        <div class="logo-box">

                            <p>Стиль <br> <span>Улиц</span></p>
                        </div>
                        <div class="contact-box">
                            <a href="#"><img src="{{ asset('media/footer/Group 386.png') }}" alt="#"></a>
                            <a href="#"><img src="{{ asset('media/footer/Group 387.png') }}" alt="#"></a>
                        </div>
                    </div>
                    <div class="footer__item">
                        <nav class="footer__nav">
                            <p>Информация</p>
                            <a href="#">О магазине</a>
                            <a href="#">Наш блог</a>
                            <a href="#">Доставка</a>
                            <a href="#">Оплата</a>
                            <a href="#">Контакты</a>
                        </nav>
                    </div>
                    <div class="footer__item">
                        <nav class="footer__nav">
                            <p>Товары</p>
                            <a href="#">Каталог</a>
                            <a href="#">Мужские</a>
                            <a href="#">Женские</a>
                            <a href="#">Детские</a>
                            <a href="#">Распродажа</a>
                        </nav>
                    </div>
                    <div class="footer__item">
                        <nav class="footer__nav">
                            <p>Магазин</p>
                            <a href="#">Личный кабинет</a>
                            <a href="#">Избранное</a>
                            <a href="#">Корзина</a>

                        </nav>
                    </div>
                    <div class="footer__item">
                        <nav class="footer__nav">
                            <p>Подписка на новости</p>
                            <a href="#">Подпишитесь на новости и скидки</a>
                        </nav>
                        <form class="form">
                            <input type="email" placeholder="Email" class="form-btn">
                            <button class="form-btn">Подписаться</button>
                        </form>
                        <p class="poli">Согласен с политикой конфиденциальности</p>
                    </div>
                </div>
                <div class="footer__bottom">
                    <p class="footer__bottom-text">© 2025 - Рындин Кирилл Константинович</p>
                    <a href="#" class="footer__bottom-link">Политика конфиденциальности</a>
                </div>
            </div>
        </footer>
        <!-- footre-end -->


        <script src="script/script.js"></script>
    </body>

    </html>
