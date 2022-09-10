@extends('site.master.master')

@section('content')
    <div class="inner-banner">
        <div class="container">
            <div class="inner-title text-center">
                <h3>Manutenção de Bomba</h3>
            </div>
        </div>
    </div>


    <div class="about-area ptb-100">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="about-play">
                        <img src="{{ asset('img/pump-maintenance-0.webp') }}" alt="Manutenção de Bombas">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-content ml-25">
                        <div class="row">
                            <div>
                                <p>Manutenção de bomba previne a queima do motor, além disso, diminui o gasto excessivo de
                                    energia causado pelo mal funcionamento dos equipamentos, <b>Reduzindo assim os
                                        custos do
                                        condomínio</b>. <a href="{{ route('site.service.waterIndividualization') }}"
                                        title="Individualização de
                                        Hidrômetro">Conheça
                                        Nossa Individualização de
                                        Hidrômetro</a>
                                </p>
                                <ul class="about-list text-start">
                                    <li><i class="bx bxs-check-circle"></i>Plantão de 24 horas, com equipamentos próprios.
                                    </li>
                                    <li><i class="bx bxs-check-circle"></i>Inspeção mensal.
                                    </li>
                                    <li><i class="bx bxs-check-circle"></i>Relatório pós vistoria das condições dos
                                        equipamentos.</li>
                                    <li><i class="bx bxs-check-circle"></i>Bombas reservas para substituição.</li>
                                    <li><i class="bx bxs-check-circle"></i>Maior prevenção contra queima de motores.</li>
                                    <li><i class="bx bxs-check-circle"></i>Profissionais treinados e especializados.</li>
                                    <li><i class="bx bxs-check-circle"></i>Evite gasto excessivo de energia pelo mau
                                        funcionamento dos equipamentos.</li>
                                    <li><i class="bx bxs-check-circle"></i>Realizamos dois tipos de manutenção de bomba:
                                        preventiva e corretiva.</li>

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

                                <input type="hidden" name="msg_subject" id="msg_subject" value="Manutenção de bomba">

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
