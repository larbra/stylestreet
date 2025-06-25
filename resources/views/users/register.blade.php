@extends('layout.main')
@section('content')
    <div class="breadcrumbs">
        <div class="breadcrumbs__text wrap">
            <a href="../../index.html">Главная</a>
            <p>→</p>
            <p>Авторизация</p>
        </div>
    </div>

    <div class="Authorization regist">
        <div class="Authorization__content wrap">
            <h2 class="Authorization__title">
                Регистрация
            </h2>
            <div class="regist__items">
                <div class="Authorization__item">
                    <form action="{{ route('register') }}" method="post" class="Authorization__form">
                        @csrf
                        <p>Email <span>*</span></p>
                        <input type="text" name="email" placeholder="Введите email адрес">
                        @error('email')
                            <p class="errors" style="color: red;">{{ $message }}</p>
                        @enderror
                        <p>ФИО <span>*</span></p>
                        <input type="text" name="name" placeholder="Ваше полное имя ">
                        @error('name')
                            <p class="errors" style="color: red;">{{ $message }}</p>
                        @enderror
                        <p>Номер телефона <span>*</span></p>
                        <input type="text" placeholder="+7 (___) ___ - ___ - ___ ">
                        <p>Пароль <span>*</span></p>
                        <input type="password" name="password" placeholder="Придумайте пароль ">
                        @error('password')
                            <p class="errors" style="color: red;">{{ $message }}</p>
                        @enderror
                        <p>Повторите пароль <span>*</span></p>
                        <input type="password" name="password_confirmation" placeholder="Придумайте пароль ">
                        <input type="submit" value="Создать аккаунт" class="Authorization__form-btn">
                    </form>
                </div>

                <div class="Authorization__item auth__item-right">
                    <img src="../../media/auth/Vector.png" alt="#">
                    <div class="auth_textbox ">
                        <p class="auth__title">Уже есть аккаунт?</p>
                        <p class="auth__text">Перейдите к авторизации если у вас уже есть зарегистрированный <br> аккаунт.
                        </p>
                        <a href="{{ route('login') }}" class="auth__btn">Авторизоваться</a>
                    </div>
                </div>
                <div class="Authorization__item"></div>
            </div>
        </div>
    </div>
@endsection
