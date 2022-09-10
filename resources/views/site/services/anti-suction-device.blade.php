@extends('site.master.master')

@section('content')
    <div class="inner-banner">
        <div class="container">
            <div class="inner-title text-center">
                <h3>Dispositivo Anti Sucção</h3>
            </div>
        </div>
    </div>


    <div class="about-area ptb-100">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="about-play">
                        <img src="{{ asset('img/anti-suction-device-0.webp') }}" alt="Dispositivo Anti Sucção">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-content ml-25">
                        <div class="section-title">
                            <h2><span class="sp-color8">Dispositivo Anti Sucção</span></h2>
                        </div>
                        <p>É instalado na bomba da piscina e interrompe o
                            processo de sucção da
                            bomba em 2 segundos de forma automática, quando o sistema percebe que alguma coisa obstruiu o
                            ralo no fundo da piscina, assim salvando qualquer pessoa que por um acidente fique presa neste
                            ralo, não permitindo que a pessoa se machuque de forma séria e evita afogamento.</p>
                        <div class="row">
                            <div>
                                <ul class="about-list text-start">
                                    <li><i class="bx bxs-check-circle"></i>Profissionais treinados e especializados.
                                    </li>
                                    <li><i class="bx bxs-check-circle"></i>Maior prevenção contra queima de motores.</li>
                                    <li><i class="bx bxs-check-circle"></i>Evite interdição da piscina do seu condomínio e
                                        multas, instalando o equipamento de Anti Sucção.</li>
                                </ul>
                            </div>
                        </div>
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
                            <h3>Lei estadual 6772 de 09/05/2014:</h3>
                            <div class="row">
                                <div>
                                    <ul class="about-list text-start">
                                        <li class="text-white"><i class="bx bxs-check-circle"></i>Obriga os clubes sociais
                                            e esportivos, condomínios, hotéis, academias, sociedades recreativas,
                                            associações, colégios e outros assemelhados, onde haja piscinas de uso coletivo,
                                            obrigados a colocarem dispositivos que interrompam o processo de sucção dos
                                            equipamentos da piscina, manual e automático.
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="section-title pt-5">
                            <h3>Sem sistema o Dispositivo Anti Sucção:</h3>
                            <div class="row">
                                <div>
                                    <ul class="about-list text-start">
                                        <li class="text-white"><i class="bx bxs-check-circle"></i>A não colocação do
                                            sistema, aumenta em um muito o risco de afogamentos, evite um acidente que pode
                                            se torna uma tragédia enquanto você estiver em lazer.
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="choose-img">
                        <img src="{{ asset('img/anti-suction-device-1.webp') }}" alt="Dispositivo Anti Sucção">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="contact-form-area pt-100 pb-70">
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

                                <input type="hidden" name="msg_subject" id="msg_subject" value="Dispositivo anti sucção">

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
