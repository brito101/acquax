@extends('adminlte::page')
@section('plugins.select2', true)
@section('plugins.BsCustomFileInput', true)

@section('title', '- Cadastro de Fotos de Leituras')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-camera"></i> Cadastro de Fotos de Leituras</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.readings.index') }}">Leituras de Medidores</a>
                        </li>
                        <li class="breadcrumb-item active">Fotos de Leituras</li>
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
                            <h3 class="card-title">Importação de Fotos</h3>
                        </div>

                        <form method="POST" action="{{ route('admin.readings.photo.import') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-3 form-group px-0 pr-md-2">
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

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="year_ref">Ano de Referência</label>
                                        <input type="text" class="form-control" id="year_ref" placeholder="YYYY"
                                            name="year_ref" value="{{ old('year_ref') ?? date('Y') }}" required>
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <x-adminlte-input-file id="photos" name="photos[]" label="Fotos de Leituras"
                                            placeholder="Selecione até 1000 arquivos com o máximo de 10GB" igroup-size="md"
                                            legend="Selecione" multiple>
                                            <x-slot name="prependSlot">
                                                <div class="input-group-text text-primary">
                                                    <i class="fas fa-file-upload"></i>
                                                </div>
                                            </x-slot>
                                        </x-adminlte-input-file>
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
    <script src="{{ asset('js/reading.js') }}"></script>
@endsection
