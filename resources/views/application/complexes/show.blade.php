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
                                        <input type="text" class="form-control bg-light" id="description"
                                            name="description" value="{{ $complex->alias_name }}" disabled>
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
                                            name="reading_date" value="{{ $reading->reading_date }}" disabled>
                                    </div>
                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="reading_date_next">Data da Próxima Leitura</label>
                                        <input type="text" class="form-control bg-light" id="reading_date_next"
                                            name="reading_date_next" value="{{ $reading->reading_date_next }}" disabled>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="total_days">Total de Dias</label>
                                        <input type="text" class="form-control bg-light" id="total_days"
                                            value="{{ $reading->total_days }}" disabled>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                        <label for="dealership_id">Concessionária</label>
                                        <input type="text" class="form-control bg-light" id="dealership_id"
                                            name="dealership_id" value="{{ $reading->dealership['name'] }}" disabled>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="dealership_consumption_tax_1">Valor da 1ª Faixa de Consumo em
                                            m<sup>3</sup></label>
                                        <input type="text" class="form-control bg-light"
                                            id="dealership_consumption_tax_1" name="dealership_consumption_tax_1"
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
                                        <label for="dealership_consumption_tax_2">Valor da 2ª Faixa de Consumo em
                                            m<sup>3</sup></label>
                                        <input type="text" class="form-control bg-light"
                                            id="dealership_consumption_tax_2" name="dealership_consumption_tax_2"
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

                                <div class="d-flex flex-wrap justify-content-start">
                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="consumption_calculation">Tipo de Cálculo de Consumo das
                                            unidades</label>
                                        <input type="text" class="form-control bg-light" id="consumption_calculation"
                                            name="consumption_calculation"
                                            value="{{ $reading->consumption_calculation }}" disabled>
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                        <label for="type_minimum_value">Tipo de Mínimo</label>
                                        <input type="text" class="form-control bg-light" id="type_minimum_value"
                                            name="type_minimum_value" value="{{ $reading->type_minimum_value }}"
                                            disabled>
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 pl-md-2">
                                        <label for="minimum_value">Valor Mínimo de Consumo</label>
                                        <input type="text" class="form-control bg-light" id="minimum_value"
                                            name="minimum_value" value="{{ $reading->minimum_value }}" disabled>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="fare_type">Tipo de Tarifa</label>
                                        <input type="text" class="form-control bg-light" id="fare_type"
                                            name="fare_type" value="{{ $reading->fare_type }}" disabled>
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="common_area">Tipo de Rateio da Área Comum</label>
                                        <input type="text" class="form-control bg-light" id="common_area"
                                            name="common_area" value="{{ $reading->common_area }}" disabled>
                                    </div>

                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="billed_consumption">Consumo Faturado Mês Atual em m<sup>3</sup></label>
                                        <input type="text" class="form-control bg-light" id="billed_consumption"
                                            placeholder="Consumo Faturado Mês Atual" name="billed_consumption"
                                            value="{{ $reading->billed_consumption }}" disabled>
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                        <label for="dealership_consumption">Consumo da Concessionária em
                                            m<sup>3</sup></label>
                                        <input type="text" class="form-control bg-light" id="dealership_consumption"
                                            placeholder="Consumo medido pela concessionária" name="dealership_consumption"
                                            value="{{ $reading->dealership_consumption }}" disabled>
                                    </div>
                                    <div class="col-12 col-md-4 form-group px-0 pl-md-2">
                                        <label for="dealership_cost">Custo da Concessionária em Reais</label>
                                        <input type="text" class="form-control bg-light" id="dealership_cost"
                                            placeholder="Custo total do medido pela concessionária" name="dealership_cost"
                                            value="{{ $reading->dealership_cost }}" disabled>
                                    </div>

                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="previous_billed_consumption">Consumo Faturado Mês Anterior em
                                            m<sup>3</sup></label>
                                        <input type="text" class="form-control bg-light"
                                            id="previous_billed_consumption" name="previous_billed_consumption" disabled
                                            value="{{ $reading->previous_billed_consumption }}">
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                        <label for="monthly_consumption">Consumo Real em m<sup>3</sup></label>
                                        <input type="text" class="form-control bg-light" id="monthly_consumption"
                                            name="monthly_consumption" disabled
                                            value="{{ $reading->monthly_consumption }}">
                                    </div>
                                    <div class="col-12 col-md-4 form-group px-0 pl-md-2">
                                        <label for="diff_consumption">Diferença entre Real e Concessionária em
                                            m<sup>3</sup></label>
                                        <input type="text" class="form-control bg-light" id="diff_consumption"
                                            name="diff_consumption" disabled value="{{ $reading->diff_consumption }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-start">

                                    <div class="col-12 col-md-3 form-group px-0 pr-md-2">
                                        <label for="previous_monthly_consumption">Consumo Real Anterior em
                                            m<sup>3</sup></label>
                                        <input type="text" class="form-control bg-light"
                                            id="previous_monthly_consumption" name="previous_monthly_consumption" disabled
                                            value="{{ $reading->previous_monthly_consumption }}">
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="consumption_value">Valor do Consumo</label>
                                        <input type="text" class="form-control bg-light" id="consumption_value"
                                            name="consumption_value" disabled
                                            value="{{ $reading->consumption_value }}">
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="sewage_value">Valor do Esgoto</label>
                                        <input type="text" class="form-control bg-light" id="sewage_value"
                                            name="sewage_value" disabled value="{{ $reading->sewage_value }}">
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                        <label for="total_value">Valor Total</label>
                                        <input type="text" class="form-control bg-light" id="total_value"
                                            name="total_value" disabled value="{{ $reading->total_value }}">
                                    </div>

                                </div>

                                <div class="d-flex flex-wrap justify-content-between">

                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="diff_cost">Área Comum</label>
                                        <input type="text" class="form-control bg-light" id="diff_cost"
                                            name="diff_cost" disabled value="{{ $reading->diff_cost }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-start">
                                    <div class="col-12 col-md-3 form-group px-0 pr-md-2">
                                        <label for="consumption_tax_1">Consumo na 1ª Faixa</label>
                                        <input type="text" class="form-control bg-light" id="consumption_tax_1"
                                            name="consumption_tax_1" disabled
                                            value="{{ $reading->consumption_tax_1 }}">
                                    </div>
                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="total_cost_tax_1">Custo total 1ª Faixa</label>
                                        <input type="text" class="form-control bg-light" id="total_cost_tax_1"
                                            name="total_cost_tax_1" disabled value="{{ $reading->total_cost_tax_1 }}">
                                    </div>
                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="consumption_tax_2">Consumo na 2ª Faixa</label>
                                        <input type="text" class="form-control bg-light" id="consumption_tax_2"
                                            name="consumption_tax_2" disabled
                                            value="{{ $reading->consumption_tax_2 }}">
                                    </div>
                                    <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                        <label for="total_cost_tax_2">Custo total 2ª Faixa</label>
                                        <input type="text" class="form-control bg-light" id="total_cost_tax_2"
                                            name="total_cost_tax_2" disabled value="{{ $reading->total_cost_tax_2 }}">
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="units_inside_tax_1">Unidades dentro da 1ª Faixa</label>
                                        <input type="text" class="form-control bg-light" id="units_inside_tax_1"
                                            name="units_inside_tax_1" disabled
                                            value="{{ $reading->units_inside_tax_1 }}">
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="units_above_tax_1">Unidades acima da 1ª Faixa</label>
                                        <input type="text" class="form-control bg-light" id="units_above_tax_1"
                                            name="units_above_tax_1" disabled
                                            value="{{ $reading->units_above_tax_1 }}">
                                    </div>
                                </div>

                                <div class="border-bottom mb-4"></div>

                                @if ($reading->apartmentReports->count() > 0)
                                    <div class="d-flex flex-wrap justify-content-between">
                                        @php
                                            $heads = ['Apartamento', 'Volume Consumido (m3)', 'Valor de Consumo', 'Valor de Esgoto', 'Ajuste de Área Comum', 'Valor total da Unidade'];

                                            $list = [];

                                            foreach ($reading->apartmentReports as $report) {
                                                $list[] = [$report->apartment->name, $report->consumed, $report->consumed_cost, $report->sewage_cost, $report->partial, $report->total_unit];
                                            }

                                            $config = [
                                                'data' => $list,
                                                'order' => [[0, 'asc']],
                                                'columns' => [null, null, null, null, null, null],
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
