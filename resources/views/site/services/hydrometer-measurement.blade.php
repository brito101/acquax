@extends('site.master.master')

@section('content')
    <div class="inner-banner">
        <div class="container">
            <div class="inner-title text-center">
                <h3>Medição de Hidrômetro</h3>
            </div>
        </div>
    </div>


    <div class="about-area ptb-100">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="about-play">
                        <img src="{{ asset('img/hydrometer-measurement-0.webp') }}" alt="Medição de Hidrômetro">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-content ml-25">
                        <p>Realizamos Medição de Hidrômetro, Leitura de Hidrômetro por Foto Medição Automática, Medição
                            Visual e Sistema de Telemetria com medição diária ou mensal. Conheça nosso <a
                                href="{{ route('site.service.pumpMaintenance') }}" title="Bloqueador de Ar">Bloqueador de
                                Ar</a> e
                            economize na conta de Água.</p>
                        <div class="row">
                            <div>
                                <ul class="about-list text-start">
                                    <li><i class="bx bxs-check-circle"></i>Emissão de filipetas individuais de consumo.
                                    </li>
                                    <li><i class="bx bxs-check-circle"></i>Participamos de reuniões, também vamos em
                                        assembleias para tirar dúvidas de condôminos sobre Medição de Hidrômetro.</li>
                                    <li><i class="bx bxs-check-circle"></i>Bloqueio do fornecimento de água em caso de
                                        inadimplência mediante aprovação em assembléia.</li>
                                    <li><i class="bx bxs-check-circle"></i>Assistência Jurídica e Contábil.</li>
                                    <li><i class="bx bxs-check-circle"></i>Vistoria de caça vazamentos em caso de consumo de
                                        água elevado.</li>
                                    <li><i class="bx bxs-check-circle"></i>Demonstrativo de medição com a foto do hidrômetro
                                        e o consumo do clientes (Medição Foto Visual).</li>
                                    <li><i class="bx bxs-check-circle"></i>Sistema de medição online.</li>
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
                    <div class="about-content choose-content mr-20 d-flex align-items-center h-100">
                        <div class="section-title">
                            <h3>Sistema de Telemetria (Medição Online)</h3>
                            <p>Pela medição de Telemetria o condômino pode ver seu consumo em nosso aplicativo sempre que
                                quiser. É fornecido um usuário e senha, buscando assim garantir total descrição, e apenas o
                                síndico pode ver o quanto consumiu cada unidade.</p>
                        </div>

                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="choose-img">
                        <img src="{{ asset('img/hydrometer-measurement-1.webp') }}" alt="Medição de Hidrômetro"
                            style="max-height: 500px">
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

                                <input type="hidden" name="msg_subject" id="msg_subject" value="Medição de Hodrômetro">

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
