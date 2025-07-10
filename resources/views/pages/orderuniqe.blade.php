@extends('layout.main')
@section('content')

<div class="breadcrumbs">
    <div class="breadcrumbs__text wrap">
        <a href="{{route('home')}}">Главная</a>
        <p>→</p>
        <p>Индивидуальный заказ</p>
    </div>
</div>
<div class="order">
    <div class="order__content wrap">
        <h2 class="order__title">
            Индивидуальный заказ
        </h2>
        <p class="order__subtitle">
            Здесь вы можете стать обладателем поистине уникальных и лимитированных моделей кроссовок Nike, ожидая их
            поступления в продажу. Мы ценим вашу страсть к стилю и предоставляем вам уникальную возможность заказать
            кроссовки, которые будут дополнением вашей индивидуальности.
        </p>
        <div class="order__items">
            <div class="order__item">
                <p class="order__item-title">
                    Условие заказа:
                </p>
                <div class="order__itembox">
                    <p class="order__number">
                        1.
                    </p>
                    <p class="order__text">Выбор модели: Ознакомьтесь с нашим каталогом лимитированных моделей и выберите
                        ту, которая вам больше всего понравилась.</p>
                </div>
                <div class="order__itembox">
                    <p class="order__number">
                        2.
                    </p>
                    <p class="order__text">Предоплата: Для подтверждения вашего заказа требуется внести предоплату в
                        размере 100% от стоимости кроссовок.</p>
                </div>
                <div class="order__itembox">
                    <p class="order__number">
                        3.
                    </p>
                    <p class="order__text">Сроки ожидания: Обычно срок поступления лимитированных кроссовок составляет 4-6
                        недель с момента оформления заказа и внесения предоплаты.</p>
                </div>
                <div class="order__itembox">
                    <p class="order__number">
                        4.
                    </p>
                    <p class="order__text">Уведомление о готовности: Как только заказанные кроссовки поступят в наш
                        магазин, мы отправим вам уведомление по электронной почте или SMS.</p>
                </div>
                <div class="order__itembox">
                    <p class="order__number">
                        5.
                    </p>
                    <p class="order__text">Доставка: После полной оплаты мы доставим ваши уникальные кроссовки прямо к вам
                        по указанному адресу.</p>
                </div>
            </div>
            <div class="order__item">
                <form action="" class="Authorization__form order__form">
                    <p>Ваше имя <span>*</span></p>
                    <input type="text" placeholder="Как вас зовут">
                    <p>Номер телефона <span>*</span></p>
                    <input type="password" placeholder="+7 (___) ___ - ___ - ___ ">
                    <p>Email <span>*</span></p>
                    <input type="text" placeholder="Введите email адрес">
                    <p>Сообщение:</p>
                    <textarea name="" id="" cols="10" rows="5" placeholder="Укажите любой другой способ связи"></textarea>
                    <input type="submit" value="Создать заказ" class="order__form-btn">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
