@extends('adminlte::page')
@section('plugins.BsCustomFileInput', true)
@section('plugins.select2', true)

@section('title', '- Edição de Condomínio')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-map-marked"></i> Editar Condomínio</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.complexes.index') }}">Condomínio</a></li>
                        <li class="breadcrumb-item active">Editar Condomínio</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    @include('components.alert')

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Dados Cadastrais do Condomínio</h3>
                            <small class="float-right text-black-50">Criado por {{ $complex->user->name }} em
                                {{ date('d/m/Y H:i', strtotime($complex->created_at)) }}</small>
                        </div>

                        <form method="POST" action="{{ route('admin.complexes.update', ['complex' => $complex->id]) }}"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="card-body">

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="social_name">Nome do Condomínio</label>
                                        <input type="text" class="form-control" id="social_name"
                                            placeholder="Nome do Condomínio" name="social_name"
                                            value="{{ old('social_name') ?? $complex->social_name }}" required>
                                    </div>
                                    <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                        <label for="alias_name">Nome Fantasia do Condomínio</label>
                                        <input type="text" class="form-control" id="alias_name"
                                            placeholder="Nome Fantasia do Condomínio" name="alias_name"
                                            value="{{ old('alias_name') ?? $complex->alias_name }}" required>
                                    </div>
                                    <div class="col-12 col-md-4 form-group px-0 pl-md-2 mb-0">
                                        <label for="status">Status do Condomínio</label>
                                        <x-adminlte-select2 name="status">
                                            <option
                                                {{ old('status') == 'Ativo' ? 'selected' : ($complex->status == 'Ativo' ? 'selected' : '') }}>
                                                Ativo</option>
                                            <option
                                                {{ old('status') == 'Inativo' ? 'selected' : ($complex->status == 'Inativo' ? 'selected' : '') }}>
                                                Inativo</option>
                                        </x-adminlte-select2>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="document_company">CNPJ</label>
                                        <input type="text" class="form-control" id="document_company" placeholder="CNPJ"
                                            name="document_company"
                                            value="{{ old('document_company') ?? $complex->document_company }}" required>
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="document_company_secondary">Inscrição Estadual</label>
                                        <input type="text" class="form-control" id="document_company_secondary"
                                            placeholder="Inscrição Estadual" name="document_company_secondary"
                                            value="{{ old('document_company_secondary') ?? $complex->document_company_secondary }}">
                                    </div>
                                </div>

                                <h5 class="text-muted">Contato</h5>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="telephone">Telefone</label>
                                        <input type="tel" class="form-control" id="telephone" placeholder="Telefone"
                                            name="telephone" value="{{ old('telephone') ?? $complex->telephone }}"
                                            required>
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="cell">Celular</label>
                                        <input type="tel" class="form-control" id="cell" placeholder="Celular"
                                            name="cell" value="{{ old('cell') ?? $complex->cell }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="email">E-mail</label>
                                        <input type="email" class="form-control" id="email" placeholder="E-mail"
                                            name="email" value="{{ old('email') ?? $complex->email }}" required>
                                    </div>
                                </div>

                                <h5 class="text-muted">Endereço</h5>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="zipcode">CEP</label>
                                        <input type="tel" class="form-control" id="zipcode" placeholder="CEP"
                                            name="zipcode" value="{{ old('zipcode') ?? $complex->zipcode }}" required>
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="street">Rua</label>
                                        <input type="text" class="form-control" id="street" placeholder="Rua"
                                            name="street" value="{{ old('street') ?? $complex->street }}" required>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="number">Número</label>
                                        <input type="text" class="form-control" id="number" placeholder="Número"
                                            name="number" value="{{ old('number') ?? $complex->number }}" required>
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="complement">Complemento</label>
                                        <input type="text" class="form-control" id="complement"
                                            placeholder="Complemento" name="complement"
                                            value="{{ old('complement') ?? $complex->complement }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="neighborhood">Bairro</label>
                                        <input type="text" class="form-control" id="neighborhood"
                                            placeholder="Bairro" name="neighborhood"
                                            value="{{ old('neighborhood') ?? $complex->neighborhood }}" required>
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="state">Estado</label>
                                        <input type="text" class="form-control" id="state" placeholder="UF"
                                            name="state" value="{{ old('state') ?? $complex->state }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="city">Cidade</label>
                                        <input type="text" class="form-control" id="city" placeholder="Cidade"
                                            name="city" value="{{ old('city') ?? $complex->city }}" required>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2 d-flex flex-wrap">

                                        <div class="{{ $complex->photo != null ? 'col-md-9' : 'col-md-12' }} px-0">
                                            <x-adminlte-input-file name="photo" label="Foto do Condomínio"
                                                placeholder="Selecione uma imagem..." legend="Selecionar" />
                                        </div>

                                        @if ($complex->photo != null)
                                            <div
                                                class='col-12 col-md-3 align-self-center mt-3 d-flex justify-content-center justify-content-md-end px-0'>
                                                <img src="{{ url('storage/complexes/' . $complex->photo) }}"
                                                    alt="{{ $complex->alias_name }}" style="max-width: 80%;"
                                                    class="img-thumbnail d-block">
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <h5 class="text-muted">Redes Sociais (opcional)</h5>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="facebook">Facebook</label>
                                        <input type="url" class="form-control" id="facebook"
                                            placeholder="https://www.facebook.com/..." name="facebook"
                                            value="{{ old('facebook') ?? $complex->facebook }}">
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="instagram">Instagram</label>
                                        <input type="url" class="form-control" id="instagram"
                                            placeholder="https://www.instagram.com/..." name="instagram"
                                            value="{{ old('instagram') ?? $complex->instagram }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="twitter">Twitter</label>
                                        <input type="url" class="form-control" id="twitter"
                                            placeholder="https://www.twitter.com/..." name="twitter"
                                            value="{{ old('twitter') ?? $complex->twitter }}">
                                    </div>
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Enviar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('custom_js')
    <script src="{{ asset('vendor/jquery/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ asset('js/phone.js') }}"></script>
    <script src="{{ asset('js/company.js') }}"></script>
    <script src="{{ asset('js/address.js') }}"></script>
@endsection
