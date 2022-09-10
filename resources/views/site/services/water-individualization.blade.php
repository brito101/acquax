@extends('site.master.master')

@section('content')
    <div class="inner-banner">
        <div class="container">
            <div class="inner-title text-center">
                <h3>Individualização de Hidrômetro</h3>
            </div>
        </div>
    </div>


    <div class="about-area ptb-100">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="about-play">
                        <img src="{{ asset('img/water-individualization-0.webp') }}" alt="Individualização de Hidrômetro">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-content ml-25">
                        <div class="row">
                            <div>
                                <p>Realizamos obra de Individualização de Hidrômetro
                                    em prédios novos, também em antigos, com tecnologia de ponta e profissionais
                                    treinados, mão de obra própria e especializados na execução dos serviços.
                                </p>
                                <p>Empresa especializada em <strong>DESCARGA TIPO
                                        HYDRA</strong>.</p>
                                <ul class="about-list text-start">
                                    <li><i class="bx bxs-check-circle"></i>Possibilita uma economia de água de até 50%
                                        dependendo da estrutura do condomínio.
                                    </li>
                                    <li><i class="bx bxs-check-circle"></i>Maior controle por parte do condomínio.
                                    </li>
                                    <li><i class="bx bxs-check-circle"></i>Redução do consumo de energia elétrica tendo em
                                        vista que as bombas serão menos utilizadas.</li>
                                    <li><i class="bx bxs-check-circle"></i>Redução da taxa condominial.</li>
                                    <li><i class="bx bxs-check-circle"></i>Valorização do imóvel em até 15%.</li>
                                    <li><i class="bx bxs-check-circle"></i>Empresa especialista em sistema de
                                        Individualização de Hidrômetro, <b>Retrofit</b> e <b>Previsto</b>.</li>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="contact-form-area pb-70">
        <div class="container">
            <div class="section-title text-center">
                <h2>Solicite um Orçamento</h2>
            </div>
            <div class="row pt-45">
                <div class="col-12">
                    <div class="contact-form">
                        <form id="contactForm" action="{{ route('site.sendEmail') }}" method="POST">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Seu nome <span>*</span></label>
                                        <input type="text" name="name" id="name" class="form-control"
                                            required="" data-error="Por favor, informe seu nome" placeholder="Nome">
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>E-mail <span>*</span></label>
                                        <input type="email" name="email" id="email" class="form-control"
                                            required="" data-error="Por favor, informe seu e-mail" placeholder="E-mail">
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

                                <input type="hidden" name="msg_subject" id="msg_subject"
                                    value="Individualização de hidrômetro">

                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <label>Mensagem <span>*</span></label>
                                        <textarea name="message" class="form-control" id="message" cols="30" rows="8" required=""
                                            data-error="Escreva sua mensagem" placeholder="Sua mensagem"></textarea>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 text-center">
                                    <button type="submit" class="default-btn btn-bg-one border-radius-5 disabled"
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
