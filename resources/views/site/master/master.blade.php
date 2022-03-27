<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $head->title ?? env('APP_NAME') }}</title>
    <meta name="description" content="{{ $head->description }}">
    <link rel="icon" href="{{ asset('img/favicon.svg') }}" type="image/svg+xml">
    <link rel="preload" href="{{ asset('site/css/style.css') }}" as="style">
    <link rel="stylesheet" href="{{ asset('site/css/style.css') }}">

    <script>
        document.documentElement.classList.add('js');
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@1,900&family=Poppins:wght@400;600&family=Roboto:wght@400;500&display=swap"
        rel="stylesheet">
</head>

<body>
    <header class="header-bg">
        <div class="header container font-1-xl color-0">
            <a href="{{ route('home') }}">
                {{ env('APP_NAME') }}
            </a>
            <nav aria-label="primary">
                <ul class="header-menu font-1-m color-0">
                    <li><a href="{{ route('admin.home') }}">Login</a></li>
                </ul>
            </nav>
        </div>
    </header>

    @yield('content')

    <footer class="footer-bg">
        <div class="footer container">
            <span class="font-1-xl color-0">{{ env('APP_NAME') }}</span>
            <div class="footer-contact">
                <h3 class="font-2-l-b color-0">Contato</h3>
                <ul class="font-2-m color-3">
                    <li><a href="tel:+5521992247968">+55 21 9922479-68-9999</a></li>
                    <li><a href="mailto:contato@trayneesystem.com.br">contato@trayneesystem.com.br</a></li>
                    <li>Rio de Janeiro - RJ</li>
                </ul>
                <div class="footer-network">
                    <a href="#">
                        <img src="{{ asset('site/img/redes/instagram.svg') }}" width="32" height="32"
                            alt="Instagram">
                    </a>
                    <a href="#">
                        <img src="{{ asset('site/img/redes/facebook.svg') }}" width="32" height="32" alt="Facebook">
                    </a>
                    <a href="#">
                        <img src="{{ asset('site/img/redes/youtube.svg') }}" width="32" height="32" alt="Youtube">
                    </a>
                </div>
            </div>
            <div class="footer-informacoes">
                <h3 class="font-2-l-b color-0">Informações</h3>
                <nav>
                    <ul class="font-1-m color-3">
                        <li><a href="{{ route('admin.home') }}">Login</a></li>
                    </ul>
                </nav>
            </div>
            <p class="footer-copy font-2-m color-0">{{ env('APP_NAME') }} © Todos direitos reservados.</p>
        </div>
    </footer>

    <script src="{{ asset('site/js/plugins/simple-anime.js') }}"></script>
    <script src="{{ asset('site/js/script.js') }}"></script>
</body>

</html>
