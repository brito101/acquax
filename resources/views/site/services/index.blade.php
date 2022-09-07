@extends('site.master.master')

@section('content')
    <div class="inner-banner">
        <div class="container">
            <div class="inner-title text-center">
                <h3>O que fazemos?</h3>
                <ul>
                    <li>Para Empresas</li>
                </ul>
            </div>
        </div>
        <div class="inner-shape">
            <img src="assets/images/shape/inner-shape.png" alt="Images">
        </div>
    </div>


    <div class="about-area ptb-100">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="about-play">
                        <img src="{{ asset('img/about-img1.jpg') }}" alt="About Images">
                        <div class="about-play-content">
                            <span class="pt-5">Assista nosso vídeo de introdução</span>
                            <h2>A solução para a sua empresa!</h2>
                            <div class="play-on-area">
                                <a href="https://www.youtube.com/watch?v=tUP5S4YdEJo" class="play-on popup-btn"><i
                                        class="bx bx-play"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-content ml-25">
                        <div class="section-title">
                            <span class="sp-color2">Para Empresas de</span>
                            <h2>Pequeno ou Grande Porte</h2>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <ul class="about-list text-start">
                                    <li><i class="bx bxs-check-circle"></i>Escritórios de advocacia e contabilidade</li>
                                    <li><i class="bx bxs-check-circle"></i>Clínicas odontológicas, veterinárias e estética
                                    </li>
                                    <li><i class="bx bxs-check-circle"></i>Academias</li>
                                    <li><i class="bx bxs-check-circle"></i>Restaurantes, padarias e lojas em geral</li>
                                </ul>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <ul class="about-list about-list-2 text-start">
                                    <li><i class="bx bxs-check-circle"></i>Farmácias</li>
                                    <li><i class="bx bxs-check-circle"></i>Colégios, escolas profissionalizantes e creches
                                    </li>
                                    <li><i class="bx bxs-check-circle"></i>Indústrias e fábricas</li>
                                    <li><i class="bx bxs-check-circle"></i>Prefeituras</li>
                                </ul>
                            </div>
                        </div>
                        <p class="about-content-text">E muito mais!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="choose-area pt-100 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="about-content choose-content mr-20">
                        <div class="section-title">
                            <span class="sp-color1">Na {{ env('APP_NAME') }}</span>
                            <h2>Realizamos o trabalho de:</h2>
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <ul class="about-list text-start">
                                        <li class="text-white"><i class="bx bxs-check-circle"></i>Captação de candidatos
                                        </li>
                                        <li class="text-white"><i class="bx bxs-check-circle"></i>Contratação do
                                            estagiário </li>
                                        <li class="text-white"><i class="bx bxs-check-circle"></i>Elaboração de
                                            contratos</li>
                                        <li class="text-white"><i class="bx bxs-check-circle"></i>Banco de currículos
                                        </li>
                                        <li class="text-white"><i class="bx bxs-check-circle"></i>Disponibilizamos
                                            Sistema ONLINE de Gestão e Controle para toda parte burocrática
                                            Aditivos em termos em andamento</li>
                                    </ul>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <ul class="about-list about-list-2 text-start">
                                        <li class="text-white"><i class="bx bxs-check-circle"></i>Aditivos em termos em
                                            andamento</li>
                                        <li class="text-white"><i class="bx bxs-check-circle"></i>Folha de Pagto dos
                                            estagiários em forma de bolsa auxilio, auxilio transporte entre outros</li>
                                        <li class="text-white"><i class="bx bxs-check-circle"></i>Rescisões</li>
                                        <li class="text-white"><i class="bx bxs-check-circle"></i>Convênios e avaliações
                                        </li>
                                        <li class="text-white"><i class="bx bxs-check-circle"></i>Cálculo de férias
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="choose-img">
                        <img src="{{ asset('img/choose-img.jpg') }}" alt="Images">
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="security-area pt-100 pb-70">
        <div class="container">
            <div class="section-title text-center">
                <span class="sp-color2">Vantagens</span>
                <h2>Procurando uma vantagem? As nossas são verdadeiramente proeminentes!</h2>
            </div>
            <div class="row pt-45 d-flex justify-content-center">
                <div class="col-lg-3 col-sm-6">
                    <div class="security-card">
                        <i class="bx bx-down-arrow-alt"></i>
                        <h3>Redução de custos</h3>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="security-card">
                        <i class="bx bx-block"></i>
                        <h3>Não incide no auxilio encargos trabalhistas</h3>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="security-card">
                        <i class="bx bx-money-withdraw"></i>
                        <h3>Bolsa auxilio pode ser inferior a 1 salario mínimo</h3>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="security-card">
                        <i class="bx bx-money"></i>
                        <h3>Não há 1/3 das férias</h3>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="security-card">
                        <i class="bx bx-barcode"></i>
                        <h3>Não há recolhimento de FGTS e INSS</h3>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="security-card">
                        <i class="bx bx-stopwatch"></i>
                        <h3>Contratação menos burocrática</h3>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="security-card">
                        <i class="bx bx-coin-stack"></i>
                        <h3>Baixo Custo de formação ou treinamento</h3>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="security-card">
                        <i class="bx bx-dollar"></i>
                        <h3>Redução de 40% na folha de pagto</h3>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="security-card">
                        <i class="bx bx-library"></i>
                        <h3>Assessoria Jurídica na Lei de estágio 11.788</h3>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="security-card">
                        <i class="bx bxs-school"></i>
                        <h3>Convênios com Universidades</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="choose-area pt-100 pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="about-content choose-content mr-20">
                        <div class="section-title">
                            <h2>Como funciona?</h2>
                            <p>Após o alinhamento do Perfil escolhido pela empresa a vaga é aberta pela empresa.</p>
                            <p>A estágioPremium seleciona o candidato (podendo aplicar testes e/ou entrevistas) para alinhar
                                o perfil exato que a empresa PRECISA.</p>
                            <p>Após a Confirmação pela empresa a estágioPremium através do franqueado faz:</p>
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <ul class="about-list text-start">
                                        <li class="text-white"><i class="bx bxs-check-circle"></i>A contratação</li>
                                    </ul>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <ul class="about-list text-start">
                                        <li class="text-white"><i class="bx bxs-check-circle"></i>A gestão do contrato
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <ul class="about-list text-start">
                                        <li class="text-white"><i class="bx bxs-check-circle"></i>Acompanhamento de
                                            todo programa de estágio para garantir as exigências legais</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="choose-img">
                        <img src="{{ asset('img/steps.png') }}" alt="Images">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="contact-form-area pt-100 pb-70">
        <div class="container">
            <div class="section-title text-center">
                <h2>Empresa, entre em contato conosco!</h2>
            </div>
            <div class="row pt-45">
                <div class="col-12">
                    <div class="contact-form">
                        <form id="contactForm" action="{{ route('sendEmail') }}" method="POST" novalidate="true">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Empresa <span>*</span></label>
                                        <input type="text" name="name" id="name" class="form-control"
                                            required="" data-error="Por favor, informe o nome da Empresa"
                                            placeholder="Nome da Empresa">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>E-mail corporativo<span>*</span></label>
                                        <input type="email" name="email" id="email" class="form-control"
                                            required=""
                                            data-error="Por favor, informe um e-mail corporativo para contato"
                                            placeholder="E-mail">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Telefone <span>*</span></label>
                                        <input type="text" name="phone_number" id="phone_number" required=""
                                            data-error="Por favor, informe seu telefone" class="form-control"
                                            placeholder="Telefone">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Assunto <span>*</span></label>
                                        <input type="text" name="msg_subject" id="msg_subject" class="form-control"
                                            required="" data-error="Por favor, informe um assunto"
                                            placeholder="Assunto">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label>Mensagem <span>*</span></label>
                                        <textarea name="message" class="form-control" id="message" cols="30" rows="8" required=""
                                            data-error="Escreva sua mensagem"
                                            placeholder="Sua mensagem, se possível, com cidade, estado, informações de quantitativo de estagiários necessários, número de colaboradores etc"></textarea>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 text-center">
                                    <button type="submit" class="default-btn btn-bg-two border-radius-5 disabled"
                                        style="pointer-events: all; cursor: pointer;">Enviar <i
                                            class="bx bx-chevron-right"></i>
                                    </button>
                                    <div id="msgSubmit" class="h3 text-center hidden"></div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
