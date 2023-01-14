<!--
@born Ago 20, 2022
@author Rodrigo Brito <contato@rodrigobrito.dev.br>
-->

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" itemscope itemtype="http://schema.org/WebPage">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preload" href="{{ asset('css/site.css') }}" as="style">
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('boxicons/css/boxicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/new-phones-modal.css') }}">
    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @metas

</head>

<body>
    <div class="preloader">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="spinner"></div>
            </div>
        </div>
    </div>

    <header class="top-header top-header-bg">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-6">
                    <div class="top-head-left">
                        <div class="top-contact">
                            <h3>Central de Atendimento: <a href="tel:{{ env('TEL_SUPPORT') }}"
                                    rel="noreferrer">{{ env('TEL_SUPPORT') }}</a>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-6">
                    <div class="top-header-right">
                        <div class="top-header-social top-header-social-bg">
                            <ul>
                                <li>
                                    <a href="https://www.instagram.com/acquaxdobrasil/" target="_blank" rel="noreferrer"
                                        title="Acqua X do Brasil no Instagram">
                                        <i class='bx bxl-instagram'></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>


    <div class="navbar-area">
        <div class="mobile-nav">
            <a href="{{ route('site.home') }}" class="logo text-primary">
                <img src="{{ asset('img/logo.webp') }}" width="200" height="37" alt="{{ env('APP_NAME') }}">
            </a>
        </div>

        <div class="main-nav">
            <div class="container">
                <nav class="navbar navbar-expand-md navbar-light ">
                    <a class="navbar-brand" href="{{ route('site.home') }}">
                        <img src="{{ asset('img/logo.webp') }}" alt="{{ env('APP_NAME') }}" width="300"
                            height="55">
                    </a>
                    <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                        <ul class="navbar-nav m-auto">
                            <li class="nav-item">
                                <a href="{{ route('site.home') }}"
                                    class="nav-link {{ Route::currentRouteName() == 'site.home' ? 'active' : '' }}">
                                    Home
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ Route::currentRouteName() == 'site.home' ? '#' : route('site.home') . '/#company' }}"
                                    class="nav-link"
                                    {{ Route::currentRouteName() == 'site.home' ? 'data-go=#company' : '' }}>
                                    Nossa Empresa
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#"
                                    class="nav-link {{ Route::currentRouteName() == 'site.service.airBlock' ||
                                    Route::currentRouteName() == 'site.service.antiSuctionDevice' ||
                                    Route::currentRouteName() == 'site.service.waterIndividualization' ||
                                    Route::currentRouteName() == 'site.service.pumpMaintenance'
                                        ? 'active'
                                        : '' }}">
                                    Serviços
                                    <i class='bx bx-caret-down'></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="nav-item">
                                        <a href="{{ route('site.service.airBlock') }}" class="nav-link">
                                            Bloqueador de Ar
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('site.service.antiSuctionDevice') }}" class="nav-link">
                                            Dispositivo Anti Sucção
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('site.service.waterIndividualization') }}" class="nav-link">
                                            Individualização de Hidrômetro
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('site.service.pumpMaintenance') }}" class="nav-link">
                                            Manutenção de Bomba
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('site.service.hydrometerMeasurement') }}" class="nav-link">
                                            Medição individual de Água e Gás (Fotometria e Sistema)
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('site.posts') }}"
                                    class="nav-link {{ Route::currentRouteName() == 'site.posts' || Route::currentRouteName() == 'site.post' ? 'active' : '' }}">
                                    Blog
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('site.contact') }}"
                                    class="nav-link {{ Route::currentRouteName() == 'site.contact' ? 'active' : '' }}">
                                    Contato
                                </a>
                            </li>

                        </ul>
                        <div class="nav-side">
                            <div class="nav-side-item">
                                <div class="get-btn">
                                    <a href="{{ route('login') }}"
                                        class="default-btn btn-bg-one border-radius-5 btn-login">Login
                                        <i class='bx bx-chevron-right'></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>

    @yield('content')


    <footer class="footer-area footer-bg2">
        <div class="container">
            <div class="footer-top pt-100 pb-70">
                <div class="row">
                    <div class="col-12 col-md-3">
                        <div class="footer-widget">
                            <div class="footer-logo">
                                <a href="{{ route('site.home') }}">
                                    <img src="{{ asset('img/logo-269x55.webp') }}" width="269" height="55"
                                        alt="{{ env('APP_NAME') }}">
                                </a>
                            </div>
                            <h2 class="text-white">Nossa Missão</h2>
                            <p>Promover a Justiça Social, onde cada consumidor tenha o direito de pagar pelo que
                                consome, contribuindo assim com o ecosistema, gerando economia dos recursos naturais,
                                promovendo o consumo consciente, trabalhando para cada dia mais ter um planeta
                                sustentável.</p>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="footer-widget ps-md-5">
                            <h3>Links</h3>
                            <ul class="footer-list">
                                <li>
                                    <a href="{{ route('site.posts') }}" title="Blog">
                                        <i class='bx bx-chevron-right'></i>
                                        Blog
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('site.contact') }}" title="Contato">
                                        <i class='bx bx-chevron-right'></i>
                                        Contato
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('site.police') }}" title="Política de Privacidade">
                                        <i class='bx bx-chevron-right'></i>
                                        Política de Privacidade
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="footer-widget">
                            <h3>Serviços</h3>
                            <ul class="footer-list">
                                <li>
                                    <a href="{{ route('site.service.airBlock') }}" title="Bloqueador de Ar">
                                        <i class='bx bx-chevron-right'></i>
                                        Bloqueador de Ar
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('site.service.antiSuctionDevice') }}"
                                        title="Dispositivo Anti Sucção">
                                        <i class='bx bx-chevron-right'></i>
                                        Dispositivo Anti Sucção
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('site.service.waterIndividualization') }}"
                                        title="Individualização de Hidrômetro">
                                        <i class='bx bx-chevron-right'></i>
                                        Individualização de Hidrômetro
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('site.service.pumpMaintenance') }}"
                                        title="Manutenção de Bomba">
                                        <i class='bx bx-chevron-right'></i>
                                        Manutenção de Bomba
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('site.service.hydrometerMeasurement') }}"
                                        title=" Medição individual de Água e Gás (Fotometria e Sistema)">
                                        <i class='bx bx-chevron-right'></i>
                                        Medição individual de Água e Gás (Fotometria e Sistema)
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="footer-widget">
                            <h3>Contato</h3>
                            <ul class="footer-contact-list">
                                <li>
                                    <i class="bx bx-phone-call"></i>
                                    <div class="content">
                                        <a href="tel:{{ env('TEL_SUPPORT') }}" rel="noreferrer">
                                            {{ env('TEL_SUPPORT') }}
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <i class="bx bx-phone-call"></i>
                                    <div class="content">
                                        <a href="tel:2139005451" rel="noreferrer">(21) 3900-5451</a>
                                    </div>
                                </li>
                                <li>
                                    <i class="bx bxl-whatsapp"></i>
                                    <div class="content">
                                        <a href="https://wa.me/5521997500020" rel="noreferrer" target="_blank">
                                            (21) 99750-0020
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <i class="bx bx-phone-call"></i>
                                    <div class="content">
                                        <a href="tel:2735001904" rel="noreferrer">(27) 3500-1904</a>
                                    </div>
                                </li>
                                <li>
                                    <i class="bx bxl-whatsapp"></i>
                                    <div class="content">
                                        <a href="https://wa.me/5527999135013" rel="noreferrer" target="_blank">
                                            (27) 99913-5013
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <i class="bx bx-phone-call"></i>
                                    <div class="content">
                                        <a href="tel:1131640085" rel="noreferrer">(11) 3164-0085</a>
                                    </div>
                                </li>
                                <li>
                                    <i class="bx bxl-whatsapp"></i>
                                    <div class="content">
                                        <a href="https://wa.me/5511997535977" rel="noreferrer" target="_blank">
                                            (11) 99753-5977
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <i class="bx bx-message"></i>
                                    <div class="content">
                                        <a href="mailto{{ env('MAIL_SUPPORT') }}" rel="noreferrer">
                                            {{ env('MAIL_SUPPORT') }}
                                        </a>
                                    </div>
                                </li>
                                <li>
                                    <i class='bx bxl-instagram'></i>
                                    <div class="content">
                                        <a href="https://www.instagram.com/acquaxdobrasil/" target="_blank"
                                            rel="noreferrer">
                                            Acqua X no Instagram
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <img src="{{ asset('img/awards-561x118.webp') }}" width="561" alt="Nosso Prêmios">
                    </div>
                </div>
            </div>
        </div>
        <div class="copy-right-area">
            <div class="copy-right-text">
                <p>
                    Copyright © 2022-{{ date('Y') }} {{ env('APP_NAME') }}. Todos os direitos reservados.
                    <a href="https://rodrigobrito.dev.br" target="_blank">Desenvolvido por Rodrigo Brito</a>
                </p>
            </div>
        </div>
    </footer>

    <div class="switch-box">
        <label id="switch" class="switch">
            <input type="checkbox" onchange="toggleTheme()" id="slider">
            <span class="slider round"></span>
        </label>
    </div>

    <div id="new-phones-modal" class="white-popup-block mfp-hide">
        <img src="{{ asset('img/phone-modal.webp') }}" title="Novos telefones de contato"
            alt="Novos telefones de contato">
    </div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('js/wow.min.js') }}"></script>
    <script src="{{ asset('js/mainmenu.js') }}"></script>
    <script src="{{ asset('js/form-validator.min.js') }}"></script>
    <script src="{{ asset('js/contact-form-script.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    @if (Route::currentRouteName() == 'site.home')
        <script src="{{ asset('js/goto.js') }}"></script>
        @yield('custom_js')
    @endif
    <script src="{{ asset('/js/new-phones-modal.js') }}"></script>
</body>

</html>
