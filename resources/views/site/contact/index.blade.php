@extends('site.master.master')

@section('content')
    <div class="inner-banner">
        <div class="container">
            <div class="inner-title text-center">
                <h3>Contato</h3>
            </div>
        </div>
    </div>

    <div class="contact-form-area pt-100 pb-70">
        <div class="container">
            <div class="section-title text-center">
                <h2>Entre em contato conosco!</h2>
            </div>
            <div class="row pt-45">
                <div class="col-12 col-lg-5">
                    <div class="contact-info mr-20">
                        <span>Informações de Contato</span>
                        <h2>{{ env('APP_NAME') }}</h2>
                        <ul>
                            <li>
                                <div class="content">
                                    <i class="bx bx-phone-call"></i>
                                    <h3>Central de Atendimento</h3>
                                    <a href="tel:{{ env('TEL_SUPPORT') }}" rel="noreferrer">{{ env('TEL_SUPPORT') }}</a>
                                </div>
                            </li>
                            <li>
                                <div class="content">
                                    <i class="bx bx-phone-call" style="left: -10px; top:20px;"></i>
                                    <i class="bx bxl-whatsapp" style="left: 10px; top:50px;"></i>
                                    <h3>Rio de Janeiro-RJ</h3>
                                    <a href="tel:2139005451" rel="noreferrer">(21) 3900-5451</a>
                                    <a href="https://wa.me/5521997500020" rel="noreferrer">(21) 99750-0020</a>
                                </div>
                            </li>
                            <li>
                                <div class="content">
                                    <i class="bx bx-phone-call" style="left: -10px; top:20px;"></i>
                                    <i class="bx bxl-whatsapp" style="left: 10px; top:50px;"></i>
                                    <h3>Vitória-ES</h3>
                                    <a href="tel:2735001904" rel="noreferrer">(27) 3500-1904</a>
                                    <a href="https://wa.me/552799913-5013" rel="noreferrer">(27) 99913-5013</a>
                                </div>
                            </li>
                            <li>
                                <div class="content">
                                    <i class="bx bx-phone-call" style="left: -10px; top:20px;"></i>
                                    <i class="bx bxl-whatsapp" style="left: 10px; top:50px;"></i>
                                    <h3>São Paulo-SP</h3>
                                    <a href="tel:1131640085" rel="noreferrer">(11) 3164-0085</a>
                                    <a href="https://wa.me/5511997535977" rel="noreferrer">(11)
                                        99753-5977</a>
                                </div>
                            </li>
                            <li>
                                <div class="content">
                                    <i class="bx bx-message"></i>
                                    <h3>E-mail</h3>
                                    <a href="mailto:{{ env('MAIL_SUPPORT') }}"
                                        rel="noreferrer">{{ env('MAIL_SUPPORT') }}</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-lg-7">
                    <div class="contact-form">
                        <form id="contactForm" action="{{ route('site.sendEmail') }}" method="POST">
                            <div class="row">
                                <div class="col-lg-6">
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
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Serviço <span>*</span></label>
                                        <select name="msg_subject" id="msg_subject" class="form-control py-0 pt-1" required
                                            data-error="Por favor, informe um serviço">
                                            <option disabled value="">Selecione um Serviço</option>
                                            <option>Bloqueador de ar</option>
                                            <option>Dispositivo anti sucção</option>
                                            <option>Individualização de hidrômetro</option>
                                            <option>Manutenção de Bomba</option>
                                            <option>Medição individual de água e gás</option>
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
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

    <div class="map-area">
        <div class="container-fluid m-0 p-0">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7630972.04234676!2d-37.8365769!3d-20.9500827!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb0b76eff605f82b8!2sGrupo%20Acqua%20X%20do%20Brasil!5e0!3m2!1spt-BR!2sbr!4v1662162821171!5m2!1spt-BR!2sbr"
                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade" title="Nossa localização"></iframe>
        </div>
    </div>
@endsection
