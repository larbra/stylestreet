@extends('layout.main')
@section('content')

<div class="breadcrumbs">
    <div class="breadcrumbs__text wrap">
        <a href="{{route('home')}}">Главная</a>
        <p>→</p>
        <p>Авторизация</p>
    </div>
</div>

<div class="Authorization">
    <div class="Authorization__content wrap">
        <h2 class="Authorization__title">
            Авторизация
        </h2>
        <div class="Authorization__items">
            <div class="Authorization__item">
                <form action="{{route('login')}}" method="post" class="Authorization__form">
                    @csrf
                    <p>Email или номер телефона <span>*</span></p>
                    <input type="text" name="email" placeholder="Введите данные для авторизации">
                    @error('email')
                    <p style="color:red">{{$message}}</p>
                    @enderror
                    <p>Пароль <span>*</span></p>
                    <input type="password" name="password" placeholder="Введите пароль от аккаунта ">
                    @error('password')
                    <p style="color:red">{{$message}}</p>
                    @enderror
                    <input type="submit" value="Войти в кабинет" class="Authorization__form-btn">
                </form>
            </div>

            <div class="Authorization__item auth__item-right">
                <img src="../../media/auth/Vector.png" alt="#">
                <div class="auth_textbox ">
                    <p class="auth__title">Еще нет аккаунта?</p>
                    <p class="auth__text">Регистрация на сайте позволяет получить доступ к статусу и истории вашего заказа. Просто заполните поля ниже, и вы получите учетную запись. <br>
                    </p>
                    <p class="auth__text">
                        Мы запрашиваем у вас только информацию, необходимую для того, чтобы сделать процесс покупки более быстрым и легким.
                    </p>
                    <a href="{{route('register')}}" class="auth__btn">Зарегистрироваться</a>
                </div>
            </div>
            <div class="Authorization__item"></div>
        </div>
    </div>
</div>
@endsection
