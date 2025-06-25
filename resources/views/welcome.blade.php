@extends('layout.main')

@section('content')
    <main class="main">

        <!-- PROMO -->
        <div class="promo">
            <div class="promo__content wrap">
                <div class="title-box">
                    <h1 class="promo-title">Air max <br>Flyknit Racer</h1>
                    <p class="promo-subtitle">Усиленный носок и прочный пластиковый каркас. Инновационная технология
                        раскрывается через перфорированную стельку</p>
                    <p class="promo-price">от <span>7 899 ₽</span></p>
                    <a href="{{ route('catalog') }}">
                        <div class="promo-btn-box">
                            <button class="promo-btn btn">Подробнее </button>
                            <p class="btn-item">→</p>
                        </div>
                    </a>
                </div>
                <div class="promo-img-box">
                    <img src="media/promo/sneaker 1.png" alt="#" class="promo-img">
                </div>
            </div>
        </div>
        <!-- PROMO-END -->


        <div class="receipts">
            <div class="receipts__content wrap">
                <div class="arrow-box">
                    <h2 class="receipts-title">Последние <br>поступления</h2>
                </div>
                <div class="receipts__items catalog__items">
                    @foreach ($latestProducts as $product)
                        <div class="receipts__item">
                            <div class="receipts__item-header">
                                <button class="receipts-btn">Новинка</button>
                                <a href="#"><img src="media/receipts/In favorites.svg" alt="#"
                                        class="receipts-icon"></a>
                            </div>
                            <div class="receipts__item-main">
                                <a href="{{ route('tovar', ['id' => $product->id]) }}"><img
                                        src="{{ asset('storage/public/products/' . $product->image) }}" alt="{{ $product->name }}"
                                        class="receipts-main-img"></a>
                                <img src="media/receipts/Frame 25.svg" alt="#">
                            </div>
                            <div class="receipts__item-info">
                                <div class="receipts__item-info-text">
                                    <h3 class="receipts-item-title">{{ $product->category ?? 'Без категории' }}</h3>
                                    <a class="receipts-item-model"
                                        href="{{ route('tovar', ['id' => $product->id]) }}">{{ $product->name }}</a>
                                    <p class="receipts-item-price">{{ number_format($product->price, 0, '', ' ') }} ₽
                                        @if ($product->old_price)
                                            <span>{{ number_format($product->old_price, 0, '', ' ') }} ₽</span>
                                        @endif
                                    </p>
                                </div>
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="add-to-cart-form">
                                    @csrf

                                    <button class="add-to-cart-btn">
                                        <img src="../../media/receipts/Added to cart.svg" alt="#">
                                    </button>
                                    <style>
                                        .add-to-cart-btn {
                                            border: none;
                                            background-color: transparent;
                                        }

                                        .add-to-cart-btn:hover {
                                            transform: translate3d(-5px, -5px, -5px)
                                        }
                                    </style>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>



    </main>

    <style>
        /* Базовые стили */
        .wrap {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .promo__content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0px 0;
        }

        .promo-img-box {
            flex: 0 1 50%;
        }

        .promo-img {
            max-width: 100%;
            height: auto;
        }

        .title-box {
            flex: 0 1 45%;
        }

        .receipts__items,
        .catalog__items {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        /* Адаптивные стили */
        @media (max-width: 992px) {
            .promo__content {
                flex-direction: column;
                text-align: center;
            }

            .title-box {
                margin-bottom: 30px;
            }

            .receipts__items,
            .catalog__items {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .promo-title {
                font-size: 28px;
            }

            .promo-subtitle {
                font-size: 14px;
            }

            .receipts__item,
            .sold__item {
                padding: 15px;
            }
        }

        @media (max-width: 576px) {

            .receipts__items,
            .catalog__items {
                grid-template-columns: 1fr;
            }

            .promo__content {
                padding: 30px 0;
            }

            .promo-title {
                font-size: 24px;
            }

            .promo-btn-box {
                justify-content: center;
            }

            .receipts-title,
            .sold-title {
                font-size: 22px;
            }
        }

        /* Общие адаптивные стили для товаров */
        .receipts__item,
        .sold__item {
            border: 1px solid #eee;
            border-radius: 10px;
            padding: 20px;
            transition: transform 0.3s ease;
        }

        .receipts__item:hover,
        .sold__item:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .receipts__item-header,
        .sold__item-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .receipts-main-img,
        .sold-main-img {
            width: 100%;
            height: auto;
            object-fit: contain;
        }

        .receipts__item-info,
        .sold__item-info {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 15px;
        }

        /* Кнопки и метки */
        .receipts-btn,
        .sold-btn-hit {
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }

        .receipts-btn {
            background-color: #4CAF50;
            color: white;
        }

        .receipts-btn-discount {
            background-color: #f44336;
            color: white;
        }

        .receipts-btn-hit,
        .sold-btn-hit {
            background-color: #2196F3;
            color: white;
        }

        /* Цветовые варианты */
        .color-grey {
            background-color: #9E9E9E;
        }

        .color-black {
            background-color: #212121;
        }

        .color-red {
            background-color: #F44336;
        }

        .color-blue {
            background-color: #2196F3;
        }

        .color-green {
            background-color: #4CAF50;
        }

        .color-pink {
            background-color: #E91E63;
        }

        .color-grey,
        .color-black,
        .color-red,
        .color-blue,
        .color-green,
        .color-pink {
            display: inline-block;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            margin-right: 5px;
            border: 1px solid #ddd;
        }
    </style>
@endsection
