@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)

@section('title', '- Edição de Consumo de Condomínio')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-chart-bar"></i> Condomínio {{ $complex->alias_name }} - Consumo</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('app.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('app.residences.readings') }}">Leituras</a>
                        </li>
                        <li class="breadcrumb-item active">Condomínio</li>
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
                            <h3 class="card-title">Dados de Consumo</h3>
                        </div>


                        <form>
                            <div class="card-body">
                                <div class="d-flex flex-wrap justify-content-between">

                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="description">Condomínio</label>
                                        <input type="text" class="form-control bg-light" id="description" name="description"
                                            value="{{ $complex->alias_name }}" disabled>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="month_ref">Mês de Referência</label>
                                        <input type="text" class="form-control bg-light" id="month_ref" name="month_ref"
                                            value="{{ $reading->month_ref }}" disabled>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                        <label for="year_ref">Ano de Referência</label>
                                        <input type="text" class="form-control bg-light" id="year_ref" name="year_ref"
                                            value="{{ $reading->year_ref }}" disabled>
                                    </div>

                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-3 form-group px-0 pr-md-2">
                                        <label for="reading_date">Data da Leitura</label>
                                        <input type="text" class="form-control bg-light" id="reading_date"
                                            name="reading_date"
                                            value="{{ old('reading_date') ?? $reading->reading_date }}" required>
                                    </div>
                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="reading_date_next">Data da Próxima Leitura</label>
                                        <input type="text" class="form-control bg-light" id="reading_date_next"
                                            name="reading_date_next"
                                            value="{{ old('reading_date_next') ?? $reading->reading_date_next }}"
                                            required>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="total_days">Total de Dias</label>
                                        <input type="text" class="form-control bg-light" id="total_days"
                                            value="{{ old('total_days') ?? $reading->total_days }}" required>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                        <label for="dealership_id">Concessionária</label>
                                        <input type="text" class="form-control bg-light" id="dealership_id"
                                            name="dealership_id" value="{{ $reading->dealership['name'] }}" disabled>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="dealership_consumption_tax_1">Valor máximo da 1ª Faixa de Consumo em
                                            m<sup>3</sup></label>
                                        <input type="text" class="form-control bg-light" id="dealership_consumption_tax_1"
                                            name="dealership_consumption_tax_1"
                                            value="{{ old('dealership_consumption_tax_1') ?? $reading->dealership_consumption_tax_1 }}"
                                            required>
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="dealership_cost_tax_1">Custo da 1ª Faixa de Consumo</label>
                                        <input type="text" class="form-control bg-light" id="dealership_cost_tax_1"
                                            name="dealership_cost_tax_1"
                                            value="{{ old('dealership_cost_tax_1') ?? $reading->dealership_cost_tax_1 }}"
                                            required>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="dealership_consumption_tax_2">Valor mínimo da 2ª Faixa de Consumo em
                                            m<sup>3</sup></label>
                                        <input type="text" class="form-control bg-light" id="dealership_consumption_tax_2"
                                            name="dealership_consumption_tax_2"
                                            value="{{ old('dealership_consumption_tax_2') ?? $reading->dealership_consumption_tax_2 }}"
                                            required>
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="dealership_cost_tax_2">Custo da 2ª Faixa de Consumo</label>
                                        <input type="text" class="form-control bg-light" id="dealership_cost_tax_2"
                                            name="dealership_cost_tax_2"
                                            value="{{ old('dealership_cost_tax_2') ?? $reading->dealership_cost_tax_2 }}"
                                            required>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="dealership_consumption">Consumo da Concessionária em
                                            m<sup>3</sup></label>
                                        <input type="text" class="form-control bg-light" id="dealership_consumption"
                                            name="dealership_consumption"
                                            value="{{ old('dealership_consumption') ?? $reading->dealership_consumption }}"
                                            required>
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="dealership_cost">Custo da Concessionária em Reais</label>
                                        <input type="text" class="form-control bg-light" id="dealership_cost"
                                            name="dealership_cost"
                                            value="{{ old('dealership_cost') ?? $reading->dealership_cost }}" required>
                                    </div>
                                </div>
                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="monthly_consumption">Consumo Real em m<sup>3</sup></label>
                                        <input type="text" class="form-control bg-light" id="monthly_consumption"
                                            name="monthly_consumption" disabled
                                            value="{{ $reading->monthly_consumption }}">
                                    </div>
                                    <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                        <label for="diff_consumption">Área comum em m<sup>3</sup></label>
                                        <input type="text" class="form-control bg-light" id="diff_consumption"
                                            name="diff_consumption" disabled value="{{ $reading->diff_consumption }}">
                                    </div>
                                    <div class="col-12 col-md-4 form-group px-0 pl-md-2">
                                        <label for="previous_monthly_consumption">Consumo Real Anterior em
                                            m<sup>3</sup></label>
                                        <input type="text" class="form-control bg-light" id="previous_monthly_consumption"
                                            name="previous_monthly_consumption" disabled
                                            value="{{ $reading->previous_monthly_consumption }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-start">
                                    <div class="col-12 col-md-3 form-group px-0 pr-md-2">
                                        <label for="consumption_tax_1">Consumo 1ª Faixa</label>
                                        <input type="text" class="form-control bg-light" id="consumption_tax_1"
                                            name="consumption_tax_1" disabled value="{{ $reading->consumption_tax_1 }}">
                                    </div>
                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="total_cost_tax_1">Custo total 1ª Faixa</label>
                                        <input type="text" class="form-control bg-light" id="total_cost_tax_1"
                                            name="total_cost_tax_1" disabled value="{{ $reading->total_cost_tax_1 }}">
                                    </div>
                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="consumption_tax_2">Consumo 2ª Faixa</label>
                                        <input type="text" class="form-control bg-light" id="consumption_tax_2"
                                            name="consumption_tax_2" disabled value="{{ $reading->consumption_tax_2 }}">
                                    </div>
                                    <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                        <label for="total_cost_tax_2">Custo total 2ª Faixa</label>
                                        <input type="text" class="form-control bg-light" id="total_cost_tax_2"
                                            name="total_cost_tax_2" disabled value="{{ $reading->total_cost_tax_2 }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="real_cost">Custo do Total Medido em Reais</label>
                                        <input type="text" class="form-control bg-light" id="real_cost" name="real_cost"
                                            disabled value="{{ $reading->real_cost }}">
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="diff_cost">Diferença entre o Medido e
                                            Concessionária</label>
                                        <input type="text" class="form-control bg-light" id="diff_cost" name="diff_cost"
                                            disabled value="{{ $reading->diff_cost }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    @if ($reading->fraction)
                                        @foreach ($reading->fraction as $key => $value)
                                            <div
                                                class="col-12 col-md-6 form-group px-0 {{ $loop->index % 2 == 0 ? 'pr-md-2' : 'pl-md-2' }}">
                                                <label for="fraction">Valor por fração para {{ $key }}
                                                    unidades</label>
                                                <input type="text" class="form-control bg-light"
                                                    id="fraction{{ $loop->index }}" name="fraction" disabled
                                                    value="{{ $value }}">
                                            </div>
                                        @endforeach
                                    @endif
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="units_inside_tax_1">Unidades dentro da 1ª Faixa</label>
                                        <input type="text" class="form-control  bg-light" id="units_inside_tax_1"
                                            name="units_inside_tax_1" disabled
                                            value="{{ $reading->units_inside_tax_1 }}">
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="units_above_tax_1">Unidades acima da 1ª Faixa</label>
                                        <input type="text" class="form-control  bg-light" id="units_above_tax_1"
                                            name="units_above_tax_1" disabled value="{{ $reading->units_above_tax_1 }}">
                                    </div>
                                </div>

                                <div class="border-bottom mb-4"></div>

                                @if ($reading->apartments_report)
                                    <div class="d-flex flex-wrap justify-content-between">
                                        @php
                                            $heads = ['Apartamento', 'Valor Total de Consumo', 'Rateio Proporcional ao Consumo', 'Valor total da Unidade'];

                                            $list = [];

                                            foreach ($reading->apartments_report as $apartment) {
                                                $list[] = [$apartment->name, $apartment->total, $apartment->partial, $apartment->total_unit];
                                            }

                                            $config = [
                                                'data' => $list,
                                                'order' => [[0, 'asc']],
                                                'columns' => [null, null, null, null],
                                                'language' => ['url' => asset('vendor/datatables/js/pt-BR.json')],
                                            ];
                                        @endphp

                                        <x-adminlte-datatable id="table1" :heads="$heads" :heads="$heads"
                                            :config="$config" striped hoverable beautify with-buttons />
                                    </div>
                                @endif
                            </div>

                            <div class="card-footer">
                                <a href="{{ route('app.complex.readings.print', ['reading' => $reading->id, 'complex' => $complex->id]) }}"
                                    target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Imprimir</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
