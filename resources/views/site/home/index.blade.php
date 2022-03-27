@extends('site.master.master')

@section('content')
    <main class="introduction-bg">
        <div class="introduction container">
            <div class="introduction-content">
                <h1 class="font-1-xxl color-0 fadeInDown" data-anime="200">Os melhores Estágios<span
                        class="color-p1">.</span></h1>
                <p class="font-2-l color-2 fadeInDown" data-anime="400">
                    Vagas com valor e qualidade para agregar conhecimento e alavacar a sua formação. Explore um mundo de
                    possibilidades na {{ env('APP_NAME') }}.
                </p>
                <a class="button fadeInDown" data-anime="600" href="#">
                    Escolha a sua vaga</a>
            </div>
            <picture data-anime="800" class="fadeInDown">
                <img src="{{ asset('site/img/fotos/introduction.webp') }}" width="1280" height="1600"
                    alt="Sucesso em seu estágio">
            </picture>
        </div>
    </main>

    <article class="description-bg">
        <div class="description container">
            <div class="description-content">
                <span class="font-2-l-b color-2">O que somos?</span>
                <h2 class="font-1-xxl color-0">Uma franquia especializada em processos de recrutamento, seleção e
                    gestão de estagiários<span class="color-12">.</span>
                </h2>
                <p class="font-2-l color-2">Nosso objetivo é identiﬁcar, selecionar e entregar os melhores candidatos,
                    integrando empresas e escolas.</p>
                <p class="font-2-l color-2">Nossa ferramenta é um sistema de gestão de estagiários prático e eficaz,
                    garantindo maior essertividade na alocação de candidatos às vagas disponiblizadas.</p>
                <a class="button" href="#">Seja um franquiado</a>
                <div class="description-features">
                    <div>
                        <img src="{{ asset('site/img/icones/velocidade.svg') }}" width="24" height="24" alt="">
                        <h3 class="font-1-m color-0">Recrutamento</h3>
                        <p class="font-2-s color-1">As vagas são cadastradas, parametrizadas e disponibilizadas pelas
                            empresas e automaticamente estarão em exibição para os candidatos.</p>
                    </div>
                    <div>
                        <img src="{{ asset('site/img/icones/rastreador.svg') }}" width="24" height="24" alt="">
                        <h3 class="font-1-m color-0">Seleção</h3>
                        <p class="font-2-s color-1">Os estagiários, além de se candidatarem às vagas disponíveis, estrão com
                            todo seu currículo a mostra, para as empresas selecionarem os perfis mais adequados às suas
                            necessidades.</p>
                    </div>
                </div>
            </div>
            <div class="description-image">
                <img src="{{ asset('site/img/fotos/tecnology.webp') }}" width="1200" height="1920" alt="">
            </div>
        </div>
    </article>

    <section class="testimonial" aria-label="Depoimento">
        <div>
            <img src="{{ asset('site/img/fotos/business.webp') }}" width="1560" height="1360"
                alt="Pessoas comemorando negócio fechado">
        </div>
        <div class="testimonial-content">
            <blockquote class="font-1-xl color-p5">
                <p>A vida passa por vários estágios. Um deles é a busca de grandes experiências para se tornar um excelente
                    profissional</p>
            </blockquote>
            <span class="font-1-m-b color-p4">{{ env('APP_NAME') }}</span>
        </div>
    </section>
@endsection
