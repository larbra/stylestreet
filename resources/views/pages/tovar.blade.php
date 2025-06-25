@extends('layout.main')
@section('content')
    <!-- Хлебные крошки -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="breadcrumbs__content">
                <a href="{{ route('home') }}" class="breadcrumbs__link"></a>
                <span class="breadcrumbs__separator">→</span>
                <a href="{{ route('catalog') }}" class="breadcrumbs__link"></a>
                <span class="breadcrumbs__separator">→</span>
                <span class="breadcrumbs__current">{{ $data->name }}</span>
            </div>
        </div>
    </div>

    <!-- Страница товара -->
    <section class="product-page">
        @if (session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif
        <style>
            .success-message {
                position: fixed;
                top: 100px;
                right: 20px;
                background-color: #4CAF50;
                color: white;
                padding: 15px 25px;
                border-radius: 5px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                z-index: 1000;
                animation: slideIn 0.5s, fadeOut 0.5s 2.5s forwards;
                max-width: 300px;
            }

            @keyframes slideIn {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }

                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }

            @keyframes fadeOut {
                from {
                    opacity: 1;
                }

                to {
                    opacity: 0;
                    visibility: hidden;
                }
            }
        </style>
        <div class="container">
            <div class="product-grid">
                <!-- Галерея товара -->
                <div class="product-gallery">
                    <div class="product-main-image">
                        <img src="{{ asset('storage/public/products/' . $data->image) }}" alt="{{ $data->name }}"
                            class="product-image" id="mainProductImage">
                    </div>

                    <div class="product-thumbnails">
                        <!-- Основное изображение как первая миниатюра -->
                        <div class="thumbnail active" data-image="{{ asset('storage/public/products/' . $data->image) }}">
                            <img src="{{ asset('storage/public/products/' . $data->image) }}" alt="">
                        </div>

                        <!-- Дополнительные изображения -->
                        @foreach ($data->images as $image)
                            <div class="thumbnail"
                                data-image="{{ asset('storage/public/products/' . $image->image_path) }}">
                                <img src="{{ asset('storage/public/products/' . $image->image_path) }}" alt="">
                            </div>
                        @endforeach
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const thumbnails = document.querySelectorAll('.thumbnail');
                            const mainImage = document.getElementById('mainProductImage');

                            thumbnails.forEach(thumb => {
                                thumb.addEventListener('click', function() {
                                    // Удаляем active у всех миниатюр
                                    thumbnails.forEach(t => t.classList.remove('active'));

                                    // Добавляем active текущей
                                    this.classList.add('active');

                                    // Обновляем основное изображение
                                    mainImage.src = this.dataset.image;
                                });
                            });
                        });
                    </script>
                </div>

                <!-- Информация о товаре -->
                <div class="product-info">
                    <h1 class="product-title">{{ $data->name }}</h1>
                    <div class="product-meta">
                        <span class="product-category">Категория: <strong>{{ $data->category }}</strong></span>
                        <span class="product-sku">Артикул: <strong>{{ $data->id }}</strong></span>
                    </div>

                    <div class="product-description">
                        <p>{{ $data->description }}</p>
                    </div>

                    <div class="product-price-block">
                        <div class="price-wrapper">
                            <span class="current-price">{{ number_format($data->price, 0, '', ' ') }} ₽</span>
                            @if ($data->old_price)
                                <span class="old-price">{{ number_format($data->old_price, 0, '', ' ') }} ₽</span>
                            @endif
                        </div>
                        <div class="discount-badge">
                            <span>−{{ $data->old_price ? round(100 - ($data->price * 100) / $data->old_price) : 0 }}%</span>
                        </div>
                    </div>

                    <form action="{{ route('cart.add', $data->id) }}" method="POST" class="add-to-cart-form">
                        @csrf
                        <div class="quantity-selector">
                            <button type="button" class="quantity-btn minus">-</button>
                            <input type="number" name="quantity" value="1" min="1" class="quantity-input">
                            <button type="button" class="quantity-btn plus">+</button>
                        </div>
                        <button class="add-to-cart-btn">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M6.66667 8.33333H4.16667L2.5 17.5H17.5L15.8333 8.33333H13.3333M6.66667 8.33333V5.83333C6.66667 3.99238 8.15905 2.5 10 2.5V2.5C11.841 2.5 13.3333 3.99238 13.3333 5.83333V8.33333"
                                    stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            Добавить в корзину
                        </button>
                    </form>

                    <style>
                        .add-to-cart-form {
                            display: flex;
                            gap: 10px;
                            margin-top: 20px;
                            margin-bottom: 50px;
                        }

                        .quantity-selector {
                            display: flex;
                            border: 1px solid #eaeaea;
                        }

                        .quantity-btn {
                            width: 30px;
                            height: 30px;
                            background: none;
                            border: none;
                            cursor: pointer;
                            font-size: 16px;
                        }

                        .quantity-input {
                            width: 40px;
                            text-align: center;
                            border: none;
                            border-left: 1px solid #eaeaea;
                            border-right: 1px solid #eaeaea;
                            -moz-appearance: textfield;
                        }

                        .quantity-input::-webkit-outer-spin-button,
                        .quantity-input::-webkit-inner-spin-button {
                            -webkit-appearance: none;
                            margin: 0;
                        }

                        .add-to-cart-btn {
                            padding: 0 20px;
                            background: #000;
                            color: #fff;
                            border: none;
                            cursor: pointer;
                            transition: opacity 0.3s;
                        }

                        .add-to-cart-btn:hover {
                            opacity: 0.9;
                        }
                    </style>

                    <script>
                        document.querySelectorAll('.quantity-btn').forEach(btn => {
                            btn.addEventListener('click', () => {
                                const input = btn.parentElement.querySelector('.quantity-input');
                                let value = parseInt(input.value);

                                if (btn.classList.contains('minus') && value > 1) {
                                    input.value = value - 1;
                                } else if (btn.classList.contains('plus')) {
                                    input.value = value + 1;
                                }
                            });
                        });
                    </script>

                    <div class="product-features">
                        <div class="feature-item">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                                    stroke="#4CAF50" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M8 12L11 15L16 9" stroke="#4CAF50" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            <span>Оригинальная продукция</span>
                        </div>
                        <div class="feature-item">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z"
                                    stroke="#2196F3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M12 8V12L15 15" stroke="#2196F3" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            <span>Быстрая доставка</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Стили -->
    <style>
        /* Основные стили */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .product-page {
            margin-bottom: 140px;
        }

        /* Хлебные крошки */
        .breadcrumbs {
            padding: 15px 0;
            margin-bottom: 120px;
        }

        .breadcrumbs__content {
            display: flex;
            align-items: center;
            font-size: 14px;
            padding-top: 80px;
        }

        .breadcrumbs__link {
            color: #6c757d;
            text-decoration: none;
            transition: color 0.3s;
        }

        .breadcrumbs__link:hover {
            color: #007bff;
        }

        .breadcrumbs__separator {
            margin: 0 8px;
            color: #adb5bd;
        }

        .breadcrumbs__current {
            color: #495057;
            font-weight: 500;
        }

        /* Страница товара */
        .product-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 60px;
        }

        @media (max-width: 768px) {
            .product-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Галерея товара */
        .product-gallery {
            display: flex;
            flex-direction: column;
        }

        .product-main-image {

            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 15px;
        }

        .product-image {
            width: 100%;
            height: auto;
            display: block;
        }

        .product-thumbnails {
            display: flex;
            gap: 10px;
        }

        .thumbnail {
            width: 70px;
            height: 70px;
            border: 1px solid #e9ecef;
            border-radius: 4px;
            overflow: hidden;
            cursor: pointer;
            transition: border-color 0.3s;
        }

        .thumbnail:hover,
        .thumbnail.active {
            border-color: #007bff;
        }

        .thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Информация о товаре */
        .product-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 15px;
            color: #212529;
        }

        .product-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 20px;
            font-size: 14px;
            color: #6c757d;
        }

        .product-meta strong {
            color: #495057;
            font-weight: 500;
        }

        .product-description {
            margin-bottom: 25px;
            line-height: 1.6;
            color: #495057;
        }

        /* Блок цены */
        .product-price-block {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .price-wrapper {
            display: flex;
            align-items: baseline;
            gap: 10px;
        }

        .current-price {
            font-size: 28px;
            font-weight: 700;
            color: #212529;
        }

        .old-price {
            font-size: 18px;
            color: #6c757d;
            text-decoration: line-through;
        }

        .discount-badge {
            background-color: #dc3545;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 500;
        }

        /* Кнопки действий */
        .product-actions {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
        }

        .quantity-selector {
            display: flex;
            border: 1px solid #ced4da;
            border-radius: 4px;
            overflow: hidden;
        }

        .quantity-btn {
            width: 40px;
            height: 45px;
            background-color: #f8f9fa;
            border: none;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s;
        }

        .quantity-btn:hover {
            background-color: #e9ecef;
        }

        .quantity-input {
            width: 50px;
            height: 45px;
            border: none;
            text-align: center;
            font-size: 16px;
            -moz-appearance: textfield;
        }

        .quantity-input::-webkit-outer-spin-button,
        .quantity-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .add-to-cart-btn {
            flex: 1;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 0 20px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: background-color 0.3s;
        }

        .add-to-cart-btn:hover {
            background-color: #0069d9;
        }

        /* Особенности товара */
        .product-features {
            display: flex;
            flex-direction: column;
            gap: 12px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: #495057;
        }
    </style>
@endsection
