@extends('adminlte::page')

@section('title', '- Dados de Leitura')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-tachometer-alt"></i> Dados de Leitura</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('app.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('app.meter.readings.index') }}">Relatórios de
                                Medidores</a>
                        </li>
                        <li class="breadcrumb-item active">Dados de Leitura</li>
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
                            <h3 class="card-title">Dados Cadastrais da Leitura #{{ $reading->id }}</h3>
                        </div>


                        <form>
                            <div class="card-body d-flex flex-wrap">
                                <div class="d-flex flex-wrap justify-content-between col-12">

                                    <div class="col-12 col-md-3 form-group px-0 pr-md-2">
                                        <label for="meter_id">Medidor</label>
                                        <input type="text" class="form-control bg-light" id="meter_id" name="meter_id"
                                            value="{{ $reading->meter['register'] }}" disabled>
                                    </div>

                                    <div class="col-12 col-md-2 form-group px-0 px-md-2">
                                        <label for="type">Tipo</label>
                                        <input type="text" class="form-control bg-light" id="type" name="type"
                                            value="{{ $reading->meter->typeMeter->name }}" disabled>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="location">Localização</label>
                                        <input type="text" class="form-control bg-light" id="location" name="location"
                                            value="{{ $reading->location ?? 'Não Informada' }}" disabled>
                                    </div>

                                    <div class="col-12 col-md-2 form-group px-0 px-md-2">
                                        <label for="month_ref">Mês</label>
                                        <input type="text" class="form-control bg-light" id="month_ref" name="month_ref"
                                            value="{{ $reading->month_ref }}" disabled>
                                    </div>

                                    <div class="col-12 col-md-2 form-group px-0 pl-md-2">
                                        <label for="year_ref">Ano</label>
                                        <input type="text" class="form-control bg-light" id="year_ref" name="year_ref"
                                            value="{{ $reading->year_ref }}" disabled>
                                    </div>

                                </div>

                                <div class="d-flex flex-wrap justify-content-between col-12">

                                    <div class="col-12 col-md-3 form-group px-0 pr-md-2">
                                        <label for="reading_date">Data da Leitura</label>
                                        <input type="text" class="form-control bg-light" id="reading_date"
                                            name="reading_date" value="{{ $reading->reading_date }}" disabled>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="reading_date_next">Próxima Leitura</label>
                                        <input type="text" class="form-control bg-light" id="reading_date_next"
                                            name="reading_date_next" value="{{ $reading->reading_date_next }}" disabled>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="reading">Leitura em m<sup>3</sup></label>
                                        <input type="text" class="form-control bg-light" id="reading" name="reading"
                                            value="{{ number_format(str_replace(',', '.', str_replace('.', '', $reading->reading)), 3, ',', '.') }}"
                                            disabled>
                                    </div>

                                    <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                        <label for="volume_consumed">Consumo em m<sup>3</sup></label>
                                        <input type="text" class="form-control bg-light" id="volume_consumed"
                                            name="volume_consumed"
                                            value="{{ number_format(str_replace(',', '.', str_replace('.', '', $reading->volume_consumed)), 3, ',', '.') }}"
                                            disabled>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-start col-12 col-md-6">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="previous_volume_consumed">Consumo Anterior em m<sup>3</sup></label>
                                        <input type="text" class="form-control bg-light" id="previous_volume_consumed"
                                            name="previous_volume_consumed"
                                            value="{{ $reading->previous_volume_consumed == 'Inexistente' ? $reading->previous_volume_consumed : number_format(str_replace(',', '.', str_replace('.', '', $reading->previous_volume_consumed)), 3, ',', '.') }}"
                                            disabled>
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 px-md-2">
                                        <label for="comparative_percentage">Porcentagem Comparativa</label>
                                        <input type="text"
                                            class="form-control {{ str_contains($reading->comparative_percentage, '-') ? 'bg-success' : ($reading->comparative_percentage == 'Inexistente' ? 'bg-light' : 'bg-warning') }}"
                                            id="comparative_percentage" name="comparative_percentage"
                                            value="{{ $reading->comparative_percentage }}" disabled>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between col-12 col-md-6 px-0">

                                    <div class="col-12 form-group px-0 pl-md-2 d-flex flex-wrap">
                                        @if ($reading->cover_base64)
                                            <div class='col-12 align-self-center d-flex justify-content-center px-0'>
                                                <img src="{{ url('storage/readings/' . $reading->cover_base64) }}"
                                                    alt="Imagem da leitura"
                                                    style="max-width: 80%; object-fit: cover; width: 80%; aspect-ratio: 1;"
                                                    class="img-thumbnail d-block">
                                            </div>
                                        @elseif ($reading->cover)
                                            <div class='col-12 align-self-center d-flex justify-content-center px-0'>
                                                <img src="{{ url('storage/readings/' . $reading->cover) }}"
                                                    alt="Imagem da leitura"
                                                    style="max-width: 80%; object-fit: cover; width: 80%; aspect-ratio: 1;"
                                                    class="img-thumbnail d-block">
                                            </div>
                                        @elseif ($reading->cover)
                                            <div class='col-12 align-self-center d-flex justify-content-center px-0'>
                                                <img src="{{ url('storage/readings/' . $reading->cover) }}"
                                                    alt="Imagem da leitura"
                                                    style="max-width: 80%; object-fit: cover; width: 80%; aspect-ratio: 1;"
                                                    class="img-thumbnail d-block">
                                            </div>
                                        @elseif ($reading->url_cover)
                                            <div class='col-12 align-self-center d-flex justify-content-center px-0'>
                                                <img src="{{ $reading->url_cover }}" alt="Imagem da leitura"
                                                    style="max-width: 80%; object-fit: cover; width: 80%; aspect-ratio: 1;"
                                                    class="img-thumbnail d-block">
                                            </div>
                                        @else
                                            <div class='col-12 align-self-center d-flex justify-content-center px-0'>
                                                <img src="{{ asset('img/no-image.png') }}" alt="Sem Imagem de Leitura"
                                                    style="max-width: 100%; object-fit: cover; width: 100%; aspect-ratio: 1;"
                                                    class="img-thumbnail d-block">
                                            </div>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
