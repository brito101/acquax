@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)

@section('adminlte_css_pre')
    <style>
        @page {
            margin: 2cm;
        }
    </style>
@endsection

@section('title', '- Dados de Consumo')

@section('content')
    <div class="card ml-n4 border" style="margin-bottom: -75px;">
        <div class="d-flex flex-wrap justify-content-center">
            <img src="{{ asset('img/logo.png') }}" style="width: 500px;">
            <h2 class="w-100 text-center">Relatório de Consumo de Água</h2>
        </div>
        <div class="card-header">
            <h3 class="card-title">Dados de Consumo</h3>
        </div>

        <form style="border: 4px solid #007bff">
            <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between">

                    <div class="col-6 form-group pr-2">
                        <label for="description">Condomínio</label>
                        <input type="text" class="form-control bg-light" id="description" name="description"
                            value="{{ $complex->alias_name }}" disabled>
                    </div>

                    <div class="col-3 form-group px-2">
                        <label for="month_ref">Mês de Referência</label>
                        <input type="text" class="form-control bg-light" id="month_ref" name="month_ref"
                            value="{{ $reading->month_ref }}" disabled>
                    </div>

                    <div class="col-3 form-group pl-2">
                        <label for="year_ref">Ano de Referência</label>
                        <input type="text" class="form-control bg-light" id="year_ref" name="year_ref"
                            value="{{ $reading->year_ref }}" disabled>
                    </div>

                </div>

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-3 form-group pr-2">
                        <label for="reading_date">Data da Leitura</label>
                        <input type="text" class="form-control bg-light" id="reading_date" name="reading_date"
                            value="{{ $reading->reading_date }}" disabled>
                    </div>
                    <div class="col-3 form-group px-2">
                        <label for="reading_date_next">Data da Próxima Leitura</label>
                        <input type="text" class="form-control bg-light" id="reading_date_next" name="reading_date_next"
                            value="{{ $reading->reading_date_next }}" disabled>
                    </div>

                    <div class="col-3 form-group px-2">
                        <label for="total_days">Total de Dias</label>
                        <input type="text" class="form-control bg-light" id="total_days"
                            value="{{ old('total_days') ?? $reading->total_days }}" required>
                    </div>

                    <div class="col-3 form-group pl-2">
                        <label for="dealership_id">Concessionária</label>
                        <input type="text" class="form-control bg-light" id="dealership_id" name="dealership_id"
                            value="{{ $reading->dealership['name'] }}" disabled>
                    </div>
                </div>


                <div class="d-flex flex-wrap justify-content-start">
                    <div class="col-6 form-group pr-2">
                        <label for="consumption_ranges">Qtd de faixas de Consumo</label>
                        <input type="text" name="consumption_ranges" id="consumption_ranges"
                            class="form-control bg-light" value="{{ $reading->consumption_ranges }}" disabled>
                    </div>

                    <div class="col-6 form-group pl-2">
                        <label for="dealership_cost_tax_1">Custo da 1ª Faixa de Consumo</label>
                        <input type="text" class="form-control bg-light" id="dealership_cost_tax_1"
                            name="dealership_cost_tax_1" value="{{ $reading->dealership_cost_tax_1 }}" disabled>
                    </div>

                    @if ($reading->consumption_ranges > 1)
                        <div class="col-6 form-group pr-2">
                            <label for="dealership_consumption_tax_1">Valor limite da 1ª Faixa de Consumo em
                                m<sup>3</sup></label>
                            <input type="text" class="form-control bg-light" id="dealership_consumption_tax_1"
                                name="dealership_consumption_tax_1" value="{{ $reading->dealership_consumption_tax_1 }}"
                                disabled>
                        </div>

                        <div class="col-6 form-group pl-2">
                            <label for="dealership_cost_tax_2">Custo da 2ª Faixa de Consumo</label>
                            <input type="text" class="form-control bg-light" id="dealership_cost_tax_2"
                                name="dealership_cost_tax_2" value="{{ $reading->dealership_cost_tax_2 }}" disabled>
                        </div>
                    @endif
                    @if ($reading->consumption_ranges > 2)
                        <div class="col-6 form-group pr-2">
                            <label for="dealership_consumption_tax_2">Valor limite da 2ª Faixa de Consumo
                                em
                                m<sup>3</sup></label>
                            <input type="text" class="form-control bg-light" id="dealership_consumption_tax_2"
                                name="dealership_consumption_tax_2" value="{{ $reading->dealership_consumption_tax_2 }}"
                                disabled>
                        </div>

                        <div class="col-6 form-group pl-2">
                            <label for="dealership_cost_tax_3">Custo da 3ª Faixa de Consumo</label>
                            <input type="text" class="form-control bg-light" id="dealership_cost_tax_3"
                                name="dealership_cost_tax_3" value="{{ $reading->dealership_cost_tax_3 }}" disabled>
                        </div>
                    @endif
                    @if ($reading->consumption_ranges > 3)
                        <div class="col-6 form-group pr-2">
                            <label for="dealership_consumption_tax_3">Valor limite da 3ª Faixa de Consumo
                                em
                                m<sup>3</sup></label>
                            <input type="text" class="form-control bg-light" id="dealership_consumption_tax_3"
                                name="dealership_consumption_tax_3" value="{{ $reading->dealership_consumption_tax_3 }}"
                                disabled>
                        </div>

                        <div class="col-6 form-group pr-l">
                            <label for="dealership_cost_tax_4">Custo da 4ª Faixa de Consumo</label>
                            <input type="text" class="form-control bg-light" id="dealership_cost_tax_4"
                                name="dealership_cost_tax_4" value="{{ $reading->dealership_cost_tax_4 }}" disabled>
                        </div>
                    @endif
                    @if ($reading->consumption_ranges > 4)
                        <div class="col-6 form-group pr-2">
                            <label for="dealership_consumption_tax_4">Valor limite da 4ª Faixa de Consumo
                                em
                                m<sup>3</sup></label>
                            <input type="text" class="form-control bg-light" id="dealership_consumption_tax_4"
                                name="dealership_consumption_tax_4" value="{{ $reading->dealership_consumption_tax_4 }}"
                                disabled>
                        </div>

                        <div class="col-6 form-group pl-2">
                            <label for="dealership_cost_tax_5">Custo da 5ª Faixa de Consumo</label>
                            <input type="text" class="form-control bg-light" id="dealership_cost_tax_5"
                                name="dealership_cost_tax_5" value="{{ $reading->dealership_cost_tax_5 }}" disabled>
                        </div>
                    @endif
                    @if ($reading->consumption_ranges > 5)
                        <div class="col-6 form-group pr-2">
                            <label for="dealership_consumption_tax_5">Valor limite da 5ª Faixa de Consumo
                                em
                                m<sup>3</sup></label>
                            <input type="text" class="form-control bg-light" id="dealership_consumption_tax_5"
                                name="dealership_consumption_tax_5" value="{{ $reading->dealership_consumption_tax_5 }}"
                                disabled>
                        </div>

                        <div class="col-6 form-group pl-2">
                            <label for="dealership_cost_tax_6">Custo da 6ª Faixa de Consumo</label>
                            <input type="text" class="form-control bg-light" id="dealership_cost_tax_6"
                                name="dealership_cost_tax_6" value="{{ $reading->dealership_cost_tax_6 }}" disabled>
                        </div>
                    @endif
                </div>

                <div class="d-flex flex-wrap justify-content-start">
                    <div class="col-4 form-group px-2">
                        <label for="consumption_calculation">Tipo de Cálculo de Consumo das
                            unidades</label>
                        <input type="text" class="form-control bg-light" id="consumption_calculation"
                            name="consumption_calculation" value="{{ $reading->consumption_calculation }}" disabled>
                    </div>

                    <div class="col-4 form-group px-2">
                        <label for="type_minimum_value">Tipo de Mínimo</label>
                        <input type="text" class="form-control bg-light" id="type_minimum_value"
                            name="type_minimum_value" value="{{ $reading->type_minimum_value }}" disabled>
                    </div>

                    <div class="col-4 form-group pl-2">
                        <label for="minimum_value">Valor Mínimo de Consumo</label>
                        <input type="text" class="form-control bg-light" id="minimum_value" name="minimum_value"
                            value="{{ $reading->minimum_value }}" disabled>
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-6 form-group pr-2">
                        <label for="fare_type">Tipo de Tarifa</label>
                        <input type="text" class="form-control bg-light" id="fare_type" name="fare_type"
                            value="{{ $reading->fare_type }}" disabled>
                    </div>

                    <div class="col-6 form-group pl-2">
                        <label for="common_area">Tipo de Rateio da Área Comum</label>
                        <input type="text" class="form-control bg-light" id="common_area" name="common_area"
                            value="{{ $reading->common_area }}" disabled>
                    </div>

                </div>




                <div class="d-flex flex-wrap justify-content-between">
                    <div class="col-4 form-group pr-2">
                        <label for="dealership_consumption">Consumo do Condomínio em m<sup>3</sup></label>
                        <input type="text" class="form-control bg-light" id="dealership_consumption"
                            name="dealership_consumption" value="{{ $reading->dealership_consumption }}" disabled>
                    </div>
                    <div class="col-4 form-group px-2">
                        <label for="dealership_cost">Consumo do Condomínio em Reais</label>
                        <input type="text" class="form-control bg-light" id="dealership_cost" name="dealership_cost"
                            value="{{ $reading->dealership_cost }}" disabled>
                    </div>
                    <div class="col-4 form-group pl-2">
                        <label for="diff_consumption">Área Comum em m<sup>3</sup></label>
                        <input type="text" class="form-control bg-light" id="diff_consumption"
                            name="diff_consumption" value="{{ $reading->diff_consumption }}" disabled>
                    </div>
                </div>

                {{-- Kite Car --}}
                @if ($reading->kite_car == 'Sim')
                    <div class="d-flex flex-wrap justify-content-start">

                        <div class="col-2 form-group pr-2">
                            <label for="kite_car">Carro Pipa</label>
                            <input type="text" class="form-control bg-light" id="kite_car" name="kite_car" disabled
                                value="{{ $reading->kite_car }}" disabled>
                        </div>

                        <div class="col-2 form-group px-2">
                            <label for="dealership_consumption">m<sup>3</sup> recebidos</label>
                            <input type="text" class="form-control bg-light" id="kite_car_consumption"
                                placeholder="Quantidade de m³" name="kite_car_consumption"
                                value="{{ $reading->kite_car_consumption }}" disabled>
                        </div>

                        <div class="col-2 form-group px-2">
                            <label for="kite_car_tax">Valor do m<sup>3</sup></label>
                            <input type="text" class="form-control bg-light" id="kite_car_tax"
                                placeholder="Quantidade em Reais" name="kite_car_tax"
                                value="R$ {{ $reading->kite_car_tax }}" disabled>
                        </div>

                        <div class="col-2 form-group px-2">
                            <label for="kite_car_qtd">Qtd Caminhões</label>
                            <input type="text" class="form-control bg-light" id="kite_car_qtd"
                                placeholder="Quantidade" name="kite_car_qtd" value="{{ $reading->kite_car_qtd }}"
                                disabled>
                        </div>

                        <div class="col-2 form-group px-2">
                            <label for="value_per_kite_car">Valor por Caminhão</label>
                            <input type="text" class="form-control bg-light" id="value_per_kite_car"
                                name="value_per_kite_car" disabled value="{{ $reading->value_per_kite_car }}">
                        </div>

                        <div class="col-2 form-group pl-2">
                            <label for="kite_car_total">Valor Total Carro Pipa</label>
                            <input type="text" class="form-control bg-light" id="kite_car_total"
                                name="kite_car_total" disabled value="{{ $reading->kite_car_total }}">
                        </div>

                    </div>
                @endif

                {{-- Totais --}}
                <div class="d-flex flex-wrap justify-content-start">
                    <div class="col-3 form-group pr-2">
                        <label for="monthly_consumption">Consumo Unidades em m<sup>3</sup></label>
                        <input type="text" class="form-control bg-light" id="monthly_consumption"
                            name="monthly_consumption" disabled value="{{ $reading->monthly_consumption }}">
                    </div>

                    <div class="col-3 form-group px-2">
                        <label for="monthly_consumption">Conta Total</label>
                        <input type="text" class="form-control bg-light" id="monthly_consumption"
                            name="monthly_consumption" disabled value="{{ $reading->total_value }}">
                    </div>

                    <div class="col-3 form-group px-2">
                        <label for="consumption_value">Valor do Consumo</label>
                        <input type="text" class="form-control bg-light" id="consumption_value"
                            name="consumption_value" disabled value="{{ $reading->consumption_value }}">
                    </div>

                    <div class="col-3 form-group pl-2">
                        <label for="sewage_value">Valor do Esgoto</label>
                        <input type="text" class="form-control bg-light" id="sewage_value" name="sewage_value"
                            disabled value="{{ $reading->sewage_value }}">
                    </div>
                </div>

                <div class="d-flex flex-wrap justify-content-start">
                    @if ($reading->kite_car == 'Sim')
                        <div class="col-4 form-group pr-2">
                            <label for="kite_car_consumed_units">Consumo Carro Pipa das Unidades em
                                m<sup>3</sup></label>
                            <input type="text" class="form-control bg-light" id="kite_car_consumed_units"
                                name="kite_car_consumed_units" disabled value="{{ $reading->kite_car_consumed_units }}">
                        </div>

                        <div class="col-4 form-group px-2">
                            <label for="kite_car_cost_units">Valor Carro Pipa das Unidades</label>
                            <input type="text" class="form-control bg-light" id="kite_car_cost_units"
                                name="kite_car_cost_units" disabled value="{{ $reading->kite_car_cost_units }}">
                        </div>

                        <div class="col-4 form-group pl-2">
                            <label for="diff_cost">Área Comum</label>
                            <input type="text" class="form-control bg-light" id="diff_cost" name="diff_cost" disabled
                                value="{{ $reading->diff_cost }}">
                        </div>
                    @else
                        <div class="col-4 form-group pr-2">
                            <label for="diff_cost">Área Comum</label>
                            <input type="text" class="form-control bg-light" id="diff_cost" name="diff_cost" disabled
                                value="{{ $reading->diff_cost }}">
                        </div>
                    @endif
                </div>

                <div class="d-flex flex-wrap justify-content-start">
                    <div class="col-4 form-group pr-2">
                        <label for="diff_consumption">Diferença Real e Concessionária em
                            m<sup>3</sup></label>
                        <input type="text" class="form-control bg-light" id="diff_consumption"
                            name="diff_consumption" disabled value="{{ $reading->diff_consumption }}">
                    </div>

                    <div class="col-4 form-group px-2">
                        <label for="previous_billed_consumption">Consumo Faturado Mês Anterior em
                            m<sup>3</sup></label>
                        <input type="text" class="form-control bg-light" id="previous_billed_consumption"
                            name="previous_billed_consumption" disabled
                            value="{{ $reading->previous_billed_consumption }}">
                    </div>

                    <div class="col-4 form-group pl-2">
                        <label for="previous_monthly_consumption">Consumo Real Anterior em
                            m<sup>3</sup></label>
                        <input type="text" class="form-control bg-light" id="previous_monthly_consumption"
                            name="previous_monthly_consumption" disabled
                            value="{{ $reading->previous_monthly_consumption }}">
                    </div>

                </div>


                <div class="d-flex flex-wrap justify-content-start">
                    <div class="col-3 form-group pr-2">
                        <label for="consumption_tax_1">Consumo na 1ª Faixa</label>
                        <input type="text" class="form-control bg-light" id="consumption_tax_1"
                            name="consumption_tax_1" disabled value="{{ $reading->consumption_tax_1 }}">
                    </div>
                    <div class="col-3 form-group px-2">
                        <label for="total_cost_tax_1">Custo total 1ª Faixa</label>
                        <input type="text" class="form-control bg-light" id="total_cost_tax_1"
                            name="total_cost_tax_1" disabled value="{{ $reading->total_cost_tax_1 }}">
                    </div>
                    @if ($reading->consumption_ranges > 1)
                        <div class="col-3 form-group px-2">
                            <label for="consumption_tax_2">Consumo na 2ª Faixa</label>
                            <input type="text" class="form-control bg-light" id="consumption_tax_2"
                                name="consumption_tax_2" disabled value="{{ $reading->consumption_tax_2 }}">
                        </div>
                        <div class="col-3 form-group pl-2">
                            <label for="total_cost_tax_2">Custo total 2ª Faixa</label>
                            <input type="text" class="form-control bg-light" id="total_cost_tax_2"
                                name="total_cost_tax_2" disabled value="{{ $reading->total_cost_tax_2 }}">
                        </div>
                    @endif

                    @if ($reading->consumption_ranges > 2)
                        <div class="col-3 form-group pr-2">
                            <label for="consumption_tax_3">Consumo na 3ª Faixa</label>
                            <input type="text" class="form-control bg-light" id="consumption_tax_3"
                                name="consumption_tax_3" disabled value="{{ $reading->consumption_tax_3 }}">
                        </div>
                        <div class="col-3 form-group px-2">
                            <label for="total_cost_tax_3">Custo total 3ª Faixa</label>
                            <input type="text" class="form-control bg-light" id="total_cost_tax_3"
                                name="total_cost_tax_3" disabled value="{{ $reading->total_cost_tax_3 }}">
                        </div>
                    @endif

                    @if ($reading->consumption_ranges > 3)
                        <div class="col-3 form-group px-2">
                            <label for="consumption_tax_4">Consumo na 4ª Faixa</label>
                            <input type="text" class="form-control bg-light" id="consumption_tax_4"
                                name="consumption_tax_4" disabled value="{{ $reading->consumption_tax_4 }}">
                        </div>
                        <div class="col-3 form-group pl-2">
                            <label for="total_cost_tax_4">Custo total 4ª Faixa</label>
                            <input type="text" class="form-control bg-light" id="total_cost_tax_4"
                                name="total_cost_tax_4" disabled value="{{ $reading->total_cost_tax_4 }}">
                        </div>
                    @endif

                    @if ($reading->consumption_ranges > 4)
                        <div class="col-3 form-group pr-2">
                            <label for="consumption_tax_5">Consumo na 5ª Faixa</label>
                            <input type="text" class="form-control bg-light" id="consumption_tax_5"
                                name="consumption_tax_5" disabled value="{{ $reading->consumption_tax_5 }}">
                        </div>
                        <div class="col-3 form-group px-2">
                            <label for="total_cost_tax_5">Custo total 5ª Faixa</label>
                            <input type="text" class="form-control bg-light" id="total_cost_tax_5"
                                name="total_cost_tax_5" disabled value="{{ $reading->total_cost_tax_5 }}">
                        </div>
                    @endif

                    @if ($reading->consumption_ranges > 5)
                        <div class="col-3 form-group px-2">
                            <label for="consumption_tax_6">Consumo na 6ª Faixa</label>
                            <input type="text" class="form-control bg-light" id="consumption_tax_6"
                                name="consumption_tax_6" disabled value="{{ $reading->consumption_tax_6 }}">
                        </div>
                        <div class="col-3 form-group pl-2">
                            <label for="total_cost_tax_6">Custo total 6ª Faixa</label>
                            <input type="text" class="form-control bg-light" id="total_cost_tax_6"
                                name="total_cost_tax_6" disabled value="{{ $reading->total_cost_tax_6 }}">
                        </div>
                    @endif

                </div>

                <div class="d-flex flex-wrap justify-content-start">
                    <div class="col-4 form-group pr-2">
                        <label for="units_inside_tax_1">Unidades dentro da 1ª Faixa</label>
                        <input type="text" class="form-control bg-light" id="units_inside_tax_1"
                            name="units_inside_tax_1" disabled value="{{ $reading->units_inside_tax_1 }}">
                    </div>
                    @if ($reading->consumption_ranges > 1)
                        <div class="col-4 form-group px-2">
                            <label for="units_inside_tax_2">Unidades dentro da 2ª Faixa</label>
                            <input type="text" class="form-control bg-light" id="units_inside_tax_2"
                                name="units_inside_tax_2" disabled value="{{ $reading->units_inside_tax_2 }}">
                        </div>
                    @endif
                    @if ($reading->consumption_ranges > 2)
                        <div class="col-4 form-group pl-2">
                            <label for="units_inside_tax_3">Unidades dentro da 3ª Faixa</label>
                            <input type="text" class="form-control bg-light" id="units_inside_tax_3"
                                name="units_inside_tax_3" disabled value="{{ $reading->units_inside_tax_3 }}">
                        </div>
                    @endif
                    @if ($reading->consumption_ranges > 3)
                        <div class="col-4 form-group pr-2">
                            <label for="units_inside_tax_4">Unidades dentro da 4ª Faixa</label>
                            <input type="text" class="form-control bg-light" id="units_inside_tax_4"
                                name="units_inside_tax_4" disabled value="{{ $reading->units_inside_tax_4 }}">
                        </div>
                    @endif
                    @if ($reading->consumption_ranges > 4)
                        <div class="col-4 form-group px-2">
                            <label for="units_inside_tax_5">Unidades dentro da 5ª Faixa</label>
                            <input type="text" class="form-control bg-light" id="units_inside_tax_5"
                                name="units_inside_tax_5" disabled value="{{ $reading->units_inside_tax_5 }}">
                        </div>
                    @endif
                    @if ($reading->consumption_ranges > 5)
                        <div class="col-4 form-group pl-2">
                            <label for="units_inside_tax_6">Unidades dentro da 6ª Faixa</label>
                            <input type="text" class="form-control bg-light" id="units_inside_tax_6"
                                name="units_inside_tax_6" disabled value="{{ $reading->units_inside_tax_6 }}">
                        </div>
                    @endif
                </div>

                <div class="border-bottom mb-4"></div>

                @if ($reading->apartmentReports->count() > 0)
                    <div class="d-flex flex-wrap justify-content-between">
                        @if ($reading->kite_car == 'Sim')
                            @php
                                $heads = ['Bl', 'Ap', 'Consumo Unidades (m³)', 'Valor de Consumo', 'Valor de Esgoto', 'Consumo Carro Pipa (m³)', 'Custo Carro Pipa', 'Ajuste de Área Comum', 'Total da Unidade'];

                                foreach ($reading->apartmentReports as $report) {
                                    $list[] = [$report->apartment->block_name, $report->apartment->name, $report->consumed, $report->consumed_cost, $report->sewage_cost, $report->kite_car_consumed, $report->kite_car_cost, $report->partial, $report->total_unit];
                                }

                                $config = [
                                    'data' => $list,
                                    'order' => [[0, 'asc']],
                                    'columns' => [null, null, null, null, null, null, null, null, null],
                                    'language' => ['url' => asset('vendor/datatables/js/pt-BR.json')],
                                    'paging' => false,
                                    'searching' => false,
                                    'info' => false,
                                ];

                            @endphp
                        @else
                            @php
                                $heads = ['Bl', 'Ap', 'Consumo Unidades (m³)', 'Valor de Consumo', 'Valor de Esgoto', 'Ajuste de Área Comum', 'Total da Unidade'];

                                $list = [];

                                foreach ($reading->apartmentReports as $report) {
                                    $list[] = [$report->apartment->block_name, $report->apartment->name, $report->consumed, $report->consumed_cost, $report->sewage_cost, $report->partial, $report->total_unit];
                                }

                                $config = [
                                    'data' => $list,
                                    'order' => [[0, 'asc']],
                                    'columns' => [null, null, null, null, null, null, null],
                                    'language' => ['url' => asset('vendor/datatables/js/pt-BR.json')],
                                    'paging' => false,
                                    'searching' => false,
                                    'info' => false,
                                ];

                            @endphp
                        @endif
                        <x-adminlte-datatable id="table1" :heads="$heads" :heads="$heads" :config="$config"
                            striped />
                    </div>
                @endif
            </div>
        </form>

    </div>
@endsection

@section('custom_js')
    <script>
        window.onload = function() {
            $(".main-footer").remove();
            setTimeout(function() {
                window.print();
                window.close();
            }, 1000);
        }
    </script>
@endsection
