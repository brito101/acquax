@extends('adminlte::page')
@section('plugins.select2', true)
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)

@section('title', '- Edição de Consumo de Água do Condomínio')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-chart-bar"></i> Editar Consumo de Água</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.dealerships-readings.index') }}">Consumo de Água
                                dos
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
                            <h3 class="card-title">Dados Cadastrais de Consumo de Água</h3>
                            <small class="float-right text-black-50">Criado por {{ $reading->user->name }} em
                                {{ date('d/m/Y H:i', strtotime($reading->created_at)) }}</small>
                        </div>


                        <form method="POST"
                            action="{{ route('admin.dealerships-readings.update', ['dealerships_reading' => $reading->id]) }}">
                            @method('PUT')
                            @csrf
                            <input type="hidden" value="{{ $reading->id }}">
                            <input type="hidden" name="average" value="{{ $reading->average }}">
                            <div class="card-body">

                                <div class="d-flex flex-wrap justify-content-start">
                                    <div class="col-12 col-md-3 form-group px-0 pr-md-2 mb-0">
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

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2 mb-0">
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

                                    <div class="col-12 col-md-3 form-group px-0 pl-md-2 mb-0">
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
                                            value="{{ old('reading_date_next') ?? $reading->reading_date_next }}" required>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="total_days">Total de Dias</label>
                                        <input type="text" class="form-control" id="total_days"
                                            placeholder="Total de dias computados" name="total_days"
                                            value="{{ old('total_days') ?? $reading->total_days }}" required>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                        <label for="billed_consumption">Consumo Faturado em m<sup>3</sup></label>
                                        <input type="text" class="form-control" id="billed_consumption"
                                            placeholder="Consumo Faturado Mês Atual" name="billed_consumption"
                                            value="{{ old('billed_consumption') ?? $reading->billed_consumption }}"
                                            required>
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="dealership_consumption">Consumo da Concessionária em
                                            m<sup>3</sup></label>
                                        <input type="text" class="form-control" id="dealership_consumption"
                                            placeholder="Consumo medido pela concessionária" name="dealership_consumption"
                                            value="{{ old('dealership_consumption') ?? $reading->dealership_consumption }}"
                                            required>
                                    </div>
                                    <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                        <label for="dealership_cost">Custo da Concessionária em Reais</label>
                                        <input type="text" class="form-control money_format_2" id="dealership_cost"
                                            placeholder="Custo total do medido pela concessionária" name="dealership_cost"
                                            value="{{ old('dealership_cost') ?? $reading->dealership_cost }}" required>
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 pl-md-2">
                                        <label for="monthly_consumption">Consumo Unidades em m<sup>3</sup></label>
                                        <input type="text" class="form-control" id="monthly_consumption"
                                            name="monthly_consumption"
                                            value="{{ old('monthly_consumption') ?? $reading->monthly_consumption }}"
                                            placeholder="Consumo total das unidades" required>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 pr-md-2">
                                        <label for="total_value">Conta Total</label>
                                        <input type="text" class="form-control money_format_2" id="total_value"
                                            name="total_value" value="{{ old('total_value') ?? $reading->total_value }}">
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="consumption_value">Valor do Consumo</label>
                                        <input type="text" class="form-control money_format_2" id="consumption_value"
                                            name="consumption_value"
                                            value="{{ old('consumption_value') ?? $reading->consumption_value }}">
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="sewage_value">Valor do Esgoto</label>
                                        <input type="text" class="form-control money_format_2" id="sewage_value"
                                            name="sewage_value"
                                            value="{{ old('sewage_value') ?? $reading->sewage_value }}">
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                        <label for="diff_cost">Área Comum</label>
                                        <input type="text" class="form-control money_format_2" id="diff_cost"
                                            name="diff_cost" value="{{ old('diff_cost') ?? $reading->diff_cost }}">
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
                                        <input type="text" class="form-control money_format_3" id="kite_car_tax"
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
                                        <input type="text" class="form-control money_format_3" id="value_per_kite_car"
                                            name="value_per_kite_car"
                                            value="{{ old('value_per_kite_car') ?? $reading->value_per_kite_car }}">
                                    </div>

                                    <div class="col-12 col-md-2 form-group px-0 pl-md-2 kite_car">
                                        <label for="kite_car_total">Valor Total Carro Pipa</label>
                                        <input type="text" class="form-control money_format_3" id="kite_car_total"
                                            name="kite_car_total"
                                            value="{{ old('kite_car_total') ?? $reading->kite_car_total }}">
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2 kite_car">
                                        <label for="kite_car_consumed_units">Consumo Carro Pipa das Unidades em
                                            m<sup>3</sup></label>
                                        <input type="text" class="form-control" id="kite_car_consumed_units"
                                            name="kite_car_consumed_units" placeholder="total consumido pelas unidades"
                                            value="{{ old('kite_car_consumed_units') ?? $reading->kite_car_consumed_units }}">
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 px-md-2 kite_car">
                                        <label for="kite_car_cost_units">Valor Carro Pipa das Unidades</label>
                                        <input type="text" class="form-control money_format_2"
                                            id="kite_car_cost_units" name="kite_car_cost_units"
                                            value="{{ old('kite_car_cost_units') ?? $reading->kite_car_cost_units }}">
                                    </div>

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
                                                'lengthMenu' => [[10, 50, 100, 500, 1000, -1], [10, 50, 100, 500, 1000, 'Tudo']],
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
