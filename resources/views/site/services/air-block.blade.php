@extends('site.master.master')

@section('content')
    <div class="inner-banner">
        <div class="container">
            <div class="inner-title text-center">
                <h3>Bloqueador de Ar</h3>
            </div>
        </div>
    </div>


    <div class="about-area ptb-100">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="about-play">
                        <img src="{{ asset('img/air-block-0.webp') }}" alt="About Images" style="width: 100%;">
                        <div class="about-play-content">
                            <span class="pt-5">Assista nosso vídeo</span>
                            <h2>A solução para a sua conta!</h2>
                            <div class="play-on-area">
                                <a href="https://www.youtube.com/watch?v=BG0Tvg_Xdpk" class="play-on popup-btn"><i
                                        class="bx bx-play"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-content ml-25">
                        <div class="section-title">
                            <h2><span class="sp-color8">Bloqueador de Ar</span></h2>
                        </div>
                        <div class="row">
                            <div>
                                <ul class="about-list text-start">
                                    <li><i class="bx bxs-check-circle"></i>O <strong>bloqueador de ar</strong> controla a
                                        vazão do ar, fazendo com que o hidrômetro não registre este ar como se fosse água.
                                    </li>
                                    <li><i class="bx bxs-check-circle"></i>O
                                        ar que está chegando ao hidrômetro tem sua vazão controlada, resultando em um valor
                                        inferior ao Q.min do hidrômetro (início de funcionamento dos ponteiros).</li>
                                    <li><i class="bx bxs-check-circle"></i>Mora em condomínio e
                                        quer
                                        economizar? Veja a <a
                                            href="{{ route('site.service.waterIndividualization') }}">Individualização de
                                            Água</a>.
                                    </li>
                                    <li><i class="bx bxs-check-circle"></i>Nosso bloqueador de ar possibilita uma economia
                                        de até 50% na conta de água.
                                    </li>
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

                                <input type="hidden" name="msg_subject" id="msg_subject" value="Bloqueador de ar">

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
