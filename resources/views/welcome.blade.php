<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - ORCHID</title>
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="stylesheet" type="text/css" href="{{mix('/css/app.css')}}">

    <link rel="apple-touch-icon" sizes="180x180" href="/orchid/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/orchid/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/orchid/favicon/favicon-16x16.png">
    <link rel="manifest" href="/orchid/favicon/manifest.json">
    <link rel="mask-icon" href="/orchid/favicon/safari-pinned-tab.svg" color="#1a2021">
    <meta name="apple-mobile-web-app-title" content="ORCHID">
    <meta name="application-name" content="ORCHID">
    <meta name="theme-color" content="#ffffff">

    <meta name="turbolinks-root" content="/">

    <meta http-equiv="X-DNS-Prefetch-Control" content="on"/>
    <link rel="dns-prefetch" href="{{ config('app.url') }}"/>
    <link rel="dns-prefetch" href="https://fonts.googleapis.com"/>


    <script src="{{ mix('/js/manifest.js')}}" type="text/javascript"></script>
    <script src="{{ mix('/js/vendor.js')}}" type="text/javascript"></script>
    <script src="{{ mix('/js/app.js')}}" type="text/javascript"></script>
</head>
<body>


<nav class="site-header sticky-top bg-white">
    <div class="site-header sticky-top bg-dark" style="background: #333333;">
        <div class="container d-flex flex-column flex-md-row justify-content-between" style="align-items: center;">
            <a href="#" class="mr-5">
                <img src="/img/logo.svg" height="50px" alt="Responsive image">
            </a>
            <h5 class="my-0 mr-md-auto font-weight-normal text-white">15:17, 18 июля, среда</h5>
            <div class="my-2 my-md-0">
                <span class="p-2 text-white" href="#">USD: 63,05   0,45</span>
                <span class="p-2 text-white" href="#">EUR: 73,26   0,30</span>
                <span class="p-2 text-white" href="#">Brent: 71,74   0,00</span>
            </div>
        </div>
    </div>
</nav>


<main id="app" class="container pt-5 pb-5">


    <div class="row justify-content-md-center" data-controller="news" data-news-type="group" data-news-paginate="2" data-news-id="{{$records['groups']}}" data-news-load="0">
        <div class="group-news col col-lg-9">

            @include('partials.group')

        </div>
        <div class="last-news col col-lg-3" data-controller="news" data-news-type="last" data-news-paginate="2" data-news-id="{{$records['article']}}" data-news-load="0">

            <div class="pb-2">
                <h2>Топ новости часа</h2>
            </div>

            @include('partials.news')

        </div>
    </div>
</main>


<footer class="container">
    <div class="pt-4 my-md-5 pt-md-5 border-top">
        <div class="row">
        <div class="col-12 col-md">
            <img class="mb-2" height="50px" src="/img/logo2.svg">
            <small class="d-block mb-3 text-muted">&copy; 2017-2018</small>
        </div>
        <div class="col-6 col-md">
            <h5>Features</h5>
            <ul class="list-unstyled text-small">
                <li><a class="text-muted" href="#">Партнёрам</a></li>
                <li><a class="text-muted" href="#">Рекламодателям</a></li>
                <li><a class="text-muted" href="#">Наши проекты</a></li>
            </ul>
        </div>
        <div class="col-6 col-md">
            <h5>Resources</h5>
            <ul class="list-unstyled text-small">
                <li><a class="text-muted" href="#">Наша команда</a></li>
                <li><a class="text-muted" href="#">Наши офисы</a></li>
                <li><a class="text-muted" href="#">Вакансии</a></li>
            </ul>
        </div>
        <div class="col-6 col-md">
            <h5>About</h5>
            <ul class="list-unstyled text-small">
                <li><a class="text-muted" href="#">Team</a></li>
                <li><a class="text-muted" href="#">Новости</a></li>
                <li><a class="text-muted" href="#">О нас</a></li>
            </ul>
        </div>
    </div>
    </div>
</footer>

</body>
</html>
