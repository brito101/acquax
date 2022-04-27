@extends('adminlte::page')
@section('plugins.select2', true)

@section('title', '- Edição de Consumo de Condomínio')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-chart-bar"></i> Editar Consumo</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.dealerships-readings.index') }}">Consumo dos
                                Condomínios</a>
                        </li>
                        <li class="breadcrumb-item active">Editar Consumo</li>
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
                            <h3 class="card-title">Dados Cadastrais do Consumo</h3>
                        </div>


                        <form method="POST"
                            action="{{ route('admin.dealerships-readings.update', ['dealerships_reading' => $reading->id]) }}">
                            @method('PUT')
                            @csrf
                            <input type="hidden" value="{{ $reading->id }}">
                            <div class="card-body">

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="complex_id">Condomínio</label>
                                        <x-adminlte-select2 name="complex_id">
                                            @foreach ($complexes as $complex)
                                                <option
                                                    {{ old('complex_id') == $complex->id ? 'selected' : ($reading->complex_id == $complex->id ? 'selected' : '') }}
                                                    value="{{ $complex->id }}">{{ $complex->alias_name }}
                                                </option>
                                            @endforeach
                                        </x-adminlte-select2>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="month_ref">Mês de Referência</label>
                                        <x-adminlte-select2 name="month_ref">
                                            <option
                                                {{ old('month_ref') == 'Janeiro' ? 'selected' : ($reading->month_ref == 'Janeiro' ? 'selected' : '') }}>
                                                Janeiro
                                            </option>
                                            <option
                                                {{ old('month_ref') == 'Fevereiro' ? 'selected' : ($reading->month_ref == 'Fevereiro' ? 'selected' : '') }}>
                                                Fevereiro
                                            </option>
                                            <option
                                                {{ old('month_ref') == 'Março' ? 'selected' : ($reading->month_ref == 'Março' ? 'selected' : '') }}>
                                                Março
                                            </option>
                                            <option
                                                {{ old('month_ref') == 'Abril' ? 'selected' : ($reading->month_ref == 'Abril' ? 'selected' : '') }}>
                                                Abril
                                            </option>
                                            <option
                                                {{ old('month_ref') == 'Maio' ? 'selected' : ($reading->month_ref == 'Maio' ? 'selected' : '') }}>
                                                Maio
                                            </option>
                                            <option
                                                {{ old('month_ref') == 'Junho' ? 'selected' : ($reading->month_ref == 'Junho' ? 'selected' : '') }}>
                                                Junho
                                            </option>
                                            <option
                                                {{ old('month_ref') == 'Julho' ? 'selected' : ($reading->month_ref == 'Julho' ? 'selected' : '') }}>
                                                Julho
                                            </option>
                                            <option
                                                {{ old('month_ref') == 'Agosto' ? 'selected' : ($reading->month_ref == 'Agosto' ? 'selected' : '') }}>
                                                Agosto
                                            </option>
                                            <option
                                                {{ old('month_ref') == 'Setembro' ? 'selected' : ($reading->month_ref == 'Setembro' ? 'selected' : '') }}>
                                                Setembro
                                            </option>
                                            <option
                                                {{ old('month_ref') == 'Outubro' ? 'selected' : ($reading->month_ref == 'Outubro' ? 'selected' : '') }}>
                                                Outubro
                                            </option>
                                            <option
                                                {{ old('month_ref') == 'Novembro' ? 'selected' : ($reading->month_ref == 'Novembro' ? 'selected' : '') }}>
                                                Novembro
                                            </option>
                                            <option
                                                {{ old('month_ref') == 'Dezembro' ? 'selected' : ($reading->month_ref == 'Dezembro' ? 'selected' : '') }}>
                                                Dezembro
                                            </option>
                                        </x-adminlte-select2>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                        <label for="complex_id">Concessionária</label>
                                        <x-adminlte-select2 name="dealership_id">
                                            @foreach ($dealerships as $dealership)
                                                <option
                                                    {{ old('dealership_id') == $dealership->id? 'selected': ($reading->dealership_id == $dealership->id? 'selected': '') }}
                                                    value="{{ $dealership->id }}">{{ $dealership->name }}
                                                </option>
                                            @endforeach
                                        </x-adminlte-select2>
                                    </div>

                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-3 form-group px-0 pr-md-2">
                                        <label for="reading_date">Data da Leitura</label>
                                        <input type="text" class="form-control acquax-date" id="reading_date"
                                            placeholder="Data da Leitura" name="reading_date"
                                            value="{{ old('reading_date') ?? $reading->reading_date }}" required>
                                    </div>
                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="reading_date_next">Data da Próxima Leitura</label>
                                        <input type="text" class="form-control acquax-date" id="reading_date_next"
                                            placeholder="Data da Próxima" name="reading_date_next"
                                            value="{{ old('reading_date_next') ?? $reading->reading_date_next }}"
                                            required>
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="total_days">Total de Dias</label>
                                        <input type="text" class="form-control" id="total_days"
                                            placeholder="Total de dias computados" name="total_days"
                                            value="{{ old('total_days') ?? $reading->total_days }}" required>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="dealership_consumption_tax_1">Valor máximo da 1ª Faixa de Consumo em
                                            m<sup>3</sup></label>
                                        <input type="text" class="form-control" id="dealership_consumption_tax_1"
                                            placeholder="Valor máximo da 1ª Faixa de Consumo pela concessionária"
                                            name="dealership_consumption_tax_1"
                                            value="{{ old('dealership_consumption_tax_1') ?? $reading->dealership_consumption_tax_1 }}"
                                            required>
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="dealership_cost_tax_1">Custo da 1ª Faixa de Consumo em
                                            m<sup>3</sup></label>
                                        <input type="text" class="form-control money_format_3" id="dealership_cost_tax_1"
                                            placeholder="Valor em reais da 1ª Faixa de Consumo pela concessionária"
                                            name="dealership_cost_tax_1"
                                            value="{{ old('dealership_cost_tax_1') ?? $reading->dealership_cost_tax_1 }}"
                                            required>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="dealership_consumption_tax_2">Valor mínimo da 2ª Faixa de Consumo em
                                            m<sup>3</sup></label>
                                        <input type="text" class="form-control" id="dealership_consumption_tax_2"
                                            placeholder="Valor mínimo da 2ª Faixa de Consumo pela concessionária"
                                            name="dealership_consumption_tax_2"
                                            value="{{ old('dealership_consumption_tax_2') ?? $reading->dealership_consumption_tax_2 }}"
                                            required>
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="dealership_cost_tax_2">Custo da 2ª Faixa de Consumo em
                                            m<sup>3</sup></label>
                                        <input type="text" class="form-control money_format_3" id="dealership_cost_tax_2"
                                            placeholder="Valor em reais da 2ª Faixa de Consumo pela concessionária"
                                            name="dealership_cost_tax_2"
                                            value="{{ old('dealership_cost_tax_2') ?? $reading->dealership_cost_tax_2 }}"
                                            required>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="dealership_consumption">Consumo da Concessionária em
                                            m<sup>3</sup></label>
                                        <input type="text" class="form-control" id="dealership_consumption"
                                            placeholder="Consumo medido pela concessionária" name="dealership_consumption"
                                            value="{{ old('dealership_consumption') ?? $reading->dealership_consumption }}"
                                            required>
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="monthly_consumption">Consumo Real medido em m<sup>3</sup></label>
                                        <input type="text" class="form-control" id="monthly_consumption"
                                            placeholder="Valor da Leitura em decimal" name="monthly_consumption"
                                            value="{{ old('monthly_consumption') ?? $reading->monthly_consumption }}"
                                            required>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="water_value_consumption">Valor do Consumo de Água</label>
                                        <input type="text" class="form-control money_format_2" id="water_value_consumption"
                                            placeholder="Valor do Consumo de Água em reais" name="water_value_consumption"
                                            value="{{ old('water_value_consumption') ?? $reading->water_value_consumption }}"
                                            required>
                                    </div>
                                    <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                        <label for="sewage_value_consumption">Consumo do Serviço de Esgoto</label>
                                        <input type="text" class="form-control money_format_2" id="sewage_value_consumption"
                                            placeholder="Valor do Serviço de Esgoto em reais"
                                            name="sewage_value_consumption"
                                            value="{{ old('sewage_value_consumption') ?? $reading->sewage_value_consumption }}"
                                            required>
                                    </div>
                                    <div class="col-12 col-md-4 form-group px-0 pl-md-2">
                                        <label for="regulation_tax">Taxa de Regulamentação</label>
                                        <input type="text" class="form-control money_format_2" id="regulation_tax"
                                            placeholder="Valor da taxa de Regulamentação" name="regulation_tax"
                                            value="{{ old('regulation_tax') ?? $reading->regulation_tax }}">
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
    <script src="{{ asset('js/dealerships-reading.js') }}"></script>
@endsection
