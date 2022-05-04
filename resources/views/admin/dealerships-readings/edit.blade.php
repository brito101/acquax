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
                                                    {{ old('dealership_id') == $dealership->id ? 'selected' : ($reading->dealership_id == $dealership->id ? 'selected' : '') }}
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
                                        <label for="dealership_cost">Custo da Concessionária em Reais</label>
                                        <input type="text" class="form-control money_format_2" id="dealership_cost"
                                            placeholder="Custo total do medido pela concessionária" name="dealership_cost"
                                            value="{{ old('dealership_cost') ?? $reading->dealership_cost }}" required>
                                    </div>
                                </div>
                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="monthly_consumption">Consumo Real em m<sup>3</sup></label>
                                        <input type="text" class="form-control" id="monthly_consumption"
                                            name="monthly_consumption" disabled
                                            value="{{ $reading->monthly_consumption }}">
                                    </div>
                                    <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                        <label for="diff_consumption">Diferença entre Real e Concessionária em
                                            m<sup>3</sup></label>
                                        <input type="text" class="form-control" id="diff_consumption"
                                            name="diff_consumption" disabled value="{{ $reading->diff_consumption }}">
                                    </div>
                                    <div class="col-12 col-md-4 form-group px-0 pl-md-2">
                                        <label for="previous_monthly_consumption">Consumo Real Anterior em
                                            m<sup>3</sup></label>
                                        <input type="text" class="form-control" id="previous_monthly_consumption"
                                            name="previous_monthly_consumption" disabled
                                            value="{{ $reading->previous_monthly_consumption }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-start">
                                    <div class="col-12 col-md-3 form-group px-0 pr-md-2">
                                        <label for="consumption_tax_1">Consumo 1ª Faixa</label>
                                        <input type="text" class="form-control" id="consumption_tax_1"
                                            name="consumption_tax_1" disabled value="{{ $reading->consumption_tax_1 }}">
                                    </div>
                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="total_cost_tax_1">Custo total 1ª Faixa</label>
                                        <input type="text" class="form-control" id="total_cost_tax_1"
                                            name="total_cost_tax_1" disabled value="{{ $reading->total_cost_tax_1 }}">
                                    </div>
                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="consumption_tax_2">Consumo 2ª Faixa</label>
                                        <input type="text" class="form-control" id="consumption_tax_2"
                                            name="consumption_tax_2" disabled value="{{ $reading->consumption_tax_2 }}">
                                    </div>
                                    <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                        <label for="total_cost_tax_2">Custo total 2ª Faixa</label>
                                        <input type="text" class="form-control" id="total_cost_tax_2"
                                            name="total_cost_tax_2" disabled value="{{ $reading->total_cost_tax_2 }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="real_cost">Custo do Total Medido em Reais</label>
                                        <input type="text" class="form-control" id="real_cost" name="real_cost" disabled
                                            value="{{ $reading->real_cost }}">
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="diff_cost">Diferença entre o Medido e
                                            Concessionária</label>
                                        <input type="text" class="form-control" id="diff_cost" name="diff_cost" disabled
                                            value="{{ $reading->diff_cost }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="fraction">Valor para
                                            {{ $reading->fraction['units'] - $reading->fraction['more_expansive'] . ' Unidades' }}</label>
                                        <input type="text" class="form-control" id="fraction" name="fraction" disabled
                                            value="{{ $reading->fraction['geral_fraction'] }}">
                                    </div>

                                    @if ($reading->complex['apportionment'] == 'Fração Ideal')
                                        <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                            <label for="fraction">Valor para
                                                {{ $reading->fraction['more_expansive'] . ' Unidades' }}</label>
                                            <input type="text" class="form-control" id="fraction" name="fraction" disabled
                                                value="{{ $reading->fraction['rest_fraction'] }}">
                                        </div>
                                    @endif
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="units_inside_tax_1">Unidades dentro da 1ª Faixa</label>
                                        <input type="text" class="form-control" id="units_inside_tax_1"
                                            name="units_inside_tax_1" disabled
                                            value="{{ $reading->units_inside_tax_1 }}">
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="units_above_tax_1">Unidades acima da 1ª Faixa</label>
                                        <input type="text" class="form-control" id="units_above_tax_1"
                                            name="units_above_tax_1" disabled value="{{ $reading->units_above_tax_1 }}">
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
