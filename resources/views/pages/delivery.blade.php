@extends('layout.main')
@section('content')

<div class="breadcrumbs">
    <div class="breadcrumbs__text wrap">
        <a href="{{route('home')}}">Главная</a>
        <p>→</p>
        <p>Доставка и оплата</p>
    </div>
</div>
<div class="delivery">
    <div class="delivery__content wrap">
        <h2 class="delivery__title ">
            Доставка и оплата
        </h2>
        <p class="delivery__subtitle">
            Мы стремимся сделать процесс получения вашего заказа максимально удобным и прозрачным. Пожалуйста,
            ознакомьтесь с вариантами доставки и способами оплаты, предоставленными ниже:
        </p>
        <div class="delivery__items">
            <div class="delivery__item">
                <p class="delivery__item-title">
                    Доставка:
                </p>
                <p class="delivert__item-subtitle">
                    Мы сотрудничаем с транспортной компанией СДЭК для обеспечения надежной и быстрой доставки в любой
                    уголок России. При оформлении заказа вы можете выбрать один из следующих вариантов доставки:
                </p>
                <div class="delivery__itembox">
                    <p class="delivery__number">
                        1.
                    </p>
                    <p class="delivery__text">
                        Доставка до пункта выдачи СДЭК: <br>
                        Воспользуйтесь ближайшим пунктом выдачи СДЭК для получения вашего заказа. Это удобно и позволяет
                        вам выбрать место и время получения.
                    </p>
                </div>
                <div class="delivery__itembox">
                    <p class="delivery__number">
                        2.
                    </p>
                    <p class="delivery__text">
                        Доставка курьером до двери: <br>
                        Если вы предпочитаете комфорт доставки прямо до вашего дома или офиса, выберите этот вариант.
                        Курьер свяжется с вами для согласования удобного времени доставки.
                    </p>
                </div>
                <div class="delivery__itembox">
                    <p class="delivery__number">
                        3.
                    </p>
                    <p class="delivery__text">
                        Самовывоз: <br>
                        Вы можете забрать ваш заказ самостоятельно в одном из наших магазинов в городe Казань. Этот вариант
                        подходит для тех, кто предпочитает личное общение и быстрый доступ к своему заказу. <br><br>

                        Адреса магазинов: <br>
                        Казань, улица Галеева 3 1 этаж
                    </p>
                </div>
            </div>
            <div class="delivery__item">
                <p class="delivery__item-title">
                    Оплата:
                </p>
                <p class="delivert__item-subtitle">
                    Мы предоставляем разнообразные способы оплаты, чтобы обеспечить ваш комфорт:
                </p>
                <div class="delivery__itembox">
                    <p class="delivery__number">
                        1.
                    </p>
                    <p class="delivery__text">
                        Онлайн-оплата: <br>
                        Вы можете оплатить ваш заказ онлайн на нашем сайте. Мы принимаем платежи с помощью банковских карт,
                        что обеспечивает быстроту и безопасность транзакции.
                    </p>
                </div>
                <div class="delivery__itembox">
                    <p class="delivery__number">
                        2.
                    </p>
                    <p class="delivery__text">
                        Наличными или картой: <br>
                        Если вы выбрали самовывоз из магазина, вы можете оплатить заказ наличными или картой прямо в
                        магазине.
                    </p>
                </div>


            </div>
        </div>
    </div>

</div>
@endsection
