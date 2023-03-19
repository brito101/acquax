@extends('adminlte::page')
@section('plugins.select2', true)

@section('title', '- Cadastro de Relatório')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-list-ul"></i> Novo Relatório</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.reports.index') }}">Relatórios</a>
                        </li>
                        <li class="breadcrumb-item active">Novo Relatório</li>
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
                            <h3 class="card-title">Dados Cadastrais do Relatório</h3>
                        </div>


                        <form method="POST" action="{{ route('admin.reports.store') }}">
                            @csrf
                            <input type="hidden" name="apartment_id" value="">
                            <input type="hidden" name="block_id" value="">
                            <div class="card-body">
                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2 mb-0">
                                        <label for="dealership_reading_id">Conta de Condomínio</label>
                                        <x-adminlte-select2 name="dealership_reading_id">
                                            @foreach ($dealershipReadings as $dealershipReading)
                                                <option
                                                    {{ old('dealership_reading_id ') == $dealershipReading->id ? 'selected' : '' }}
                                                    value="{{ $dealershipReading->id }}">
                                                    {{ $dealershipReading->complex->alias_name . ' - ' . $dealershipReading->month_ref . '/' . $dealershipReading->year_ref }}
                                                </option>
                                            @endforeach
                                        </x-adminlte-select2>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="block">Bloco</label>
                                        <input type="text" class="form-control" id="block"
                                            placeholder="Nome do bloco" name="block" value="{{ old('block') }}" required>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                        <label for="apartment">Apartamento</label>
                                        <input type="text" class="form-control" id="apartment"
                                            placeholder="Nome do apartamento" name="apartment"
                                            value="{{ old('apartment') }}" required>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <h4 class="text-muted text-center py-2">Dados de Água e Esgoto</h4>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="consumed">Consumo em m<sup>3</sup></label>
                                        <input type="text" class="form-control" id="consumed"
                                            placeholder="Valor em metros cúbicos" name="consumed"
                                            value="{{ old('consumed') }}" required>
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                        <label for="consumed_cost">Valor de Consumo</label>
                                        <input type="text" class="form-control money_format_3" id="consumed_cost"
                                            placeholder="Custo em reais" name="consumed_cost"
                                            value="{{ old('consumed_cost') }}" required>
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 pl-md-2">
                                        <label for="sewage_cost">Valor de Esgoto</label>
                                        <input type="text" class="form-control money_format_3" id="sewage_cost"
                                            placeholder="Custo em reais" name="sewage_cost"
                                            value="{{ old('sewage_cost') }}" required>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="kite_car_consumed">Consumo Carro Pipa em m<sup>3</sup></label>
                                        <input type="text" class="form-control" id="kite_car_consumed"
                                            placeholder="Valor em metros cúbicos" name="kite_car_consumed"
                                            value="{{ old('kite_car_consumed') }}">
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                        <label for="kite_car_cost">Custo Carro Pipa</label>
                                        <input type="text" class="form-control money_format_3" id="kite_car_cost"
                                            placeholder="Custo em reais" name="kite_car_cost"
                                            value="{{ old('kite_car_cost') }}">
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 pl-md-2">
                                        <label for="partial">Rateio Proporcional</label>
                                        <input type="text" class="form-control money_format_3" id="partial"
                                            placeholder="Custo em reais" name="partial" value="{{ old('partial') }}">
                                    </div>

                                </div>

                                <div class="d-flex flex-wrap justify-content-start">

                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="partial">Consumo Total da Unidade em m<sup>3</sup></label>
                                        <input type="text" class="form-control" id="partial"
                                            placeholder="Valor em metros cúbicos" name="total_consumed"
                                            value="{{ old('total_consumed') }}" required>
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                        <label for="total_unit">Valor Total da Unidade</label>
                                        <input type="text" class="form-control money_format_3" id="total_unit"
                                            placeholder="Custo em reais" name="total_unit"
                                            value="{{ old('total_unit') }}" required>
                                    </div>

                                </div>

                                <div class="col-12">
                                    <h4 class="text-muted text-center py-2">Dados de Gás</h4>
                                </div>

                                <div class="d-flex flex-wrap justify-content-start">

                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="consumption_gas_value">Consumo de Gás em m<sup>3</sup></label>
                                        <input type="text" class="form-control" id="consumption_gas_value"
                                            placeholder="Valor em metros cúbicos" name="consumption_gas_value"
                                            value="{{ old('consumption_gas_value') }}">
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                        <label for="total_gas_value">Valor Total do Gás</label>
                                        <input type="text" class="form-control money_format_2" id="total_gas_value"
                                            placeholder="Custo em reais" name="total_gas_value"
                                            value="{{ old('total_gas_value') }}">
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
