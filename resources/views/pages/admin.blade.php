@extends('layout.main')
@section('content')
    <main class="wrap" style="margin-bottom: 120px; padding-top: 120px;">
        <h2 class="section-title">Админ‑панель</h2>

        @if (session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <div style="margin-bottom: 20px;">
            <a href="{{ route('createCategory') }}" class="btno btn-outline">Создать категорию</a>
            <a href="{{ route('createTovar') }}" class="btno btn-outline">Создать продукт</a>
        </div>
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
        <div>
            <div>
                <h3>Категории</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Название</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($category as $cat)
                            <tr>
                                <td>{{ $cat->id }}</td>
                                <td>{{ $cat->name }}</td>
                                <td>
                                    <a href="{{ route('showUpdateCategory', ['id' => $cat->id]) }}"
                                        class="btno btn-outline">Редактировать</a>
                                    <a href="{{ route('showDeleteCategory', ['id' => $cat->id]) }}"
                                        class="btno btn-outline">Удалить</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div>
                <h3>Продукты</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Название</th>
                            <th>Цена</th>
                            <th>Категория</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->category ? $product->category : 'Нет категории' }}</td>
                                <td>
                                    <a href="{{ route('showUpdateTovar', ['id' => $product->id]) }}"
                                        class="btno btn-outline">Редактировать</a>
                                    <a href="{{ route('showDeleteTovar', ['id' => $product->id]) }}"
                                        class="btno btn-outline">Удалить</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div>
                <h3>Заказы</h3>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Фио заказчика</th>
                            <th>Общая цена</th>
                            <th>Статус</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>10</td>
                            <td>Kirill</td>
                            <td>₽12500</td>
                            <td>Выполнено</td>
                            <td>
                                <form action="" method="post"><select name="" id="">
                                    @csrf
                                        <option value="">Выполнено</option>
                                        <option value="">Отказано</option>
                                    </select>
                                    <input type="submit" class="btno" value="Изменить">

                                </form>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
        </section>
    </main>
@endsection
