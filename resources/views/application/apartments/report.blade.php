@extends('adminlte::page')

@section('title', '- Dados de Consumo')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-chart-line"></i> Dados de Consumo</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('app.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('app.resident.readings') }}">Leituras</a>
                        </li>
                        <li class="breadcrumb-item active">Dados de Consumo</li>
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
                                        <label for="description">Imóvel</label>
                                        <input type="text" class="form-control bg-light" id="description" name="description"
                                            value="Condomínio: {{ $apartment->block->complex['alias_name'] }} - Bloco: {{ $apartment->block['name'] }} - Apartamento: {{ $apartment->name }}"
                                            disabled>
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="dealership">Concessionária</label>
                                        <input type="text" class="form-control bg-light" id="dealership" name="dealership"
                                            value="{{ $reading->dealership['name'] }}" disabled>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-3 form-group px-0 pr-md-2">
                                        <label for="month_ref">Mês de Referência</label>
                                        <input type="text" class="form-control bg-light" id="month_ref" name="month_ref"
                                            value="{{ $reading->month_ref }}" disabled>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="year_ref">Ano de Referência</label>
                                        <input type="text" class="form-control bg-light" id="year_ref" name="year_ref"
                                            value="{{ $reading->year_ref }}" disabled>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="reading_date">Data da Leitura</label>
                                        <input type="text" class="form-control bg-light" id="reading_date"
                                            name="reading_date" value="{{ $reading->reading_date }}" disabled>
                                    </div>
                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="reading_date_next">Data da Próxima Leitura</label>
                                        <input type="text" class="form-control bg-light" id="reading_date_next"
                                            name="reading_date_next" value="{{ $reading->reading_date_next }}" disabled>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-3 form-group px-0 pr-md-2">
                                        <label for="dealership_consumption_tax_1">Limite da 1ª Faixa em
                                            m<sup>3</sup></label>
                                        <input type="text" class="form-control bg-light" id="dealership_consumption_tax_1"
                                            name="dealership_consumption_tax_1"
                                            value="{{ $reading->dealership_consumption_tax_1 }}" disabled>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                        <label for="dealership_cost_tax_1">Custo da 1ª Faixa de Consumo</label>
                                        <input type="text" class="form-control bg-light" id="dealership_cost_tax_1"
                                            placeholder="Valor em reais da 1ª Faixa de Consumo pela concessionária"
                                            name="dealership_cost_tax_1" value="{{ $reading->dealership_cost_tax_1 }}"
                                            disabled>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="dealership_consumption_tax_2">Base da 2ª Faixa em
                                            m<sup>3</sup></label>
                                        <input type="text" class="form-control bg-light" id="dealership_consumption_tax_2"
                                            name="dealership_consumption_tax_2"
                                            value="{{ $reading->dealership_consumption_tax_2 }}" disabled>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="dealership_cost_tax_2">Custo da 2ª Faixa de Consumo</label>
                                        <input type="text" class="form-control bg-light" id="dealership_cost_tax_2"
                                            name="dealership_cost_tax_2" value="{{ $reading->dealership_cost_tax_2 }}"
                                            disabled>
                                    </div>
                                </div>

                                <h4 class="h5 text-muted mt-3">Dados do Condomínio</h4>
                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="dealership_consumption">Consumo do Condomínio em m<sup>3</sup></label>
                                        <input type="text" class="form-control bg-light" id="dealership_consumption"
                                            name="dealership_consumption" value="{{ $reading->dealership_consumption }}"
                                            disabled>
                                    </div>
                                    <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                        <label for="dealership_cost">Consumo do Condomínio em Reais</label>
                                        <input type="text" class="form-control bg-light" id="dealership_cost"
                                            name="dealership_cost" value="{{ $reading->dealership_cost }}" disabled>
                                    </div>
                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="diff_consumption">Área Comum em m<sup>3</sup></label>
                                        <input type="text" class="form-control bg-light" id="diff_consumption"
                                            name="diff_consumption" value="{{ $reading->diff_consumption }}" disabled>
                                    </div>
                                </div>
                                @php $appData = $reading->getApartmentReport($apartment) @endphp
                                <h4 class="h5 text-muted mt-3">Dados da Unidade</h4>
                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-3 form-group px-0 pr-md-2">
                                        <label for="total_consumed">Consumo da Unidade em m<sup>3</sup></label>
                                        <input type="text" class="form-control bg-light" id="total_consumed"
                                            name="total_consumed"
                                            value="{{ number_format($appData['totalConsumed'], 3, ',', '.') }}" disabled>
                                    </div>
                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="total">Valor Total</label>
                                        <input type="text" class="form-control bg-light" id="total" name="total"
                                            value="{{ $appData['total'] }}" disabled>
                                    </div>
                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="partial">Rateio Proporcional</label>
                                        <input type="text" class="form-control bg-light" id="partial" name="partial"
                                            value="{{ $appData['partial'] }}" disabled>
                                    </div>
                                    <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                        <label for="total_unit">Valor Total da Unidade</label>
                                        <input type="text" class="form-control bg-light" id="total_unit" name="total_unit"
                                            value="{{ $appData['total_unit'] }}" disabled>
                                    </div>
                                </div>

                                <div class="border-bottom mb-4"></div>
                                <h4 class="h5 text-muted mt-3">Detalhes por Medidor</h4>
                                <div class="d-flex flex-wrap justify-content-between">
                                    @foreach ($appData['readings'] as $meterReading)
                                        <div class="col-12 px-0">
                                            <h5>Medidor {{ $meterReading->meter['register'] }}
                                                @if ($meterReading->meter['location'])
                                                    <span
                                                        class="ml-2 badge badge-secondary">{{ $meterReading->meter['location'] }}</span>
                                                @endif
                                            </h5>
                                        </div>

                                        <div
                                            class="col-12 col-md-3 form-group px-0 pr-md-2 d-flex flex-wrap justify-content-between">
                                            @if ($meterReading->cover_base64)
                                                <div class='col-12 align-self-center d-flex justify-content-center px-0'>
                                                    <img src="{{ url('storage/readings/' . $meterReading->cover_base64) }}"
                                                        alt="Imagem da leitura"
                                                        style="max-width: 100%; object-fit: cover; width: 100%; aspect-ratio: 1;"
                                                        class="img-thumbnail d-block">
                                                </div>
                                            @elseif ($meterReading->cover)
                                                <div class='col-12 align-self-center d-flex justify-content-center px-0'>
                                                    <img src="{{ url('storage/readings/' . $meterReading->cover) }}"
                                                        alt="Imagem da leitura"
                                                        style="max-width: 100%; object-fit: cover; width: 100%; aspect-ratio: 1;"
                                                        class="img-thumbnail d-block">
                                                </div>
                                            @elseif ($meterReading->cover)
                                                <div class='col-12 align-self-center d-flex justify-content-center px-0'>
                                                    <img src="{{ url('storage/readings/' . $meterReading->cover) }}"
                                                        alt="Imagem da leitura"
                                                        style="max-width: 100%; object-fit: cover; width: 100%; aspect-ratio: 1;"
                                                        class="img-thumbnail d-block">
                                                </div>
                                            @elseif ($meterReading->url_cover)
                                                <div class='col-12 align-self-center d-flex justify-content-center px-0'>
                                                    <img src="{{ $meterReading->url_cover }}" alt="Imagem da leitura"
                                                        style="max-width: 100%; object-fit: cover; width: 100%; aspect-ratio: 1;"
                                                        class="img-thumbnail d-block">
                                                </div>
                                            @else
                                                <div class='col-12 align-self-center d-flex justify-content-center px-0'>
                                                    <img src="{{ asset('img/no-image.png') }}"
                                                        alt="Sem Imagem de Leitura"
                                                        style="max-width: 100%; object-fit: cover; width: 100%; aspect-ratio: 1;"
                                                        class="img-thumbnail d-block">
                                                </div>
                                            @endif
                                        </div>
                                        <div
                                            class="col-12 col-md-9 form-group px-0 pl-md-2 d-flex flex-wrap justify-content-between align-content-center">

                                            <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                                <label for="reading">Valor da Leitura em m<sup>3</sup></label>
                                                <input type="text" class="form-control bg-light" id="reading" name="reading"
                                                    value="{{ number_format(str_replace(',', '.', str_replace('.', '', $meterReading->reading)), 3, ',', '.') }}"
                                                    disabled>
                                            </div>

                                            <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                                <label for="volume_consumed">Consumo em m<sup>3</sup></label>
                                                <input type="text" class="form-control bg-light" id="volume_consumed"
                                                    name="volume_consumed"
                                                    value="{{ number_format(str_replace(',', '.', str_replace('.', '', $meterReading->volume_consumed)), 3, ',', '.') }}"
                                                    disabled>
                                            </div>

                                            <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                                <label for="previous_volume_consumed">Consumo Anterior em
                                                    m<sup>3</sup></label>
                                                <input type="text" class="form-control bg-light"
                                                    id="previous_volume_consumed" name="previous_volume_consumed"
                                                    value="{{ $meterReading->previous_volume_consumed != 'Inexistente' ? number_format(str_replace(',', '.', str_replace('.', '', $meterReading->previous_volume_consumed)), 3, ',', '.') : 'Inexistente' }}"
                                                    disabled>
                                            </div>

                                            <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                                <label for="comparative_percentage">Porcentagem Comparativa</label>
                                                <input type="text"
                                                    class="form-control {{ str_contains($meterReading->comparative_percentage, '-') ? 'bg-success' : ($meterReading->comparative_percentage == 'Inexistente' ? 'bg-light' : 'bg-warning') }}"
                                                    id="comparative_percentage" name="comparative_percentage"
                                                    value="{{ $meterReading->comparative_percentage }}" disabled>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="card-footer">
                                <a href="{{ route('app.resident.readings.apartment.pdf', ['reading' => $reading->id, 'apartment' => $apartment->id]) }}"
                                    target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Imprimir</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
