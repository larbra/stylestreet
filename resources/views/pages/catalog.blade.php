@extends('layout.main')
@section('content')
    <div class="breadcrumbs">
        <div class="breadcrumbs__text wrap">
            <a href="{{ route('home') }}">Главная</a>
            <p>→</p>
            <p>Каталог</p>
        </div>
    </div>
    <div class="catalog">
        <div class="catalog__content wrap">
            <h2 class="catalog__title">Каталог</h2>

            <!-- Горизонтальные категории с кнопками -->
            <div class="catalog__categories-horizontal">
                <h3 class="catalog__categories-title">Категории:</h3>
                <div class="categories-horizontal-list list__btns">
                    <button class="categories-horizontal-btn active" onclick="filterCards('all', this)">Все товары</button>
                    @foreach ($category as $cat)
                        <button class="categories-horizontal-btn"
                            onclick="filterCards('{{ $cat->name }}', this)">{{ $cat->name }}</button>
                    @endforeach
                </div>
            </div>

            <!-- Поиск товаров -->
            <div class="catalog-search">
                <input type="text" id="search-input" placeholder="Поиск товаров по названию..." class="search-input">
                <button class="search-btn" onclick="searchProducts()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>
            </div>

            <div class="receipts__items catalog__items" id="products-container">
                @foreach ($data as $tovar)
                    <div class="receipts__item card" data-category="{{ $tovar->category }}" data-name="{{ strtolower($tovar->name) }}">
                        <div class="receipts__item-header">
                            <button class="receipts-btn">Новинка</button>
                            <a href="#"><img src="../../media/receipts/In favorites.svg" alt="#"
                                    class="receipts-icon"></a>
                        </div>
                        <div class="receipts__item-main">
                            <a href="{{ route('tovar', ['id' => $tovar->id]) }}"><img
                                    src="{{ asset('storage/public/products/' . $tovar->image) }}" alt="#"
                                    class="receipts-main-img"></a>
                            <img src="../../media/receipts/Frame 25.svg" alt="#">
                        </div>
                        <div class="receipts__item-info">
                            <div class="receipts__item-info-text">
                                <h3 class="receipts-item-title">{{ $tovar->category }}</h3>
                                <a class="receipts-item-model"
                                    href="{{ route('tovar', ['id' => $tovar->id]) }}">{{ $tovar->name }}</a>

                                <p class="receipts-item-price">{{ $tovar->price }}₽ <span>11 699 ₽</span></p>
                            </div>
                            <form action="{{ route('cart.add', $tovar->id) }}" method="POST" class="add-to-cart-form">
                                @csrf
                                <button class="add-to-cart-btn">
                                    <img src="../../media/receipts/Added to cart.svg" alt="#">
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="transition">
                <div class="transition__content wrap">
                    <a href="" class="transition__link transition__link-active">1</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function filterCards(category, button) {
            const cards = document.querySelectorAll('.card');
            const buttons = document.querySelectorAll('.list__btns button');

            // Показываем/скрываем карточки
            cards.forEach((card) => {
                if (category === 'all' || card.dataset.category === category) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });

            // Убираем класс active у всех кнопок
            buttons.forEach((btn) => btn.classList.remove('active'));

            // Добавляем класс active текущей кнопке
            button.classList.add('active');
        }

        function searchProducts() {
            const searchInput = document.getElementById('search-input');
            const searchTerm = searchInput.value.toLowerCase();
            const cards = document.querySelectorAll('.card');

            if (searchTerm.length < 2) {
                // Если поисковый запрос слишком короткий, показываем все товары
                cards.forEach(card => card.classList.remove('hidden'));
                return;
            }

            cards.forEach(card => {
                const productName = card.dataset.name;
                if (productName.includes(searchTerm)) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });
        }

        // Поиск при нажатии Enter
        document.getElementById('search-input').addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                searchProducts();
            }
        });
    </script>

    <style>
        /* Стили для горизонтальных категорий с кнопками */
        .catalog__categories-horizontal {
            margin-bottom: 20px;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        /* Стили для поиска */
        .catalog-search {
            display: flex;
            margin-bottom: 30px;
            max-width: 500px;
            width: 100%;
        }

        .search-input {
            flex: 1;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 4px 0 0 4px;
            font-size: 16px;
            outline: none;
            transition: border 0.3s;
        }

        .search-input:focus {
            border-color: #333;
        }

        .search-btn {
            padding: 0 15px;
            background: #333;
            color: white;
            border: none;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s;
        }

        .search-btn:hover {
            background: #555;
        }

        .card {
            display: block;
            opacity: 1;
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .card.hidden {
            display: none;
            opacity: 0;
            transform: scale(0.9);
        }

        .catalog__categories-title {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }

        .categories-horizontal-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin: 0;
            padding: 0;
        }

        .categories-horizontal-btn {
            padding: 8px 15px;
            color: #555;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 20px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            outline: none;
        }

        .categories-horizontal-btn:hover {
            background-color: #f5f5f5;
            color: #000;
        }

        .categories-horizontal-btn.active {
            background-color: #333;
            color: #fff;
            border-color: #333;
        }

        /* Остальные стили */
        .add-to-cart-btn {
            border: none;
            background-color: transparent;
            padding: 0;
            cursor: pointer;
        }

        .add-to-cart-btn:hover {
            transform: translate3d(-5px, -5px, -5px);
        }

        .receipts-btn {
            cursor: pointer;
        }
    </style>
@endsection
