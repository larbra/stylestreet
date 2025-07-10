@extends('layout.main')

@section('content')
<div class="minimal-profile">
    <div class="container">
        <!-- Заголовок -->
        <div class="profile-header">
            <h1 class="profile-title">Профиль</h1>
            <div class="profile-actions">
                <button class="action-btn edit-btn">Редактировать</button>
            </div>
        </div>

        <!-- Основное содержимое -->
        <div class="profile-content">
            <!-- Блок аватара -->
            <div class="avatar-block">
                <div class="avatar-container">
                    <img src="{{asset('assets/media/profile/user.png')}}"
                         alt="Аватар"
                         class="avatar-img">
                </div>
                <h2 class="user-name">{{ $user->name }}</h2>
                <p class="user-email">{{ $user->email }}</p>
            </div>

            <!-- Информация -->
            <div class="info-block">
                <div class="info-section">
                    <h3 class="section-title">Личные данные</h3>
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Телефон</span>
                            <span class="info-value">{{ $user->phone ?? '+79874225816' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Дата регистрации</span>
                            <span class="info-value">{{ $user->created_at->format('d.m.Y') }}</span>
                        </div>
                    </div>
                </div>

                <div class="info-section">
                    <h3 class="section-title">Последний заказ</h3>

                    <div class="order-card">
                        <div class="order-header">
                            <span>Заказ #</span>
                            <span class="order-status"></span>
                        </div>
                        <div class="order-date"></div>
                        <div class="order-total"> ₽</div>
                    </div>

                    <p class="no-orders">Нет данных о заказах</p>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Базовые стили */
.minimal-profile {
    font-family: 'Helvetica Neue', Arial, sans-serif;
    color: #333;
    line-height: 1.6;
    padding: 40px 0;
}

.container {
    max-width: 900px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Шапка */
.profile-header {
    padding-top: 120px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 40px;
    border-bottom: 1px solid #eaeaea;
    padding-bottom: 20px;
}

.profile-title {
    font-size: 24px;
    font-weight: 500;
    margin: 0;
}

.profile-actions {
    display: flex;
    gap: 10px;
}

.action-btn {
    padding: 8px 16px;
    font-size: 14px;
    border: 1px solid #ddd;
    background: none;
    cursor: pointer;
    transition: all 0.2s;
}

.edit-btn {
    color: #333;
}

.logout-btn {
    color: #e74c3c;
}

.action-btn:hover {
    background: #f5f5f5;
}

/* Аватар */
.avatar-block {
    text-align: center;
    margin-bottom: 40px;
}

.avatar-container {
    width: 120px;
    height: 120px;
    margin: 0 auto 20px;
    border-radius: 50%;
    overflow: hidden;
    border: 1px solid #eaeaea;
}

.avatar-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.user-name {
    font-size: 20px;
    font-weight: 500;
    margin: 0 0 5px;
}

.user-email {
    color: #777;
    margin: 0;
}

/* Информация */
.info-block {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
}

@media (max-width: 768px) {
    .info-block {
        grid-template-columns: 1fr;
    }
}

.info-section {
    border: 1px solid #eaeaea;
    padding: 20px;
}

.section-title {
    font-size: 18px;
    font-weight: 500;
    margin: 0 0 20px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eaeaea;
}

.info-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}

.info-item {
    display: flex;
    flex-direction: column;
}

.info-label {
    font-size: 13px;
    color: #777;
    margin-bottom: 5px;
}

.info-value {
    font-size: 15px;
}

/* Карточка заказа */
.order-card {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.order-header {
    display: flex;
    justify-content: space-between;
    font-size: 14px;
}

.order-status {
    text-transform: uppercase;
    font-size: 12px;
    letter-spacing: 0.5px;
}

.order-date {
    color: #777;
    font-size: 13px;
}

.order-total {
    font-weight: 500;
    font-size: 16px;
}

.no-orders {
    color: #777;
    font-style: italic;
    margin: 0;
}
</style>
@endsection
