@extends('layout.main')
@section('content')

<div class="breadcrumbs">
    <div class="breadcrumbs__text wrap">
        <a href="{{ route('home') }}">Главная</a>
        <p>→</p>
        <p>Корзина</p>
    </div>
</div>

<div class="basket">
    <div class="basket__content wrap">
        <h1 class="basket__title">Ваша корзина</h1>
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
        @if ($cartItems->isEmpty())
            <div class="empty-cart">
                <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1.5">
                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                </svg>
                <p class="empty-cart__text">Ваша корзина пуста</p>
                <a href="{{ route('catalog') }}" class="btn btn--primary">Начать покупки</a>
            </div>
        @else
            <div class="cart-grid">
                <!-- Основной блок с товарами -->
                <div class="cart-items">
                    <div class="cart-header">
                        <div class="cart-header__product">Товар</div>
                        <div class="cart-header__price">Цена</div>
                        <div class="cart-header__quantity">Количество</div>
                        <div class="cart-header__total">Сумма</div>
                        <div class="cart-header__action"></div>
                    </div>

                    @foreach ($cartItems as $item)
                    <div class="cart-item" data-item-id="{{ $item->id }}">
                        <div class="cart-item__product">
                            <img src="{{ asset('storage/public/products/' . $item->tovar->image) }}"
                                 alt="{{ $item->tovar->name }}"
                                 class="cart-item__image">
                            <div class="cart-item__info">
                                <h3 class="cart-item__name">{{ $item->tovar->name }}</h3>
                            </div>
                        </div>

                        <div class="cart-item__price">
                            {{ number_format($item->tovar->price, 0, '', ' ') }} ₽
                        </div>

                        <div class="cart-item__quantity">
                            <button class="quantity-btn minus" onclick="updateQuantity(this, -1)">
                                <svg width="12" height="2" viewBox="0 0 12 2" fill="none">
                                    <path d="M11 1H1" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </button>
                            <span class="quantity">{{ $item->quantity }}</span>
                            <button class="quantity-btn plus" onclick="updateQuantity(this, 1)">
                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                                    <path d="M6 1V11M1 6H11" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                            </button>
                        </div>

                        <div class="cart-item__total" data-price="{{ $item->tovar->price }}">
                            {{ number_format($item->tovar->price * $item->quantity, 0, '', ' ') }} ₽
                        </div>

                        <div class="cart-item__action">
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="remove-btn" title="Удалить">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                                        <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Блок итогов -->
                <div class="cart-summary">
                    <div class="summary-card">
                        <h3 class="summary-title">Итог заказа</h3>



                        <div class="summary-row summary-total">
                            <span>Общая сумма</span>
                            <span id="cart-total">{{ number_format($total, 0, '', ' ') }} ₽</span>
                        </div>

                        <a href="" class="checkout-btn">Оформить заказ</a>

                        <div class="payment-methods">
                            <p>Мы принимаем:</p>
                            <div class="payment-icons">
                                <p>Visa</p>
                                <p>Mastercard</p>
                                <p>Мир</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
    // Ваш существующий скрипт updateQuantity остается без изменений
    async function updateQuantity(button, change) {
        const itemBox = button.closest('.cart-item');
        const itemId = itemBox.dataset.itemId;
        const quantityElement = itemBox.querySelector('.quantity');
        const priceElement = itemBox.querySelector('.cart-item__total');
        const price = parseFloat(priceElement.dataset.price);

        let quantity = parseInt(quantityElement.textContent);
        quantity += change;

        if (quantity < 1) return;

        itemBox.classList.add('updating');

        try {
            const response = await fetch(`/cart/update/${itemId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ quantity: quantity })
            });

            const data = await response.json();

            if (data.success) {
                quantityElement.textContent = quantity;
                const itemTotal = price * quantity;
                priceElement.textContent = itemTotal.toLocaleString('ru-RU') + ' ₽';
                document.getElementById('cart-total').textContent = data.cart_total.toLocaleString('ru-RU') + ' ₽';
            }
        } catch (error) {
            console.error('Ошибка:', error);
            alert('Произошла ошибка при обновлении количества');
        } finally {
            itemBox.classList.remove('updating');
        }
    }
</script>

<style>
/* Основные стили */
.basket {
    padding: 40px 0;
    min-height: 70vh;
}

.basket__title {
    font-size: 28px;
    margin-bottom: 30px;
    font-weight: 600;
    color: #333;
}

/* Сетка корзины */
.cart-grid {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 30px;
}

@media (max-width: 992px) {
    .cart-grid {
        grid-template-columns: 1fr;
    }
}

/* Шапка списка товаров */
.cart-header {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr 50px;
    gap: 15px;
    padding: 15px 0;
    border-bottom: 1px solid #eee;
    font-weight: 500;
    color: #666;
}

@media (max-width: 768px) {
    .cart-header {
        display: none;
    }
}

/* Карточка товара */
.cart-item {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr 50px;
    gap: 15px;
    align-items: center;
    padding: 20px 0;
    border-bottom: 1px solid #f5f5f5;
}

@media (max-width: 768px) {
    .cart-item {
        grid-template-columns: 1fr 1fr;
        grid-template-areas:
            "product product"
            "price quantity"
            "total action";
        gap: 10px;
        padding: 15px 0;
    }

    .cart-item__product { grid-area: product; }
    .cart-item__price { grid-area: price; }
    .cart-item__quantity { grid-area: quantity; }
    .cart-item__total { grid-area: total; }
    .cart-item__action { grid-area: action; }
}

.cart-item__product {
    display: flex;
    align-items: center;
    gap: 15px;
}

.cart-item__image {
    width: 80px;
    height: 80px;
    object-fit: contain;
    border-radius: 4px;
}

.cart-item__name {
    font-size: 16px;
    margin: 0;
    font-weight: 500;
}

.cart-item__price,
.cart-item__total {
    font-weight: 500;
}

.cart-item__quantity {
    display: flex;
    align-items: center;
    gap: 10px;
}

.quantity-btn {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #ddd;
    background: none;
    border-radius: 4px;
    cursor: pointer;
    color: #333;
    transition: all 0.2s;
}

.quantity-btn:hover {
    background: #f5f5f5;
}

.quantity {
    min-width: 20px;
    text-align: center;
}

.remove-btn {
    background: none;
    border: none;
    cursor: pointer;
    color: #999;
    transition: color 0.2s;
}

.remove-btn:hover {
    color: #ff3333;
}

/* Блок итогов */
.cart-summary {
    position: sticky;
    top: 20px;
}

.summary-card {
    background: #f9f9f9;
    border-radius: 8px;
    padding: 25px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.summary-title {
    font-size: 20px;
    margin-top: 0;
    margin-bottom: 20px;
    color: #333;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 12px;
    padding-bottom: 12px;
    border-bottom: 1px solid #eee;
}

.summary-total {
    font-weight: 600;
    font-size: 18px;
    margin-top: 15px;
    border-bottom: none;
}

.checkout-btn {
    display: block;
    width: 100%;
    padding: 14px;
    background: #000;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    font-weight: 500;
    margin-top: 25px;
    transition: background 0.2s;
}

.checkout-btn:hover {
    background: #333;
}

.payment-methods {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #eee;
}

.payment-methods p {
    margin-bottom: 10px;
    color: #666;
    font-size: 14px;
}

.payment-icons {
    display: flex;
    gap: 10px;
}

.payment-icons img {
    height: 24px;
}

/* Пустая корзина */
.empty-cart {
    text-align: center;
    padding: 60px 0;
}

.empty-cart svg {
    margin-bottom: 20px;
}

.empty-cart__text {
    font-size: 18px;
    color: #666;
    margin-bottom: 25px;
}

.btn--primary {
    display: inline-block;
    padding: 12px 30px;
    background: #000;
    color: #fff;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 500;
    transition: background 0.2s;
}

.btn--primary:hover {
    background: #333;
}

/* Состояние обновления */
.updating {
    opacity: 0.7;
    pointer-events: none;
}
</style>

@endsection
