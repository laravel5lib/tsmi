<!doctype html>
<html lang="{{ app()->getLocale() }}" data-controller="html-load">
<head>
    <meta name="robots" content="noindex">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','Твоё СМИ - Новостной агрегатор. Самые последний и свежие новости в России, в сети, в мире. Узнавайте новости первыми.')</title>
    <meta name="description"
          content="@yield('description','Самые горячие новости в России, в США, в мире. Последние события в мире новостей.')">
    <meta name="keywords"
          content="@yield('keywords','Новости, вести, события, последние, горячее, в мире, в России, в США.')">
    <meta name="csrf_token" content="{{csrf_token()}}">
    <link rel="stylesheet" type="text/css" href="{{mix('/css/app.css')}}">


    {{-- favicon --}}
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#83c600">
    <meta name="msapplication-TileColor" content="#83c600">
    <meta name="theme-color" content="#ffffff">
    {{-- /favicon --}}


    <meta name="turbolinks-root" content="/">
    <meta http-equiv="X-DNS-Prefetch-Control" content="on"/>
    <link rel="dns-prefetch" href="{{ config('app.url') }}"/>

    <script src="{{ mix('/js/manifest.js')}}" type="text/javascript"></script>
    <script src="{{ mix('/js/vendor.js')}}" type="text/javascript"></script>
    <script src="{{ mix('/js/app.js')}}" type="text/javascript"></script>
</head>
<body>


<nav class="site-header sticky-top bg-white">
    <div class="site-header sticky-top bg-dark" style="background: #333333;">
        <div class="container d-flex flex-column flex-md-row justify-content-between" style="align-items: center;">
            <a href="{{url('/')}}" class="mr-5">
                <img async src="/img/logo.svg" height="50px" alt="Responsive image">
            </a>
            <h5 class="my-0 mr-md-auto font-weight-normal text-white">15:17, 18 июля, среда</h5>

            <div class="my-2 my-md-0">
                <span class="p-2 text-white">
                    <span class="text-muted">USD:</span>
                    63,05
                    <span class="text-success">&#8593; 0,45</span>
                </span>
                <span class="p-2 text-white">
                    <span class="text-muted">EUR:</span>
                    73,26
                    <span class="text-success">&#8593; 0,30</span>
                </span>
                <span class="p-2 text-white">
                    <span class="text-muted">Brent:</span>
                    71,74
                    <span class="text-danger">&#8595; 0,01</span>
                </span>
            </div>
        </div>
    </div>
</nav>

<main id="app" class="container pt-5 pb-5">
    @yield('content')
</main>


<footer class="container">
    <div class="pt-4 my-md-5 pt-md-5 border-top">
        <div class="row">
            <div class="col-12 col-md">
                <img async class="mb-2" height="50px" src="/img/logo2.svg">
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


<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function () {
            try {
                w.yaCounter49787614 = new Ya.Metrika2({
                    id: 49787614,
                    clickmap: true,
                    trackLinks: true,
                    accurateTrackBounce: true,
                    webvisor: true
                });
            } catch (e) {
            }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () {
                n.parentNode.insertBefore(s, n);
            };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/tag.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else {
            f();
        }
    })(document, window, "yandex_metrika_callbacks2");
</script>
<noscript>
    <div><img async src="https://mc.yandex.ru/watch/49787614" style="position:absolute; left:-9999px;" alt=""/></div>
</noscript>
<!-- /Yandex.Metrika counter -->

</body>
</html>
