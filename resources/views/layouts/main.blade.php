<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>@yield('title'){{ config('app.name', 'Laravel') }} {!! Helper::siteSettings('city','1') !!}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{ asset('templates/slickSlider/slick.css') }}" rel="stylesheet">
<link href="{{ asset('templates/dist/css/fontawesome.min.css') }}" rel="stylesheet">
<link href="{{ asset('templates/dist/css/styles.css') }}" rel="stylesheet">
<link href="{{ asset('templates/dist/css/card.css') }}" rel="stylesheet">
<link href="{{ asset('templates/dist/css/print.css') }}" rel="stylesheet">
<link href="{{ asset('templates/dist/css/video.css') }}" rel="stylesheet">
<link href="{{ asset('templates/dist/css/lk.css') }}" rel="stylesheet">
<link href="{{ asset('templates/dist/css/basket.css') }}" rel="stylesheet">
<link href="{{ asset('templates/dist/css/catalog.css') }}" rel="stylesheet">
<link href="{{ asset('templates/dist/css/compare.css') }}" rel="stylesheet">
<link href="{{ asset('templates/dist/css/favourites.css') }}" rel="stylesheet">
<link href="{{ asset('templates/dist/css/glossary.css') }}" rel="stylesheet">
<link href="{{ asset('templates/dist/css/delivery.css') }}" rel="stylesheet">
<link href="{{ asset('templates/dist/css/documents.css') }}" rel="stylesheet">
<link href="{{ asset('templates/dist/css/fc.css') }}" rel="stylesheet">
<link href="{{ asset('templates/dist/css/service.css') }}" rel="stylesheet">
<link href="{{ asset('templates/dist/css/sale.css') }}" rel="stylesheet">
<link href="{{ asset('templates/dist/css/certificate.css') }}" rel="stylesheet">
<link href="{{ asset('templates/dist/css/contacts.css') }}" rel="stylesheet">
<link href="{{ asset('templates/dist/css/news.css') }}" rel="stylesheet">
<link href="{{ asset('templates/dist/css/tem-news.css') }}" rel="stylesheet">
<link href="{{ asset('templates/dist/css/vacancy.css') }}" rel="stylesheet">
<link href="{{ asset('templates/dist/css/staff.css') }}" rel="stylesheet">
<link href="{{ asset('templates/dist/css/sertificate.css') }}" rel="stylesheet">
<link href="{{ asset('templates/dist/css/search.css') }}" rel="stylesheet">
<link href="{{ asset('templates/dist/css/objects.css') }}" rel="stylesheet">
<link href="{{ asset('templates/dist/css/jquery.formstyler.css') }}" rel="stylesheet">
<link href="{{ asset('templates/dist/css/jquery-ui.css') }}" rel="stylesheet">
<link href="{{ asset('templates/dist/css/plyr.css') }}" rel="stylesheet">
<link href="{{ asset('templates/dist/css/suggestions.min.css') }}" rel="stylesheet">

    <script src="{{ asset('templates/slickSlider/jquery-3.5.0.min.js') }}"></script>
    <script src="{{ asset('templates/dist/js/jquery.suggestions.min.js') }}"></script>
    <script src="{{ asset('templates/slickSlider/slick.min.js') }}"></script>
    <script src="{{ asset('templates/dist/js/jquery.cookie.js') }}"></script>
    <script src="{{ asset('templates/dist/js/jquery.formstyler.min.js') }}"></script>
    <script src="{{ asset('templates/dist/js/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('templates/dist/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('templates/dist/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('templates/dist/js/plyr.polyfilled.js') }}"></script>

    <script src="{{ asset('templates/dist/js/functions.js') }}"></script>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <link  href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('templates/dist/favicon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('templates/dist/favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('templates/dist/favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('templates/dist/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('templates/dist/favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('templates/dist/favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('templates/dist/favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('templates/dist/favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('templates/dist/favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('templates/dist/favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('templates/dist/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('templates/dist/favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('templates/dist/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('templates/dist/favicon/manifest.json') }}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('templates/dist/favicon/ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">
    <link rel="shortcut icon" href="{{ asset('templates/dist/favicon/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('templates/dist/favicon/favicon.ico') }}" type="image/x-icon">

</head>
<body>dfg
<div class="main-wrap">
<article class="main">
    @widget('siteCatalogMenu')

    <section>
        <header class="header">
            <div class="header-row header-row__top">
                <div class="header-col header-col__middle header-top-menu">
                    <div class="header-menu">
                        @widget('menuHeader')
                        <div class="header-contacts__item header-phone">
                            <a href="tel:*7896">
                                *7896
                                <svg width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.57653 4.02911C4.49939 4.87492 4.46161 5.30798 4.8267 5.67318C5.19191 6.0384 5.62503 6.00056 6.47094 5.92341C7.24659 5.85268 8.2891 5.78169 9.19849 6.69109C9.61092 7.10353 10.0224 7.7505 9.99905 8.47375C9.97331 9.27183 9.43491 9.9353 8.40794 10.3485C7.90362 10.5515 7.33755 10.5276 6.80813 10.4107C6.27173 10.2922 5.71616 10.0656 5.19264 9.79567C4.14877 9.2575 3.15184 8.50495 2.57351 7.92665C1.9952 7.34833 1.24252 6.35138 0.704319 5.30743C0.434417 4.7839 0.207846 4.22832 0.0893374 3.69191C-0.0276297 3.16249 -0.0514804 2.59641 0.151455 2.09208C0.564697 1.0651 1.22816 0.526692 2.02623 0.500947C2.74946 0.477617 3.39643 0.889082 3.80886 1.30152C4.71825 2.21093 4.64727 3.25344 4.57653 4.02911Z" fill="#AAAAAA"/>
                                </svg>
                            </a>
                        </div>
                        <div
                            class="header-contacts__item header-phone header-phone-changable">
                            <a class="js-current-header-phone" href="tel:+74959319631">
                                <span>+7 (495) 931-96-31</span>
                            </a> - Головной офис Москва
                        </div>
                        <div class="header-contacts__item feedback">
                            <div class="header-contacts__item feedback" data-web_form_text_id="letter_to_boss"><a data-fancybox data-type="iframe" data-src="/siteform/0/3" href="javascript:;">Связаться с нами</a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-row header-row__bottom">
                <div href="/" class="header-col header-col__left">
                    <a href="/">
                        <img class="header-logo" src="{{ asset('templates/img/logo_new.svg') }}" alt="">
                    </a>

                    <span class="city-selection" data-type="header">{!! Helper::siteSettings('city','1') !!}</span>
                </div>
                <div class="header-col header-col__middle">
                    <div class="header-search">
                        <div class="header-search__catalog">
                            <img src="{{ asset('templates/img/burger.svg') }}" alt="">
                            <p>Каталог товаров</p>
                            @widget('mobileSiteCatalogMenu')
                        </div>
                        <div class="header-search__input">
                            <form onsubmit="window.location = '/search/' + searchText.value; return false;" id="title-search" method="get" action="{{ route('searchAjax') }}" class="header-search__form">
                                <input id="searchText" name="q"
                                       class="input valid-email search-input"
                                       type="search"
                                       placeholder="Введите название или артикул"
                                       value="">
                                <button class="search-btn" type="submit" onclick="search()" name="s">Найти</button>
                            </form>
                            <div class="search-results show-results"></div>
                        </div>
                    </div>
                </div>
                <div class="header-col header-col__right header-col__controls">
                    <div
                        class="header-contacts__item header-phone header-phone-changable">

                    </div>

                    <div class="header-controls">
                        <a class="cloud-phone" href="tel:{!! Helper::siteSettings('phone','1') !!}">
                            <span>{!! Helper::siteSettings('phone','1') !!}</span>
                        </a><br>

                    </div>
                </div>
            </div>
        </header>
    </section>

    <section>

    </section>

@yield('content')

</article>
</div>
<section>
<div class="footer">
    <div class="footer-inner">
        <div class="footer-row">
            <div class="footer-col footer-col-logo">
                <a href="/">
                    <img class="header-logo" src="{{ asset('templates/img/logo_new.svg') }}" alt="">
                </a>
                <span class="city-selection js-current-city" data-type="header">{!! Helper::siteSettings('city','1') !!}</span>
            </div>
            @widget('menuFooter')
            <div class="footer-col">
                <div class="footer-col__list">
                    <div class="footer-contacts">
                        <div class="footer-contacts__row">
                            <div class="footer-contacts__col">
                                <a class="contacts-phone" href="tel:{!! Helper::siteSettings('phone','1') !!}">{!! Helper::siteSettings('phone','1') !!}</a>
                                <p class="contacts-mail">
                                    <a href="mailto:{!! Helper::siteSettings('emailNotifications','1') !!}">{!! Helper::siteSettings('emailNotifications','1') !!}</a>                                        </p>
                            </div>
                            <div class="footer-contacts__col">
                                <style>
                                    #del_mon,
                                    #del_fri,
                                    #del_tom {
                                        display: none;
                                    }
                                </style>
                                <p id="del_fri" style="display: block;">
                                    <style>
                                        #del_mon,
                                        #del_fri,
                                        #del_tom {
                                            display: none;
                                        }
                                    </style> <span id="del_fri"> <strong>с 08:00 до 18:00 (Пн-Пт)<br>
 info@doorlock.ru </strong></span> <span id="del_tom"> <strong>с 09:00 до 18:00 (Сб-Вс)<br>
 <span style="font-size: 10px;">Удаленно работает дежурный менеджер.</span><br>
 <span style="color: #ec1619;font-size: 10px;">Склад и офис закрыты до понедельника</span><br>
 info@doorlock.ru </strong></span>                                        </p>
                                <p id="del_tom" style="font-size: 10px">
                                    Удаленно работает дежурный менеджер.<br>
                                    <span style="color: #ec1619">Склад и офис закрыты до понедельника</span>
                                </p>
                                <p class="contacts-call" ><a data-fancybox data-type="iframe" data-src="/siteform/0/2" href="javascript:;">Обратный звонок</a></p>
                            </div>
                        </div>
                        <div class="footer-contacts__row">
                            <div class="footer-contacts__col">
                                <p class="contacts-adress">
                                    {!! Helper::siteSettings('address','1') !!}                                      </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-row">
            <div class="footer-col">
                <p class="footer-copyright">
                    1996-{{ date("Y") }} - Интернет-магазин “DOORLOCK”</p>
                <p class="footer-copyright">
                    Представительство - {!! Helper::siteSettings('city','1') !!}</p>
            </div>
        </div>
    </div>
</div>
</section>
<script src="{{ asset('templates/dist/js/index.js') }}"></script>
<script src="{{ asset('templates/dist/js/lk.js') }}"></script>
<script src="{{ asset('templates/dist/js/compare.js') }}"></script>
<script src="{{ asset('templates/dist/js/auth.js') }}"></script>
<script src="{{ asset('templates/dist/js/catalog.js') }}"></script>
<script src="{{ asset('templates/dist/js/card.js') }}"></script>
<script src="{{ asset('templates/dist/js/video.js') }}"></script>
<script src="{{ asset('templates/dist/js/catalog-helper.js') }}"></script>
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>

<script>
    function showMainSearch() {
        let mainSearch = $('.search-input');
        let form = mainSearch.parents('form');

        let xhr;
        mainSearch.on('input', function() {
            let value = mainSearch.val().trim();
            if (value.length > 3) {
                if(xhr && xhr.readyState != 4){
                    xhr.abort();
                }

                xhr = $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    dataType: "json",
                    data: {
                        _token: '{{csrf_token()}}',
                        searchText: value,
                    },
                    success: function (response) {
                        let arrayCount = 0;
                        $.each(response.data, function (key, value) {
                            arrayCount++;
                        });
                        //alert(arrayCount);
                        $('.search-results').removeClass('show-results');
                        $('.search-results').empty();
                        $('.search-results').addClass('show-results');
                        $.each(response.data, function (key, value) {
                                                     $('.search-results').append('' +
                                '<a class="search-results__item" href="' + value.link + '">' +
                                    '<div class="search-results__col" style="width:50px;text-align: center;">' +
                                    '<img src="' + value.images + '" alt="' + value.name + '" style="max-height: 50px;max-width:50px;">' +
                                    '</div>' +
                                    '<div class="search-results__col">' +
                                        '<div class="search-results__name">' + value.name + '</div>' +
                                    '<div class="search-results__price">' +
                                    '' + value.price + ' руб.' +
                                    '</div>' +
                                    '</div>' +
                                '</a>');

                        });
                        $('.search-results').append('' +
                            '<a href="/search/' + response.searchQuery + '" class="search-results__all">\n' +
                            'Все результаты' +
                            '</a>');
                    },
                    error: function (jqXHR, status, error) {
                        $('.search-results').removeClass('show-results');
                        $('.search-results').empty();
                        $('.search-results').addClass('show-results');
                        $('.search-results').append('' +
                            '<a href="#" class="search-results__all">\n' +
                            'Нет результатов по данному запросу\n' +
                            '</a>');
                    },
                });
            } else {
                $('.search-results').removeClass('show-results');
            }
        });
    }
    showMainSearch();
    $('[data-fancybox]').fancybox({
        animationEffect: "zoom-in-out",
        toolbar: false,
        smallBtn: true,
        modal: false,
        iframe : {
            preload : true,
            attr: {
                scrolling: "auto"
            },
            css : {
                width : '100%',
                height  : '100%',
                margin: '0'
            }
        }
    })
</script>

{!! Helper::siteSettings('javaCode','1') !!}
@yield('javascriptfb')
</body>
</html>


