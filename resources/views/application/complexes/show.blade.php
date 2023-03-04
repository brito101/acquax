@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)

@section('title', '- Consumo de Água do Condomínio')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-chart-bar"></i> Condomínio {{ $complex->alias_name }} - Consumo de Água</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('app.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('app.residences.readings') }}">Relatórios de Consumo de
                                Água</a>
                        </li>
                        <li class="breadcrumb-item active">Consumo de Água do Condomínio</li>
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
                                <div class="d-flex flex-wrap justify-content-start">

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

                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="dealership_consumption">Consumo da Concessionária em
                                            m<sup>3</sup></label>
                                        <input type="text" class="form-control bg-light" id="dealership_consumption"
                                            name="dealership_consumption" value="{{ $reading->dealership_consumption }}"
                                            disabled>
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                        <label for="dealership_cost">Custo da Concessionária em Reais</label>
                                        <input type="text" class="form-control bg-light" id="dealership_cost"
                                            name="dealership_cost" value="{{ $reading->dealership_cost }}" disabled>
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 pl-md-2">
                                        <label for="monthly_consumption">Consumo Unidades em m<sup>3</sup></label>
                                        <input type="text" class="form-control bg-light" id="monthly_consumption"
                                            name="monthly_consumption" disabled
                                            value="{{ $reading->monthly_consumption }}">
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 pr-md-2">
                                        <label for="monthly_consumption">Conta Total</label>
                                        <input type="text" class="form-control bg-light" id="monthly_consumption"
                                            name="monthly_consumption" disabled value="{{ $reading->total_value }}">
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="consumption_value">Valor do Consumo</label>
                                        <input type="text" class="form-control bg-light" id="consumption_value"
                                            name="consumption_value" disabled value="{{ $reading->consumption_value }}">
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="sewage_value">Valor do Esgoto</label>
                                        <input type="text" class="form-control bg-light" id="sewage_value"
                                            name="sewage_value" disabled value="{{ $reading->sewage_value }}">
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                        <label for="diff_consumption">Área Comum em m<sup>3</sup></label>
                                        <input type="text" class="form-control bg-light" id="diff_consumption"
                                            name="diff_consumption" value="{{ $reading->diff_consumption }}" disabled>
                                    </div>
                                </div>

                                {{-- Kite Car --}}
                                @if ($reading->kite_car == 'Sim')
                                    <div class="d-flex flex-wrap justify-content-start">

                                        <div class="col-12 col-md-2 form-group px-0 pr-md-2">
                                            <label for="kite_car">Carro Pipa</label>
                                            <input type="text" class="form-control bg-light" id="kite_car"
                                                name="kite_car" disabled value="{{ $reading->kite_car }}" disabled>
                                        </div>

                                        <div class="col-12 col-md-2 form-group px-0 px-md-2">
                                            <label for="dealership_consumption">m<sup>3</sup> recebidos</label>
                                            <input type="text" class="form-control bg-light" id="kite_car_consumption"
                                                placeholder="Quantidade de m³" name="kite_car_consumption"
                                                value="{{ $reading->kite_car_consumption }}" disabled>
                                        </div>

                                        <div class="col-12 col-md-2 form-group px-0 px-md-2">
                                            <label for="kite_car_tax">Valor do m<sup>3</sup></label>
                                            <input type="text" class="form-control bg-light" id="kite_car_tax"
                                                placeholder="Quantidade em Reais" name="kite_car_tax"
                                                value="R$ {{ $reading->kite_car_tax }}" disabled>
                                        </div>

                                        <div class="col-12 col-md-2 form-group px-0 px-md-2">
                                            <label for="kite_car_qtd">Qtd Caminhões</label>
                                            <input type="text" class="form-control bg-light" id="kite_car_qtd"
                                                placeholder="Quantidade" name="kite_car_qtd"
                                                value="{{ $reading->kite_car_qtd }}" disabled>
                                        </div>

                                        <div class="col-12 col-md-2 form-group px-0 px-md-2">
                                            <label for="value_per_kite_car">Valor por Caminhão</label>
                                            <input type="text" class="form-control bg-light" id="value_per_kite_car"
                                                name="value_per_kite_car" disabled
                                                value="{{ $reading->value_per_kite_car }}">
                                        </div>

                                        <div class="col-12 col-md-2 form-group px-0 pl-md-2">
                                            <label for="kite_car_total">Valor Total Carro Pipa</label>
                                            <input type="text" class="form-control bg-light" id="kite_car_total"
                                                name="kite_car_total" disabled value="{{ $reading->kite_car_total }}">
                                        </div>

                                        <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                            <label for="kite_car_consumed_units">Consumo Carro Pipa das Unidades em
                                                m<sup>3</sup></label>
                                            <input type="text" class="form-control bg-light"
                                                id="kite_car_consumed_units" name="kite_car_consumed_units" disabled
                                                value="{{ $reading->kite_car_consumed_units }}">
                                        </div>

                                        <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                            <label for="kite_car_cost_units">Valor Carro Pipa das Unidades</label>
                                            <input type="text" class="form-control bg-light" id="kite_car_cost_units"
                                                name="kite_car_cost_units" disabled
                                                value="{{ $reading->kite_car_cost_units }}">
                                        </div>
                                    </div>
                                @endif

                                <div class="border-bottom mb-4"></div>

                                @if ($reading->apartmentReports->count() > 0)
                                    <div class="d-flex flex-wrap justify-content-between">
                                        @if ($reading->kite_car == 'Sim')
                                            @php
                                                $heads = ['Bl', 'Ap', 'Consumo Unidades (m³)', 'Valor de Consumo', 'Valor de Esgoto', 'Consumo Carro Pipa (m³)', 'Custo Carro Pipa', 'Ajuste de Área Comum', 'Total da Unidade', ['label' => 'Visualizar', 'no-export' => true, 'width' => 10]];
                                                
                                                $config = [
                                                    'ajax' => url('/app/complex-readings-report-ajax/' . $reading->id),
                                                    'columns' => [['data' => 'block', 'name' => 'block'], ['data' => 'apartment', 'name' => 'apartment'], ['data' => 'consumed', 'name' => 'consumed'], ['data' => 'consumed_cost', 'name' => 'consumed_cost'], ['data' => 'sewage_cost', 'name' => 'sewage_cost'], ['data' => 'kite_car_consumed', 'name' => 'kite_car_consumed'], ['data' => 'kite_car_cost', 'name' => 'kite_car_cost'], ['data' => 'partial', 'name' => 'partial'], ['data' => 'total_unit', 'name' => 'total_unit'], ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false]],
                                                    'language' => ['url' => asset('vendor/datatables/js/pt-BR.json')],
                                                    'autoFill' => true,
                                                    'processing' => true,
                                                    'serverSide' => true,
                                                    'responsive' => true,
                                                    'lengthMenu' => [[10, 50, 100, 500, 1000, -1], [10, 50, 100, 500, 1000, 'Tudo']],
                                                    'order' => [[0, 'asc']],
                                                    'dom' => '<"d-flex flex-wrap col-12 justify-content-between"Bf>rtip',
                                                ];
                                            @endphp
                                        @else
                                            @php
                                                $heads = ['Bl', 'Ap', 'Consumo Unidades (m³)', 'Valor de Consumo', 'Valor de Esgoto', 'Ajuste de Área Comum', 'Total da Unidade', ['label' => 'Visualizar', 'no-export' => true, 'width' => 10]];
                                                
                                                $config = [
                                                    'ajax' => url('/app/complex-readings-report-ajax/' . $reading->id),
                                                    'columns' => [['data' => 'block', 'name' => 'block'], ['data' => 'apartment', 'name' => 'apartment'], ['data' => 'consumed', 'name' => 'consumed'], ['data' => 'consumed_cost', 'name' => 'consumed_cost'], ['data' => 'sewage_cost', 'name' => 'sewage_cost'], ['data' => 'partial', 'name' => 'partial'], ['data' => 'total_unit', 'name' => 'total_unit'], ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false]],
                                                    'language' => ['url' => asset('vendor/datatables/js/pt-BR.json')],
                                                    'autoFill' => true,
                                                    'processing' => true,
                                                    'serverSide' => true,
                                                    'responsive' => true,
                                                    'lengthMenu' => [[10, 50, 100, 500, 1000, -1], [10, 50, 100, 500, 1000, 'Tudo']],
                                                    'order' => [[0, 'asc']],
                                                    'dom' => '<"d-flex flex-wrap col-12 justify-content-between"Bf>rtip',
                                                ];
                                            @endphp
                                        @endif
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
