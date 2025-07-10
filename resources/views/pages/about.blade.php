@extends('layout.main')
@section('content')

<div class="breadcrumbs">
    <div class="breadcrumbs__text wrap">
    <a href="{{route('home')}}">Главная</a>
        <p>→</p>
        <p>О компании</p>
    </div>
</div>
<div class="about">
    <div class="about__content wrap">
        <h2 class="about__title">
            Интернет-магазин <br>
            Style Street
        </h2>
        <p class="about__subtitle">
            Добро пожаловать в Style Street – ваш источник подлинных кроссовок Nike и <br> непревзойденного стиля! Мы
            рады представить вам уникальную онлайн-платформу, где<br> вы сможете окунуться в мир инноваций и моды от
            легендарного бренда спортивной обуви.
        </p>
        <img src="../../media/about/about.png" alt="#" class="aboutimg">

        <div class="about__items">
            <div class="about__item">
                <p class="about__item-title">
                    Легендарное наследие Nike:
                </p>
                <p class="about__item-text">
                    Style Street - это место, где история и стиль сливаются воедино. Мы гордимся тем, что предлагаем вам
                    только оригинальные кроссовки Nike, продукцию, которая воплощает более чем полувековое наследие
                    инноваций, комфорта и качества. Каждая пара кроссовок – это не просто спортивная обувь, это произведение
                    искусства, воплощающее дух победы и страстную преданность активному образу жизни. <br>
                    Style Street - это не просто интернет-магазин, а место, где ваша страсть к стилю и качеству встретится с
                    легендарной маркой Nike. Мы стремимся предоставлять нашим клиентам только подлинные продукты, которые
                    отражают высший стандарт дизайна, инноваций и технологий, заложенных в каждой паре кроссовок Nike.
                </p>
            </div>
            <div class="about__item about__item-right">
                <p class="text__title">
                    Подпишитесь на рассылку
                </p>
                <p class="text__subtitle">
                    Регулярные скидки и спецпредложения, а так же  новости компании.
                </p>
                <input type="email" placeholder="Ваш email" class="about__input">
                <button class="about__itembtn">Подписатся</button>
                <a href="#" class="polit">Согласен с политикой конфиденциальности</a>
            </div>
        </div>
        <div class="about__items"></div>
    </div>
</div>
@endsection
