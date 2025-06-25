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
        <p class="basket__title">Корзина товаров</p>

        @if($cartItems->isEmpty())
        <div class="empty-cart">
            <img src="{{ asset('media/basket/empty-cart.png') }}" alt="Корзина пуста">
            <p>Ваша корзина пуста</p>
            <a href="{{ route('catalog') }}" class="btn">Перейти в каталог</a>
        </div>
        @else
        <div class="basket__items">
            <div class="basket__item">
                @foreach($cartItems as $item)
                <div class="backet__itembox">
                    <img src="{{ asset('storage/products/'.$item->tovar->image) }}" alt="{{ $item->tovar->name }}" class="basket__img">
                    <p class="basket__name">{{ $item->tovar->name }}</p>
                    <p class="basket__price">{{ number_format($item->tovar->price, 0, '', ' ') }} ₽</p>

                    <div class="basket__calc">
                        <button class="quantity-btn minus" data-id="{{ $item->id }}">-</button>
                        <p class="quantity">{{ $item->quantity }}</p>
                        <button class="quantity-btn plus" data-id="{{ $item->id }}">+</button>
                    </div>

                    <div class="basket__endprice">
                        {{ number_format($item->tovar->price * $item->quantity, 0, '', ' ') }} ₽
                    </div>

                    <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="remove-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="basket__remove">
                            <img src="{{ asset('media/basket/trash-icon.png') }}" alt="Удалить">
                        </button>
                    </form>
                </div>
                @endforeach
            </div>

            <div class="basket__item basket__item-right">
                <p class="basket__item-title">Итого:</p>
                <div class="basket__pricebox">
                    <p>Сумма</p>
                    <p>{{ number_format($total, 0, '', ' ') }} ₽</p>
                </div>
                <a href="{{ route('checkout') }}" class="basket__item-btn">Оформить заказ</a>
            </div>
        </div>
        @endif
    </div>
</div>

<style>
.basket {
    padding: 30px 0;
}

.basket__title {
    font-size: 24px;
    margin-bottom: 20px;
    font-weight: 600;
}

.basket__items {
    display: flex;
    gap: 30px;
}

.basket__item {
    flex: 1;
}

.backet__itembox {
    display: flex;
    align-items: center;
    padding: 15px 0;
    border-bottom: 1px solid #eee;
    gap: 20px;
}

.basket__img {
    width: 80px;
    height: 80px;
    object-fit: contain;
}

.basket__name {
    flex: 1;
    font-size: 16px;
}

.basket__price, .basket__endprice {
    width: 100px;
    text-align: center;
    font-weight: 500;
}

.basket__calc {
    display: flex;
    align-items: center;
    gap: 10px;
}

.quantity-btn {
    width: 30px;
    height: 30px;
    border: 1px solid #ddd;
    background: none;
    cursor: pointer;
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.basket__remove {
    background: none;
    border: none;
    cursor: pointer;
    padding: 5px;
}

.basket__item-right {
    max-width: 300px;
    background: #f9f9f9;
    padding: 20px;
    border-radius: 8px;
    height: fit-content;
}

.basket__item-title {
    font-size: 20px;
    margin-bottom: 20px;
    font-weight: 600;
}

.basket__pricebox {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
    font-size: 18px;
}

.basket__item-btn {
    display: block;
    width: 100%;
    padding: 12px;
    background: #000;
    color: #fff;
    text-align: center;
    border-radius: 4px;
    text-decoration: none;
    font-weight: 500;
}

.empty-cart {
    text-align: center;
    padding: 50px 0;
}

.empty-cart img {
    width: 150px;
    margin-bottom: 20px;
}

.empty-cart p {
    font-size: 18px;
    margin-bottom: 20px;
}

.empty-cart .btn {
    display: inline-block;
    padding: 10px 20px;
    background: #000;
    color: #fff;
    text-decoration: none;
    border-radius: 4px;
}
</style>

<script>
document.querySelectorAll('.quantity-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const itemId = this.dataset.id;
        const isPlus = this.classList.contains('plus');
        const quantityElement = this.parentElement.querySelector('.quantity');
        let quantity = parseInt(quantityElement.textContent);

        if (isPlus) {
            quantity++;
        } else if (quantity > 1) {
            quantity--;
        }

        // AJAX запрос для обновления количества
        fetch(`/cart/update/${itemId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                quantityElement.textContent = quantity;
                location.reload(); // Обновляем страницу для пересчета суммы
            }
        });
    });
});
</script>

@endsection
