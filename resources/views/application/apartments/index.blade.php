@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('title', '- Relatórios de Leituras')

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-chart-line"></i> Relatórios de Leituras</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('app.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Leituras</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    @include('components.alert')

                    @if (count($apartments) == 0 && !$complexesApartments && !$complexes)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header bg-info">
                                        Não há dados para ser exibidos
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">Por favor, verifique com a administração do condomínio se
                                            sua conta foi vinculada a um imóvel, ou, no caso de possuir a função de síndico,
                                            se este cadastro foi realizado.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="card card-secondary card-tabs">
                            <div class="card-header p-0 pt-1">
                                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                    @if ($apartments && count($apartments) > 0)
                                        <li class="nav-item">
                                            <a class="nav-link active" id="custom-tabs-one-apartments-tab"
                                                data-toggle="pill" href="#custom-tabs-one-apartments" role="tab"
                                                aria-controls="custom-tabs-one-apartments" aria-selected="true">Meus
                                                Imóveis</a>
                                        </li>
                                    @endif
                                    @if ($complexes && count($complexes) > 0)
                                        <li class="nav-item">
                                            <a class="nav-link {{ !$apartments || count($apartments) == 0 ? 'active' : '' }}"
                                                id="custom-tabs-one-dealershipReadings-tab" data-toggle="pill"
                                                href="#custom-tabs-one-dealershipReadings" role="tab"
                                                aria-controls="custom-tabs-one-dealershipReadings"
                                                aria-selected="false">Condomínios Administrados</a>
                                        </li>
                                    @endif
                                    @if ($complexesApartments && count($complexesApartments) > 0)
                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-one-complexesApartments-tab"
                                                data-toggle="pill" href="#custom-tabs-one-complexesApartments" role="tab"
                                                aria-controls="custom-tabs-one-complexesApartments"
                                                aria-selected="false">Apartamentos por
                                                Condomínio</a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-one-tabContent">
                                    @if ($apartments && count($apartments) > 0)
                                        <div class="tab-pane fade show active" id="custom-tabs-one-apartments"
                                            role="tabpanel" aria-labelledby="custom-tabs-one-apartments-tab">
                                            @foreach ($apartments as $apartment)
                                                @php
                                                    $list = [];
                                                    $heads = [['label' => 'ID', 'width' => 5], 'Mês', 'Ano', 'Valor', ['label' => 'Visualizar', 'no-export' => true, 'width' => 10]];
                                                    foreach ($apartment->getFullReports() as $report) {
                                                        $list[] = [$report[0]->id, $report[0]->month_ref, $report[0]->year_ref, $report[1]['total_unit'], '<nobr>' . '<a class="btn btn-xs btn-default text-primary mx-1 shadow" title="Visualizar" href="residences-readings/' . $report[0]->id . '/apartment/' . $report[1]['apartment'] . '"><i class="fa fa-lg fa-fw fa-eye"></i></a>'];
                                                    }

                                                    $config = [
                                                        'data' => $list,
                                                        'order' => [[0, 'desc']],
                                                        'columns' => [null, null, null, null, ['orderable' => false]],
                                                        'language' => ['url' => asset('vendor/datatables/js/pt-BR.json')],
                                                    ];

                                                @endphp

                                                <div class="card">
                                                    <div class="card-header">
                                                        <div
                                                            class="d-flex flex-wrap justify-content-between col-12 align-content-center">
                                                            <h3 class="card-title align-self-center">Leituras Cadastradas
                                                                para o
                                                                Ap.
                                                                {{ $apartment->name }}, Bl.
                                                                {{ $apartment->block['name'] }}
                                                                no Condomínio
                                                                {{ $apartment->block->complex['alias_name'] }}
                                                            </h3>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <x-adminlte-datatable id="table{{ $loop->index }}"
                                                            :heads="$heads" :heads="$heads" :config="$config" striped
                                                            hoverable beautify with-buttons />
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                    @if ($complexes && count($complexes) > 0)
                                        <div class="tab-pane fade {{ !$apartments || count($apartments) == 0 ? 'show active' : '' }}"
                                            id="custom-tabs-one-dealershipReadings" role="tabpanel"
                                            aria-labelledby="custom-tabs-one-dealershipReadings-tab">
                                            @foreach ($complexes as $complex)
                                                @php
                                                    $list = [];
                                                    $heads = [['label' => 'ID', 'width' => 5], 'Condomínio', 'Mês Ref', 'Ano Ref', 'Data da Leitura', 'Próx Leitura', ['label' => 'Visualizar', 'no-export' => true, 'width' => 10]];

                                                    foreach ($complex->dealershipReading as $reading) {
                                                        $list[] = [$reading->id, $reading->complex['alias_name'], $reading->month_ref, $reading->year_ref, $reading->reading_date, $reading->reading_date_next, '<nobr>' . '<a class="btn btn-xs btn-default text-primary mx-1 shadow" title="Visualizar" href="residences-readings/' . $reading->id . '/complex/' . $complex->id . '"><i class="fa fa-lg fa-fw fa-eye"></i></a>'];
                                                    }

                                                    $config = [
                                                        'data' => $list,
                                                        'order' => [[0, 'desc']],
                                                        'columns' => [null, null, null, null, null, null, ['orderable' => false]],
                                                        'language' => ['url' => asset('vendor/datatables/js/pt-BR.json')],
                                                    ];

                                                @endphp

                                                <div class="card">
                                                    <div class="card-header">
                                                        <div
                                                            class="d-flex flex-wrap justify-content-between col-12 align-content-center">
                                                            <h3 class="card-title align-self-center">Leituras Cadastradas
                                                                para o Condomínio {{ $complex->alias_name }}

                                                            </h3>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <x-adminlte-datatable id="tableX{{ $loop->index }}"
                                                            :heads="$heads" :heads="$heads" :config="$config" striped
                                                            hoverable beautify with-buttons />
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                    @if ($complexesApartments && count($complexesApartments) > 0)
                                        <div class="tab-pane fade" id="custom-tabs-one-complexesApartments" role="tabpanel"
                                            aria-labelledby="custom-tabs-one-complexesApartments-tab">
                                            @foreach ($complexesApartments as $apartment)
                                                @php
                                                    $list = [];
                                                    $heads = [['label' => 'ID', 'width' => 5], 'Mês', 'Ano', 'Valor', ['label' => 'Visualizar', 'no-export' => true, 'width' => 10]];

                                                    foreach ($apartment->getFullReports() as $report) {
                                                        $list[] = [$report[0]->id, $report[0]->month_ref, $report[0]->year_ref, $report[1]['total_unit'], '<nobr>' . '<a class="btn btn-xs btn-default text-primary mx-1 shadow" title="Visualizar" href="residences-readings/' . $report[0]->id . '/apartment/' . $report[1]['apartment'] . '"><i class="fa fa-lg fa-fw fa-eye"></i></a>'];
                                                    }

                                                    $config = [
                                                        'data' => $list,
                                                        'order' => [[0, 'desc']],
                                                        'columns' => [null, null, null, null, ['orderable' => false]],
                                                        'language' => ['url' => asset('vendor/datatables/js/pt-BR.json')],
                                                    ];

                                                @endphp

                                                <div class="card">
                                                    <div class="card-header">
                                                        <div
                                                            class="d-flex flex-wrap justify-content-between col-12 align-content-center">
                                                            <h3 class="card-title align-self-center">Leituras Cadastradas
                                                                para o
                                                                Ap.
                                                                {{ $apartment->name }}, Bl.
                                                                {{ $apartment->block['name'] }}
                                                                no Condomínio
                                                                {{ $apartment->block->complex['alias_name'] }}
                                                            </h3>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <x-adminlte-datatable id="tableY{{ $loop->index }}"
                                                            :heads="$heads" :heads="$heads" :config="$config" striped
                                                            hoverable beautify with-buttons />
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>


                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
