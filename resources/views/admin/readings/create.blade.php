@extends('adminlte::page')
@section('plugins.select2', true)
@section('plugins.BsCustomFileInput', true)

@section('title', '- Cadastro de Leitura Medidor')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-chart-line"></i> Nova Leitura</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.readings.index') }}">Leituras de Medidores</a>
                        </li>
                        <li class="breadcrumb-item active">Nova Leitura</li>
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
                            <h3 class="card-title">Dados Cadastrais da Leitura</h3>
                        </div>


                        <form method="POST" action="{{ route('admin.readings.store') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="from" value="{{ url()->previous() }}">
                            <div class="card-body">

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="meter_id">Medidor</label>
                                        <x-adminlte-select2 name="meter_id">
                                            @foreach ($meters as $meter)
                                                <option {{ old('meter_id') == $meter->id ? 'selected' : '' }}
                                                    value="{{ $meter->id }}">{{ $meter->register }}
                                                    ({{ $meter->typeMeter->name }})
                                                </option>
                                            @endforeach
                                        </x-adminlte-select2>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="month_ref">Mês de Referência</label>
                                        <x-adminlte-select2 name="month_ref">
                                            <option {{ old('month_ref') == 'Janeiro' ? 'selected' : '' }}>
                                                Janeiro
                                            </option>
                                            <option {{ old('month_ref') == 'Fevereiro' ? 'selected' : '' }}>
                                                Fevereiro
                                            </option>
                                            <option {{ old('month_ref') == 'Março' ? 'selected' : '' }}>
                                                Março
                                            </option>
                                            <option {{ old('month_ref') == 'Abril' ? 'selected' : '' }}>
                                                Abril
                                            </option>
                                            <option {{ old('month_ref') == 'Maio' ? 'selected' : '' }}>
                                                Maio
                                            </option>
                                            <option {{ old('month_ref') == 'Junho' ? 'selected' : '' }}>
                                                Junho
                                            </option>
                                            <option {{ old('month_ref') == 'Julho' ? 'selected' : '' }}>
                                                Julho
                                            </option>
                                            <option {{ old('month_ref') == 'Agosto' ? 'selected' : '' }}>
                                                Agosto
                                            </option>
                                            <option {{ old('month_ref') == 'Setembro' ? 'selected' : '' }}>
                                                Setembro
                                            </option>
                                            <option {{ old('month_ref') == 'Outubro' ? 'selected' : '' }}>
                                                Outubro
                                            </option>
                                            <option {{ old('month_ref') == 'Novembro' ? 'selected' : '' }}>
                                                Novembro
                                            </option>
                                            <option {{ old('month_ref') == 'Dezembro' ? 'selected' : '' }}>
                                                Dezembro
                                            </option>
                                        </x-adminlte-select2>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                        <label for="year_ref">Ano de Referência</label>
                                        <input type="text" class="form-control" id="year_ref" placeholder="YYYY"
                                            name="year_ref" value="{{ old('year_ref') }}" required>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="reading_date">Data da Leitura</label>
                                        <input type="text" class="form-control acquax-date" id="reading_date"
                                            placeholder="Data da Leitura" name="reading_date"
                                            value="{{ old('reading_date') }}" required>
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="reading_date_next">Data da Próxima Leitura</label>
                                        <input type="text" class="form-control acquax-date" id="reading_date_next"
                                            placeholder="Data da Próxima" name="reading_date_next"
                                            value="{{ old('reading_date_next') }}" required>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="reading">Valor da Leitura em m<sup>3</sup></label>
                                        <input type="text" class="form-control" id="reading"
                                            placeholder="Valor da Leitura em decimal" name="reading"
                                            value="{{ old('reading') }}" required>
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <x-adminlte-input-file name="cover" label="Arquivo de Imagem"
                                            placeholder="Selecione uma imagem..." legend="Selecionar" />
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="url_cover">URL da imagem</label>
                                        <input type="text" class="form-control" id="url_cover"
                                            placeholder="Endereço da Imagem caso exista" name="url_cover"
                                            value="{{ old('url_cover') }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <label for="cover_base64">Captura de Imagem</label>
                                    <input type="hidden" id="cover_base64" name="cover_base64" />
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div
                                        class="embed-responsive embed-responsive-16by9 col-12 col-md-6 form-group px-0 pr-md-2">
                                        <video id="player" autoplay class="embed-responsive-item"></video>
                                    </div>

                                    <div
                                        class="embed-responsive embed-responsive-16by9 col-12 col-md-6 form-group px-0 pl-md-2">
                                        <canvas id="canvas" class="embed-responsive-item"
                                            style="max-width: 75%; left: 12.5%;"></canvas>
                                    </div>
                                    <button id="capture" class="btn btn-secondary"><i class="fa fa-camera mr-1"></i>
                                        Capturar</button>
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
    <script src="{{ asset('js/reading.js') }}"></script>
@endsection
