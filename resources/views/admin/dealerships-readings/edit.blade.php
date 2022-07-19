@extends('adminlte::page')
@section('plugins.select2', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)

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
                            <h3 class="card-title">Dados Cadastrais de Consumo</h3>
                        </div>


                        <form method="POST"
                            action="{{ route('admin.dealerships-readings.update', ['dealerships_reading' => $reading->id]) }}">
                            @method('PUT')
                            @csrf
                            <input type="hidden" value="{{ $reading->id }}">
                            <div class="card-body">

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-3 form-group px-0 pr-md-2">
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

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="year_ref">Ano de Referência</label>
                                        <input type="text" class="form-control" id="year_ref" placeholder="YYYY"
                                            name="year_ref" value="{{ old('year_ref') ?? $reading->year_ref }}" required>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                        <label for="dealership_id">Concessionária</label>
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

                                <div class="d-flex flex-wrap justify-content-start">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="consumption_ranges">Qtd de faixas de Consumo</label>
                                        <input name="consumption_ranges" id="consumption_ranges" class="form-control"
                                            type="number" min="1" max="6"
                                            value="{{ old('consumption_ranges') ?? $reading->consumption_ranges }}"
                                            required>
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="dealership_cost_tax_1">Custo da 1ª Faixa de Consumo</label>
                                        <input type="text" class="form-control money_format_3" id="dealership_cost_tax_1"
                                            placeholder="Valor limite da 1ª Faixa de Consumo pela concessionária"
                                            name="dealership_cost_tax_1"
                                            value="{{ old('dealership_cost_tax_1') ?? $reading->dealership_cost_tax_1 }}"
                                            required>
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2" data-consumption_ranges="2">
                                        <label for="dealership_consumption_tax_1">Valor limite da 1ª Faixa de Consumo em
                                            m<sup>3</sup></label>
                                        <input type="text" class="form-control" id="dealership_consumption_tax_1"
                                            placeholder="Valor da 1ª Faixa de Consumo pela concessionária"
                                            name="dealership_consumption_tax_1"
                                            value="{{ old('dealership_consumption_tax_1') ?? $reading->dealership_consumption_tax_1 }}"
                                            required>
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2" data-consumption_ranges="2">
                                        <label for="dealership_cost_tax_2">Custo da 2ª Faixa de Consumo</label>
                                        <input type="text" class="form-control money_format_3"
                                            id="dealership_cost_tax_2"
                                            placeholder="Valor em reais da 2ª Faixa de Consumo pela concessionária"
                                            name="dealership_cost_tax_2"
                                            value="{{ old('dealership_cost_tax_2') ?? $reading->dealership_cost_tax_2 }}"
                                            required>
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2" data-consumption_ranges="3">
                                        <label for="dealership_consumption_tax_2">Valor limite da 2ª Faixa de Consumo em
                                            m<sup>3</sup></label>
                                        <input type="text" class="form-control" id="dealership_consumption_tax_2"
                                            placeholder="Valor limite da 2ª Faixa de Consumo pela concessionária"
                                            name="dealership_consumption_tax_2"
                                            value="{{ old('dealership_consumption_tax_2') ?? $reading->dealership_consumption_tax_2 }}"
                                            required>
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2" data-consumption_ranges="3">
                                        <label for="dealership_cost_tax_3">Custo da 3ª Faixa de Consumo</label>
                                        <input type="text" class="form-control money_format_3"
                                            id="dealership_cost_tax_3"
                                            placeholder="Valor em reais da 3ª Faixa de Consumo pela concessionária"
                                            name="dealership_cost_tax_3"
                                            value="{{ old('dealership_cost_tax_3') ?? $reading->dealership_cost_tax_3 }}"
                                            required>
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2" data-consumption_ranges="4">
                                        <label for="dealership_consumption_tax_3">Valor limite da 3ª Faixa de Consumo em
                                            m<sup>3</sup></label>
                                        <input type="text" class="form-control" id="dealership_consumption_tax_3"
                                            placeholder="Valor limite da 3ª Faixa de Consumo pela concessionária"
                                            name="dealership_consumption_tax_3"
                                            value="{{ old('dealership_consumption_tax_3') ?? $reading->dealership_consumption_tax_3 }}"
                                            required>
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2" data-consumption_ranges="4">
                                        <label for="dealership_cost_tax_4">Custo da 4ª Faixa de Consumo</label>
                                        <input type="text" class="form-control money_format_3"
                                            id="dealership_cost_tax_4"
                                            placeholder="Valor em reais da 4ª Faixa de Consumo pela concessionária"
                                            name="dealership_cost_tax_4"
                                            value="{{ old('dealership_cost_tax_4') ?? $reading->dealership_cost_tax_4 }}"
                                            required>
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2" data-consumption_ranges="5">
                                        <label for="dealership_consumption_tax_4">Valor limite da 4ª Faixa de Consumo em
                                            m<sup>3</sup></label>
                                        <input type="text" class="form-control" id="dealership_consumption_tax_4"
                                            placeholder="Valor limite da 4ª Faixa de Consumo pela concessionária"
                                            name="dealership_consumption_tax_4"
                                            value="{{ old('dealership_consumption_tax_4') ?? $reading->dealership_consumption_tax_4 }}"
                                            required>
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2" data-consumption_ranges="5">
                                        <label for="dealership_cost_tax_5">Custo da 5ª Faixa de Consumo</label>
                                        <input type="text" class="form-control money_format_3"
                                            id="dealership_cost_tax_5"
                                            placeholder="Valor em reais da 5ª Faixa de Consumo pela concessionária"
                                            name="dealership_cost_tax_5"
                                            value="{{ old('dealership_cost_tax_5') ?? $reading->dealership_cost_tax_5 }}"
                                            required>
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2" data-consumption_ranges="6">
                                        <label for="dealership_consumption_tax_5">Valor limite da 5ª Faixa de Consumo em
                                            m<sup>3</sup></label>
                                        <input type="text" class="form-control" id="dealership_consumption_tax_5"
                                            placeholder="Valor limite da 5ª Faixa de Consumo pela concessionária"
                                            name="dealership_consumption_tax_5"
                                            value="{{ old('dealership_consumption_tax_5') ?? $reading->dealership_consumption_tax_5 }}"
                                            required>
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2" data-consumption_ranges="6">
                                        <label for="dealership_cost_tax_6">Custo da 6ª Faixa de Consumo</label>
                                        <input type="text" class="form-control money_format_3"
                                            id="dealership_cost_tax_6"
                                            placeholder="Valor em reais da 6ª Faixa de Consumo pela concessionária"
                                            name="dealership_cost_tax_6"
                                            value="{{ old('dealership_cost_tax_6') ?? $reading->dealership_cost_tax_6 }}"
                                            required>
                                    </div>

                                </div>

                                <div class="d-flex flex-wrap justify-content-start">
                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="consumption_calculation">Tipo de Cálculo de Consumo das
                                            unidades</label>
                                        <x-adminlte-select2 name="consumption_calculation">
                                            <option
                                                {{ old('consumption_calculation') == 'Consumo Real' ? 'selected' : ($reading->consumption_calculation == 'Consumo Real' ? 'selected' : '') }}>
                                                Consumo Real</option>
                                            <option
                                                {{ old('consumption_calculation') == 'Consumo com Mínimo' ? 'selected' : ($reading->consumption_calculation == 'Consumo com Mínimo' ? 'selected' : '') }}>
                                                Consumo com Mínimo</option>
                                            <option
                                                {{ old('consumption_calculation') == 'Consumo Real' ? 'selected' : ($reading->consumption_calculation == 'Consumo sem Mínimo' ? 'selected' : '') }}>
                                                Consumo sem Mínimo</option>
                                        </x-adminlte-select2>
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                        <label for="type_minimum_value">Tipo de Mínimo</label>
                                        <x-adminlte-select2 name="type_minimum_value">
                                            <option
                                                {{ old('type_minimum_value') == 'Pré Estabelecido' ? 'selected' : ($reading->type_minimum_value == 'Pré Estabelecido' ? 'selected' : '') }}>
                                                Pré Estabelecido</option>
                                            <option
                                                {{ old('type_minimum_value') == 'Da Concessionária' ? 'selected' : ($reading->type_minimum_value == 'Da Concessionária' ? 'selected' : '') }}>
                                                Da Concessionária</option>
                                        </x-adminlte-select2>
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 pl-md-2">
                                        <label for="minimum_value">Valor Mínimo de Consumo</label>
                                        <input type="text" class="form-control money_format_2" id="minimum_value"
                                            placeholder="Este valor poderá ser zero" name="minimum_value"
                                            value="{{ old('minimum_value') ?? $reading->minimum_value }}" required>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="fare_type">Tipo de Tarifa</label>
                                        <x-adminlte-select2 name="fare_type">
                                            <option
                                                {{ old('fare_type') == 'Metro Cúbico Médio' ? 'selected' : ($reading->fare_type == 'Metro Cúbico Médio' ? 'selected' : '') }}>
                                                Metro Cúbico Médio</option>
                                            <option
                                                {{ old('fare_type') == 'Concessionária com 2ª faixa pela Progressividade' ? 'selected' : ($reading->fare_type == 'Concessionária com 2ª faixa pela Progressividade' ? 'selected' : '') }}>
                                                Concessionária com 2ª faixa pela Progressividade</option>
                                            <option
                                                {{ old('fare_type') == 'Concessionária com 2ª faixa pela Média' ? 'selected' : ($reading->fare_type == 'Concessionária com 2ª faixa pela Média' ? 'selected' : '') }}>
                                                Concessionária com 2ª faixa pela Média</option>
                                        </x-adminlte-select2>
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                        <label for="common_area">Tipo de Rateio da Área Comum</label>
                                        <x-adminlte-select2 name="common_area">
                                            <option
                                                {{ old('common_area') == 'Sem' ? 'selected' : ($reading->common_area == 'Sem' ? 'selected' : '') }}>
                                                Sem</option>
                                            <option
                                                {{ old('common_area') == 'Simples' ? 'selected' : ($reading->common_area == 'Simples' ? 'selected' : '') }}>
                                                Simples
                                            </option>
                                            <option
                                                {{ old('common_area') == 'Fração' ? 'selected' : ($reading->common_area == 'Fração' ? 'selected' : '') }}>
                                                Fração
                                            </option>
                                        </x-adminlte-select2>
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 pl-md-2">
                                        <label for="sewage_calc">Tipo de Cálculo do Esgoto</label>
                                        <x-adminlte-select2 name="sewage_calc">
                                            <option
                                                {{ old('sewage_calc') == 'Igual ao consumo de água' ? 'selected' : ($reading->sewage_calc == 'Igual ao consumo de água' ? 'selected' : '') }}>
                                                Igual ao consumo de água</option>
                                            <option
                                                {{ old('sewage_calc') == 'Metade do valor do consumo de água' ? 'selected' : ($reading->sewage_calc == 'Metade do valor do consumo de água' ? 'selected' : '') }}>
                                                Metade do valor do consumo de água</option>
                                            <option
                                                {{ old('sewage_calc') == 'Sem cobrança' ? 'selected' : ($reading->sewage_calc == 'Sem cobrança' ? 'selected' : '') }}>
                                                Sem cobrança</option>
                                        </x-adminlte-select2>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="billed_consumption">Consumo Faturado Mês Atual em m<sup>3</sup></label>
                                        <input type="text" class="form-control" id="billed_consumption"
                                            placeholder="Consumo Faturado Mês Atual" name="billed_consumption"
                                            value="{{ old('billed_consumption') ?? $reading->billed_consumption }}"
                                            required>
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                        <label for="dealership_consumption">Consumo da Concessionária em
                                            m<sup>3</sup></label>
                                        <input type="text" class="form-control" id="dealership_consumption"
                                            placeholder="Consumo medido pela concessionária" name="dealership_consumption"
                                            value="{{ old('dealership_consumption') ?? $reading->dealership_consumption }}"
                                            required>
                                    </div>
                                    <div class="col-12 col-md-4 form-group px-0 pl-md-2">
                                        <label for="dealership_cost">Custo da Concessionária em Reais</label>
                                        <input type="text" class="form-control money_format_2" id="dealership_cost"
                                            placeholder="Custo total do medido pela concessionária" name="dealership_cost"
                                            value="{{ old('dealership_cost') ?? $reading->dealership_cost }}" required>
                                    </div>

                                </div>

                                {{-- Kite Car --}}
                                <div class="d-flex flex-wrap justify-content-start" data-value={{ $reading->kite_car }}
                                    id="kitCarContainer">

                                    <div class="col-12 col-md-2 form-group px-0 pr-md-2 mb-0">
                                        <label for="kite_car">Carro Pipa</label>
                                        <x-adminlte-select2 name="kite_car">
                                            <option
                                                {{ old('kite_car') == 'Não' ? 'selected' : ($reading->kite_car == 'Não' ? 'selected' : '') }}>
                                                Não</option>
                                            <option
                                                {{ old('kite_car') == 'Sim' ? 'selected' : ($reading->kite_car == 'Sim' ? 'selected' : '') }}>
                                                Sim</option>
                                        </x-adminlte-select2>
                                    </div>

                                    <div class="col-12 col-md-2 form-group px-0 px-md-2 kite_car">
                                        <label for="dealership_consumption">m<sup>3</sup> recebidos</label>
                                        <input type="text" class="form-control" id="kite_car_consumption"
                                            placeholder="Quantidade de m³" name="kite_car_consumption"
                                            value="{{ old('kite_car_consumption') ?? $reading->kite_car_consumption }}">
                                    </div>

                                    <div class="col-12 col-md-2 form-group px-0 px-md-2 kite_car">
                                        <label for="kite_car_tax">Valor do m<sup>3</sup></label>
                                        <input type="text" class="form-control money_format_2" id="kite_car_tax"
                                            placeholder="Quantidade em Reais" name="kite_car_tax"
                                            value="{{ old('kite_car_tax') ?? $reading->kite_car_tax }}">
                                    </div>

                                    <div class="col-12 col-md-2 form-group px-0 px-md-2 kite_car">
                                        <label for="kite_car_qtd">Qtd Caminhões</label>
                                        <input type="number" class="form-control" id="kite_car_qtd"
                                            placeholder="Quantidade" name="kite_car_qtd" min="0"
                                            value="{{ old('kite_car_qtd') ?? $reading->kite_car_qtd }}">
                                    </div>

                                    <div class="col-12 col-md-2 form-group px-0 px-md-2 kite_car">
                                        <label for="value_per_kite_car">Valor por Caminhão</label>
                                        <input type="text" class="form-control" id="value_per_kite_car"
                                            name="value_per_kite_car" disabled
                                            value="{{ $reading->value_per_kite_car }}">
                                    </div>

                                    <div class="col-12 col-md-2 form-group px-0 pl-md-2 kite_car">
                                        <label for="kite_car_total">Valor Total Carro Pipa</label>
                                        <input type="text" class="form-control" id="kite_car_total"
                                            name="kite_car_total" disabled value="{{ $reading->kite_car_total }}">
                                    </div>

                                </div>

                                {{-- Totais --}}
                                <div class="d-flex flex-wrap justify-content-start">
                                    <div class="col-12 col-md-3 form-group px-0 pr-md-2">
                                        <label for="monthly_consumption">Consumo Unidades em m<sup>3</sup></label>
                                        <input type="text" class="form-control" id="monthly_consumption"
                                            name="monthly_consumption" disabled
                                            value="{{ $reading->monthly_consumption }}">
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="monthly_consumption">Conta Total</label>
                                        <input type="text" class="form-control" id="monthly_consumption"
                                            name="monthly_consumption" disabled value="{{ $reading->total_value }}">
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="consumption_value">Valor do Consumo</label>
                                        <input type="text" class="form-control" id="consumption_value"
                                            name="consumption_value" disabled
                                            value="{{ $reading->consumption_value }}">
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                        <label for="sewage_value">Valor do Esgoto</label>
                                        <input type="text" class="form-control" id="sewage_value" name="sewage_value"
                                            disabled value="{{ $reading->sewage_value }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-start">
                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="kite_car_consumed_units">Consumo Carro Pipa das Unidades em
                                            m<sup>3</sup></label>
                                        <input type="text" class="form-control" id="kite_car_consumed_units"
                                            name="kite_car_consumed_units" disabled
                                            value="{{ $reading->kite_car_consumed_units }}">
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                        <label for="kite_car_cost_units">Valor Carro Pipa das Unidades</label>
                                        <input type="text" class="form-control" id="kite_car_cost_units"
                                            name="kite_car_cost_units" disabled
                                            value="{{ $reading->kite_car_cost_units }}">
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 pl-md-2">
                                        <label for="diff_cost">Área Comum</label>
                                        <input type="text" class="form-control" id="diff_cost" name="diff_cost"
                                            disabled value="{{ $reading->diff_cost }}">
                                    </div>
                                </div>

                                {{-- Computed Data --}}
                                <div class="d-flex flex-wrap justify-content-start">

                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="diff_consumption">Diferença entre Real e Concessionária em
                                            m<sup>3</sup></label>
                                        <input type="text" class="form-control" id="diff_consumption"
                                            name="diff_consumption" disabled value="{{ $reading->diff_consumption }}">
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                        <label for="previous_billed_consumption">Consumo Faturado Mês Anterior em
                                            m<sup>3</sup></label>
                                        <input type="text" class="form-control" id="previous_billed_consumption"
                                            name="previous_billed_consumption" disabled
                                            value="{{ $reading->previous_billed_consumption }}">
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
                                        <label for="consumption_tax_1">Consumo na 1ª Faixa</label>
                                        <input type="text" class="form-control" id="consumption_tax_1"
                                            name="consumption_tax_1" disabled
                                            value="{{ $reading->consumption_tax_1 }}">
                                    </div>
                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="total_cost_tax_1">Custo total 1ª Faixa</label>
                                        <input type="text" class="form-control" id="total_cost_tax_1"
                                            name="total_cost_tax_1" disabled value="{{ $reading->total_cost_tax_1 }}">
                                    </div>
                                    @if ($reading->consumption_ranges > 1)
                                        <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                            <label for="consumption_tax_2">Consumo na 2ª Faixa</label>
                                            <input type="text" class="form-control" id="consumption_tax_2"
                                                name="consumption_tax_2" disabled
                                                value="{{ $reading->consumption_tax_2 }}">
                                        </div>
                                        <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                            <label for="total_cost_tax_2">Custo total 2ª Faixa</label>
                                            <input type="text" class="form-control" id="total_cost_tax_2"
                                                name="total_cost_tax_2" disabled
                                                value="{{ $reading->total_cost_tax_2 }}">
                                        </div>
                                    @endif

                                    @if ($reading->consumption_ranges > 2)
                                        <div class="col-12 col-md-3 form-group px-0 pr-md-2">
                                            <label for="consumption_tax_3">Consumo na 3ª Faixa</label>
                                            <input type="text" class="form-control" id="consumption_tax_3"
                                                name="consumption_tax_3" disabled
                                                value="{{ $reading->consumption_tax_3 }}">
                                        </div>
                                        <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                            <label for="total_cost_tax_3">Custo total 3ª Faixa</label>
                                            <input type="text" class="form-control" id="total_cost_tax_3"
                                                name="total_cost_tax_3" disabled
                                                value="{{ $reading->total_cost_tax_3 }}">
                                        </div>
                                    @endif

                                    @if ($reading->consumption_ranges > 3)
                                        <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                            <label for="consumption_tax_4">Consumo na 4ª Faixa</label>
                                            <input type="text" class="form-control" id="consumption_tax_4"
                                                name="consumption_tax_4" disabled
                                                value="{{ $reading->consumption_tax_4 }}">
                                        </div>
                                        <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                            <label for="total_cost_tax_4">Custo total 4ª Faixa</label>
                                            <input type="text" class="form-control" id="total_cost_tax_4"
                                                name="total_cost_tax_4" disabled
                                                value="{{ $reading->total_cost_tax_4 }}">
                                        </div>
                                    @endif

                                    @if ($reading->consumption_ranges > 4)
                                        <div class="col-12 col-md-3 form-group px-0 pr-md-2">
                                            <label for="consumption_tax_5">Consumo na 5ª Faixa</label>
                                            <input type="text" class="form-control" id="consumption_tax_5"
                                                name="consumption_tax_5" disabled
                                                value="{{ $reading->consumption_tax_5 }}">
                                        </div>
                                        <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                            <label for="total_cost_tax_5">Custo total 5ª Faixa</label>
                                            <input type="text" class="form-control" id="total_cost_tax_5"
                                                name="total_cost_tax_5" disabled
                                                value="{{ $reading->total_cost_tax_5 }}">
                                        </div>
                                    @endif

                                    @if ($reading->consumption_ranges > 5)
                                        <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                            <label for="consumption_tax_6">Consumo na 6ª Faixa</label>
                                            <input type="text" class="form-control" id="consumption_tax_6"
                                                name="consumption_tax_6" disabled
                                                value="{{ $reading->consumption_tax_6 }}">
                                        </div>
                                        <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                            <label for="total_cost_tax_6">Custo total 6ª Faixa</label>
                                            <input type="text" class="form-control" id="total_cost_tax_6"
                                                name="total_cost_tax_6" disabled
                                                value="{{ $reading->total_cost_tax_6 }}">
                                        </div>
                                    @endif

                                </div>

                                <div class="d-flex flex-wrap justify-content-start">
                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="units_inside_tax_1">Unidades dentro da 1ª Faixa</label>
                                        <input type="text" class="form-control" id="units_inside_tax_1"
                                            name="units_inside_tax_1" disabled
                                            value="{{ $reading->units_inside_tax_1 }}">
                                    </div>
                                    @if ($reading->consumption_ranges > 1)
                                        <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                            <label for="units_inside_tax_2">Unidades dentro da 2ª Faixa</label>
                                            <input type="text" class="form-control" id="units_inside_tax_2"
                                                name="units_inside_tax_2" disabled
                                                value="{{ $reading->units_inside_tax_2 }}">
                                        </div>
                                    @endif
                                    @if ($reading->consumption_ranges > 2)
                                        <div class="col-12 col-md-4 form-group px-0 pl-md-2">
                                            <label for="units_inside_tax_3">Unidades dentro da 3ª Faixa</label>
                                            <input type="text" class="form-control" id="units_inside_tax_3"
                                                name="units_inside_tax_3" disabled
                                                value="{{ $reading->units_inside_tax_3 }}">
                                        </div>
                                    @endif
                                    @if ($reading->consumption_ranges > 3)
                                        <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                            <label for="units_inside_tax_4">Unidades dentro da 4ª Faixa</label>
                                            <input type="text" class="form-control" id="units_inside_tax_4"
                                                name="units_inside_tax_4" disabled
                                                value="{{ $reading->units_inside_tax_4 }}">
                                        </div>
                                    @endif
                                    @if ($reading->consumption_ranges > 4)
                                        <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                            <label for="units_inside_tax_5">Unidades dentro da 5ª Faixa</label>
                                            <input type="text" class="form-control" id="units_inside_tax_5"
                                                name="units_inside_tax_5" disabled
                                                value="{{ $reading->units_inside_tax_5 }}">
                                        </div>
                                    @endif
                                    @if ($reading->consumption_ranges > 5)
                                        <div class="col-12 col-md-4 form-group px-0 pl-md-2">
                                            <label for="units_inside_tax_6">Unidades dentro da 6ª Faixa</label>
                                            <input type="text" class="form-control" id="units_inside_tax_6"
                                                name="units_inside_tax_6" disabled
                                                value="{{ $reading->units_inside_tax_6 }}">
                                        </div>
                                    @endif
                                </div>

                                <div class="border-bottom mb-4"></div>

                                @if ($reports->count() > 0)
                                    <div class="d-flex flex-wrap justify-content-between">

                                        @php
                                            $heads = ['Bl', 'Ap', 'Consumo Unidades (m³)', 'Valor de Consumo', 'Valor de Esgoto', 'Consumo Carro Pipa (m³)', 'Custo Carro Pipa', 'Ajuste de Área Comum', 'Total da Unidade'];

                                            $config = [
                                                'ajax' => url('/admin/dealerships-readings/' . $reading->id . '/edit'),
                                                'columns' => [['data' => 'block', 'name' => 'block'], ['data' => 'apartment', 'name' => 'apartment'], ['data' => 'consumed', 'name' => 'consumed'], ['data' => 'consumed_cost', 'name' => 'consumed_cost'], ['data' => 'sewage_cost', 'name' => 'sewage_cost'], ['data' => 'kite_car_consumed', 'name' => 'kite_car_consumed'], ['data' => 'kite_car_cost', 'name' => 'kite_car_cost'], ['data' => 'partial', 'name' => 'partial'], ['data' => 'total_unit', 'name' => 'total_unit']],
                                                'language' => ['url' => asset('vendor/datatables/js/pt-BR.json')],
                                                'autoFill' => true,
                                                'processing' => true,
                                                'serverSide' => true,
                                                'responsive' => true,
                                                'order' => [[0, 'asc']],
                                                'dom' => '<"d-flex flex-wrap col-12 justify-content-between"Bf>rtip',
                                            ];
                                        @endphp
                                        <x-adminlte-datatable id="table1" :heads="$heads" :heads="$heads"
                                            :config="$config" striped hoverable beautify with-buttons />
                                    </div>
                                @endif

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
