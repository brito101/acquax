@extends('site.master.master')

@section('content')
    <div class="banner-slider-area">
        <div class="banner-slider owl-carousel owl-theme">
            <div class="banner-item item-bg1">
                <div class="d-table">
                    <div class="d-table-cell">
                        <div class="container">
                            <div class="banner-item-content">
                                <h1>Individualização de Água e Gás</h1>
                                <p>Realizamos obra de individualização em prédios novos e antigos com tecnologia de ponta.
                                </p>
                                <div class="banner-btn">
                                    <a href="{{ route('site.service.waterIndividualization') }}"
                                        class="default-btn btn-bg-three border-radius-5">Saiba Mais <i
                                            class='bx bx-chevron-right'></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="banner-item item-bg2">
                <div class="d-table">
                    <div class="d-table-cell">
                        <div class="container">
                            <div class="banner-item-content">
                                <h1>Medição de Água, Gás e Energia</h1>
                                <p>Realizamos medição por foto medição automática, medição visual e sistema de telemetria
                                    com medição diária ou mensal
                                </p>
                                <div class="banner-btn">
                                    <a href="{{ route('site.service.hydrometerMeasurement') }}"
                                        class="default-btn btn-bg-three border-radius-5">Saiba Mais <i
                                            class='bx bx-chevron-right'></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="banner-item item-bg3">
                <div class="d-table">
                    <div class="d-table-cell">
                        <div class="container">
                            <div class="banner-item-content">
                                <h1>Manutenção de Bomba de Água</h1>
                                <p>Previne a queima de motor e diminui o gasto excessivo de
                                    energia causado pelo mal funcionamento do equipamento
                                </p>
                                <div class="banner-btn">
                                    <a href="{{ route('site.service.pumpMaintenance') }}"
                                        class="default-btn btn-bg-three border-radius-5">Saiba Mais <i
                                            class='bx bx-chevron-right'></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="work-process-area-two pt-70 pb-70" id="company">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <img src="{{ asset('img/logo-776x143.webp') }}"
                    alt="Acqua X do Brasil - Garantimos o futuro trabalhando com sustentabilidade" style="max-width: 776px;"
                    width="776">
                <div class="col-lg-7 pt-2">
                    <div class="row d-flex align-items-end">
                        <div class="col-lg-6 col-sm-6">
                            <div class="work-process-card-two">
                                <div class="number-title"><i class="bx bx-buildings"></i></div>
                                <h2>600+</h2>
                                <p>Prédios Individualizados</p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6">
                            <div class="work-process-card-two">
                                <div class="number-title"><i class="bx bxs-tachometer"></i></div>
                                <h2>300.000+</h2>
                                <p>Hidrômetros Instalados</p>
                            </div>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-6 col-sm-6">
                            <div class="work-process-card-two">
                                <div class="number-title"><i class="bx bxs-chart"></i></div>
                                <h2>50.000+</h2>
                                <p>Pontos de Gestão e Medição</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="work-process-rightside">
                        <div class="section-title">
                            <span class="sp-color1">Somos especialistas em garantir economia!</span>
                            <h2>Conheça nossa Empresa</h2>
                            <p>A mais de 15 anos no mercado, contamos com uma equipe especializada em prestar serviços de
                                alta qualidade, segurança, com o melhor suporte e atendimento do país.
                            </p>
                            <p>Em constante processo de inovação, a AcquaX do Brasil desenvolve projetos com a mais alta
                                tecnologia para garantir a eficiência, praticidade e modernidade aos nossos clientes.
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="services-area pt-100 pb-70">
        <div class="container">
            <div class="section-title text-center">
                <h2>Conheça os Serviços da Acqua X do Brasil</h2>
                <p>Todos os nossos serviços são realizados por profissionais especializados e com tecnologia de ponta</p>
            </div>
            <div class="row pt-45">
                <div class="col-lg-4 col-sm-6">
                    <div class="services-card" style="height: 300px">
                        <div>
                            <img src={{ asset('img/card-1.webp') }} alt="Medição Individual de Água e Gás" width="200"
                                height="180">
                        </div>
                        <h3><a href="{{ route('site.service.hydrometerMeasurement') }}"
                                title="Medição Individual de Água e Gás">Medição Individual de Água e Gás</a>
                        </h3>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="services-card" style="height: 300px">
                        <div>
                            <img src={{ asset('img/card-2.webp') }} alt="Individualização de Hidrômetro" width="200"
                                height="180">
                        </div>
                        <h3><a href="{{ route('site.service.waterIndividualization') }}"
                                title="Individualização de Hidrômetro">Individualização de Hidrômetro</a></h3>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="services-card" style="height: 300px">
                        <div>
                            <img src={{ asset('img/card-3.webp') }} alt="Bloqueador de Ar" width="200" height="180">
                        </div>
                        <h3><a href="{{ route('site.service.airBlock') }}" title="Bloqueador de Ar">Bloqueador
                                de Ar</a></h3>
                    </div>
                </div>
            </div>
            <div class="row pt-10 d-flex justify-content-center">
                <div class="col-lg-4 col-sm-6">
                    <div class="services-card" style="height: 300px">
                        <div>
                            <img src={{ asset('img/card-4.webp') }} alt="Manutenção de Bombas" width="200"
                                height="180">
                        </div>
                        <h3><a href="{{ route('site.service.pumpMaintenance') }}" title="Manutenção de Bombas">Manutenção
                                de Bombas</a></h3>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="services-card" style="height: 300px">
                        <div>
                            <img src={{ asset('img/card-5.webp') }} alt="Dispositivo Anti Sucção" width="200"
                                height="180">
                        </div>
                        <h3><a href="{{ route('site.service.antiSuctionDevice') }}"
                                title="Dispositivo Anti Sucção">Dispositivo Anti Sucção</a></h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="call-us-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="call-contact">
                        <h3 class="pb-2">Acompanhe seu consumo pelo nosso Aplicativo</h3>
                        <p>O nosso aplicativo AcquaXcontrol é simples de mexer e prático, você consegue acompanhar o seu
                            consumo em tempo real na palma da sua mão, além de ter acesso a comparativos dos meses
                            anteriores e gerar demonstrativos sempre que precisar.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="call-us-img py-5">
                        <img src="{{ asset('img/app.webp') }}" alt="Aplicativo" width="298" height="589">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="about-area about-bg2 pt-100 pb-70">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="about-img-5">
                        <img src="{{ asset('img/surprise.webp') }}" alt="Surpresas na conta de água?" width="384"
                            height="374">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-content-3 ml-20">
                        <div class="section-title">
                            <span class="sp-color8">Pague apenas pelo seu consumo</span>
                            <h2>Vantagens de Individualizar</h2>
                            <p>Você pagar apenas sua conta de água não é a única vantagem da individualização de água.</p>
                        </div>
                        <h3>Economia na conta de água</h3>
                        <div class="all-skill-bar">
                            <div class="skill-bar" data-percentage="50%">
                                <h4 class="progress-title-holder clearfix">
                                    <span class="progress-title">Redução na conta de água em até 50%, dependendo da
                                        estrutura do condomínio.</span>
                                    <span class="progress-number-wrapper">
                                        <span class="progress-number-mark">
                                            <span class="percent"></span>
                                        </span>
                                    </span>
                                </h4>
                                <div class="progress-content-outter">
                                    <div class="progress-content"></div>
                                </div>
                            </div>
                        </div>
                        <h3>Valorização do Imóvel</h3>
                        <div class="all-skill-bar">
                            <div class="skill-bar" data-percentage="15%">
                                <h4 class="progress-title-holder clearfix">
                                    <span class="progress-title">Imóveis em condomínios individualizados tem uma
                                        valorização de até 15%.</span>
                                    <span class="progress-number-wrapper">
                                        <span class="progress-number-mark">
                                            <span class="percent"></span>
                                        </span>
                                    </span>
                                </h4>
                                <div class="progress-content-outter">
                                    <div class="progress-content"></div>
                                </div>
                            </div>
                        </div>
                        <h3>Menos Reclamações</h3>
                        <div class="all-skill-bar">
                            <div class="skill-bar" data-percentage="100%">
                                <h4 class="progress-title-holder clearfix">
                                    <span class="progress-title">Reduz as reclamações dos condôminos sobre a conta de
                                        água.</span>
                                    <span class="progress-number-wrapper">
                                        <span class="progress-number-mark">
                                            <span class="percent"></span>
                                        </span>
                                    </span>
                                </h4>
                                <div class="progress-content-outter">
                                    <div class="progress-content"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="choose-area-two pt-5 pb-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="choose-content-two">
                        <div class="section-title">
                            <h2>Medidor de caixa d'água via Bluetooth e Wi-Fi</h2>
                            <p class="pb-3">O medidor de caixa d'água possibilita o controle do consumo da água no
                                condomínio e o
                                monitoramento do funcionamento das bombas.
                            </p>
                            <a href="{{ route('site.contact') }}"
                                class="default-btn btn-bg-three border-radius-5 text-center">Solicitar
                                Orçamento</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="choose-img-two">
                        <img src="{{ asset('img/water-box.webp') }}" alt="Medidor de caixa d'água" width="460"
                            height="275">
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="choose-img-two">
                        <img src="{{ asset('img/houseplant.webp') }}"
                            alt="Medidor via Bluetooth e Wi-Fi / Planta de Incêndio" width="460" height="275">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="choose-content-two">
                        <div class="section-title">
                            <h2>Medidor via Bluetooth e Wi-Fi / Planta de Incêndio</h2>
                            <p class="pb-3">Atendendo as necessidades do mercado e dos nossos clientes, adicionamos estes
                                2 serviços para
                                condomínios, com a qualidade AcquaX.
                            </p>
                            <a href="{{ route('site.contact') }}"
                                class="default-btn btn-bg-three border-radius-5 text-center">Solicitar
                                Orçamento</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="services-area-four pt-100 pb-70">
        <div class="container">
            <div class="section-title text-center">
                <span class="sp-color8">Blog</span>
                <h2>Confira nossas últimas postagens!</h2>
            </div>
            <div class="row justify-content-center align-items-center pt-45">

                @forelse ($posts as $post)
                    <div class="col-lg-4 col-md-6">
                        <div class="services-card services-card-color-bg2">
                            <a href="{{ route('site.post', ['slug' => $post->slug]) }}">
                                <img src="{{ $post->cover ? url('storage/posts/' . $post->cover) : asset('img/share.jpg') }}"
                                    alt="{{ $post->title }}">
                            </a>
                            <h3><a href="{{ route('site.post', ['slug' => $post->slug]) }}">{{ $post->title }}</a>
                            </h3>
                            <p>{{ Str::limit($post->headline, 80) }}</p>
                            <a href="{{ route('site.post', ['slug' => $post->slug]) }}" class="learn-btn">Saiba Mais
                                <i class='bx bx-chevron-right'></i></a>
                        </div>
                    </div>
                @empty
                    Em breve...
                @endforelse

            </div>
        </div>
    </section>
@endsection

@section('custom_js')
    <script>
        $('.owl-dot').attr('aria-label', 'botão de navegação do slide');
    </script>
@endsection
