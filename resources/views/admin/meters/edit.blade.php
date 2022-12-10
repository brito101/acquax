@extends('adminlte::page')
@section('plugins.select2', true)

@section('title', '- Edição de Medidor')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-tachometer-alt"></i> Editar Medidor</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.meters.index') }}">Medidores</a></li>
                        <li class="breadcrumb-item active">Editar Medidor</li>
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
                            <h3 class="card-title">Dados Cadastrais do Medidor</h3>
                            <small class="float-right text-black-50">Criado por {{ $meter->user->name }} em
                                {{ date('d/m/Y H:i', strtotime($meter->created_at)) }}</small>
                        </div>


                        <form method="POST" action="{{ route('admin.meters.update', ['meter' => $meter->id]) }}">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="id" value="{{ $meter->id }}">
                            <input type="hidden" name="from" value="{{ url()->previous() }}">
                            <div class="card-body">

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="register">Identificador</label>
                                        <input type="text" class="form-control" id="register"
                                            placeholder="Identificador" name="register"
                                            value="{{ old('register') ?? $meter->register }}" required>
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="apartment_id">Apartamento</label>
                                        <x-adminlte-select2 name="apartment_id">
                                            @foreach ($apartments as $apartment)
                                                <option
                                                    {{ old('apartment_id') == $apartment->id ? 'selected' : ($meter->apartment_id == $apartment->id ? 'selected' : '') }}
                                                    value="{{ $apartment->id }}">
                                                    {{ 'Condomínio ' . $apartment->getComplexNameAttribute() . ' - Bloco ' . $apartment->getBlockNameAttribute() . ' - Apartamento ' . $apartment->name }}
                                                </option>
                                            @endforeach
                                        </x-adminlte-select2>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="location">Localização</label>
                                        <input type="text" class="form-control" id="location"
                                            placeholder="Local ou cômodo do medidor" name="location"
                                            value="{{ old('location') ?? $meter->location }}">
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="initial_reading">Valor Inicial em m<sup>3</sup></label>
                                        <input type="text" class="form-control" id="initial_reading"
                                            placeholder="Valor Inicial em decimal" name="initial_reading"
                                            value="{{ old('initial_reading') ?? $meter->initial_reading }}" required>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-start">
                                    <div class="col-12 col-md-3 form-group px-0 pr-md-2">
                                        <label for="type_meter_id">Tipo do Medidor</label>
                                        <x-adminlte-select2 name="type_meter_id">
                                            @foreach ($typeMeters as $type)
                                                <option
                                                    {{ old('type_meter_id') == $type->id ? 'selected' : ($meter->type_meter_id == $type->id ? 'selected' : '') }}
                                                    value="{{ $type->id }}">{{ $type->name }}</option>
                                            @endforeach
                                        </x-adminlte-select2>
                                    </div>
                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="year_manufacture">Ano de Fabricação</label>
                                        <input type="text" class="form-control" id="year_manufacture"
                                            placeholder="Ano de Fabricação do Medidor" name="year_manufacture"
                                            value="{{ old('year_manufacture') ?? $meter->year_manufacture }}">
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="rotation">Setindo de Rotação</label>
                                        <x-adminlte-select2 name="rotation">
                                            <option
                                                {{ old('rotation') == 'Crescente' ? 'selected' : ($meter->rotation == 'Crescente' ? 'selected' : '') }}
                                                value="Crescente">
                                                Crescente</option>
                                            <option
                                                {{ old('rotation') == 'Decrescente' ? 'selected' : ($meter->rotation == 'Decrescente' ? 'selected' : '') }}
                                                value="Decrescente">
                                                Decrescente</option>
                                        </x-adminlte-select2>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                        <label for="status">Status do Medidor</label>
                                        <x-adminlte-select2 name="status">
                                            <option
                                                {{ old('status') == 'Ativo' ? 'selected' : ($meter->status == 'Ativo' ? 'selected' : '') }}
                                                value="Ativo">
                                                Ativo</option>
                                            <option
                                                {{ old('status') == 'Inativo' ? 'selected' : ($meter->status == 'Inativo' ? 'selected' : '') }}
                                                value="Inativo">
                                                Inativo</option>
                                        </x-adminlte-select2>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-start">
                                    <div class="col-12 col-md-3 form-group px-0 pr-md-2">
                                        <label for="main">Medidor principal</label>
                                        <x-adminlte-select2 name="main">
                                            <option
                                                {{ old('main') == true ? 'selected' : ($meter->main == true ? 'selected' : '') }}
                                                value="true">
                                                Sim</option>
                                            <option
                                                {{ old('status') == false ? 'selected' : ($meter->main == false ? 'selected' : '') }}
                                                value="false">
                                                Não</option>
                                        </x-adminlte-select2>
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
    <script src="{{ asset('js/meter.js') }}"></script>
@endsection
