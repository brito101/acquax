@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('title', '- Relatórios de Consumo de Água')

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-chart-line"></i> Relatórios de Consumo de Água</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('app.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Relatórios de Consumo de Água</li>
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

                    @if (count($apartments) == 0 && !$complexes)
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

                                        <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-one-complexesApartments-tab"
                                                data-toggle="pill" href="#custom-tabs-one-complexesApartments"
                                                role="tab" aria-controls="custom-tabs-one-complexesApartments"
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
                                                <div class="card">
                                                    <div class="card-header">
                                                        <div
                                                            class="d-flex flex-wrap justify-content-between col-12 align-content-center">
                                                            <h3 class="card-title align-self-center">Leituras de Água
                                                                Cadastradas
                                                                para o
                                                                Ap.
                                                                {{ $apartment->name }}, Bl.
                                                                {{ $apartment->block['name'] }}
                                                                no Condomínio
                                                                {{ $apartment->block->complex['alias_name'] }}
                                                            </h3>
                                                        </div>
                                                    </div>

                                                    @php
                                                        $heads = [['label' => 'ID', 'width' => 5], 'Unidade', 'Mês', 'Ano', 'Valor', ['label' => 'Visualizar', 'no-export' => true, 'width' => 10]];
                                                        $config = [
                                                            'ajax' => url('/app/residences-readings-ajax/' . $apartment->id),
                                                            'columns' => [['data' => 'id', 'name' => 'id'], ['data' => 'unit', 'name' => 'unit'], ['data' => 'month_ref', 'name' => 'month_ref'], ['data' => 'year_ref', 'name' => 'year_ref'], ['data' => 'total_unit', 'name' => 'total_unit'], ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false]],
                                                            'language' => ['url' => asset('vendor/datatables/js/pt-BR.json')],
                                                            'autoFill' => true,
                                                            'processing' => true,
                                                            'serverSide' => true,
                                                            'responsive' => true,
                                                            'lengthMenu' => [[10, 50, 100, 500, 1000, -1], [10, 50, 100, 500, 1000, 'Tudo']],
                                                            'order' => [[0, 'desc']],
                                                            'dom' => '<"d-flex flex-wrap col-12 justify-content-between"Bf>rtip',
                                                            'buttons' => [
                                                                ['extend' => 'pageLength', 'className' => 'btn-default'],
                                                                ['extend' => 'copy', 'className' => 'btn-default', 'text' => '<i class="fas fa-fw fa-lg fa-copy text-secondary"></i>', 'titleAttr' => 'Copiar', 'exportOptions' => ['columns' => ':not([dt-no-export])']],
                                                                ['extend' => 'print', 'className' => 'btn-default', 'text' => '<i class="fas fa-fw fa-lg fa-print text-info"></i>', 'titleAttr' => 'Imprimir', 'exportOptions' => ['columns' => ':not([dt-no-export])']],
                                                                ['extend' => 'csv', 'className' => 'btn-default', 'text' => '<i class="fas fa-fw fa-lg fa-file-csv text-primary"></i>', 'titleAttr' => 'Exportar para CSV', 'exportOptions' => ['columns' => ':not([dt-no-export])']],
                                                                ['extend' => 'excel', 'className' => 'btn-default', 'text' => '<i class="fas fa-fw fa-lg fa-file-excel text-success"></i>', 'titleAttr' => 'Exportar para Excel', 'exportOptions' => ['columns' => ':not([dt-no-export])']],
                                                                ['extend' => 'pdf', 'className' => 'btn-default', 'text' => '<i class="fas fa-fw fa-lg fa-file-pdf text-danger"></i>', 'titleAttr' => 'Exportar para PDF', 'exportOptions' => ['columns' => ':not([dt-no-export])']],
                                                            ],
                                                        ];
                                                    @endphp

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
                                                <div class="card">
                                                    <div class="card-header">
                                                        <div
                                                            class="d-flex flex-wrap justify-content-between col-12 align-content-center">
                                                            <h3 class="card-title align-self-center">Leituras de Água
                                                                Cadastradas
                                                                para o Condomínio {{ $complex->alias_name }}</h3>
                                                        </div>
                                                    </div>

                                                    @php
                                                        $heads = [['label' => 'ID', 'width' => 5], 'Condomínio', 'Mês Ref', 'Ano Ref', 'Data da Leitura', 'Próx Leitura', ['label' => 'Visualizar', 'no-export' => true, 'width' => 10]];
                                                        $config = [
                                                            'ajax' => url('/app/complex-readings-ajax/' . $complex->id),
                                                            'columns' => [['data' => 'id', 'name' => 'id'], ['data' => 'alias_name', 'name' => 'alias_name'], ['data' => 'month_ref', 'name' => 'month_ref'], ['data' => 'year_ref', 'name' => 'year_ref'], ['data' => 'reading_date', 'name' => 'reading_date'], ['data' => 'reading_date_next', 'name' => 'reading_date_next'], ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false]],
                                                            'language' => ['url' => asset('vendor/datatables/js/pt-BR.json')],
                                                            'autoFill' => true,
                                                            'processing' => true,
                                                            'serverSide' => true,
                                                            'responsive' => true,
                                                            'lengthMenu' => [[10, 50, 100, 500, 1000, -1], [10, 50, 100, 500, 1000, 'Tudo']],
                                                            'order' => [[0, 'desc']],
                                                            'dom' => '<"d-flex flex-wrap col-12 justify-content-between"Bf>rtip',
                                                            'buttons' => [
                                                                ['extend' => 'pageLength', 'className' => 'btn-default'],
                                                                ['extend' => 'copy', 'className' => 'btn-default', 'text' => '<i class="fas fa-fw fa-lg fa-copy text-secondary"></i>', 'titleAttr' => 'Copiar', 'exportOptions' => ['columns' => ':not([dt-no-export])']],
                                                                ['extend' => 'print', 'className' => 'btn-default', 'text' => '<i class="fas fa-fw fa-lg fa-print text-info"></i>', 'titleAttr' => 'Imprimir', 'exportOptions' => ['columns' => ':not([dt-no-export])']],
                                                                ['extend' => 'csv', 'className' => 'btn-default', 'text' => '<i class="fas fa-fw fa-lg fa-file-csv text-primary"></i>', 'titleAttr' => 'Exportar para CSV', 'exportOptions' => ['columns' => ':not([dt-no-export])']],
                                                                ['extend' => 'excel', 'className' => 'btn-default', 'text' => '<i class="fas fa-fw fa-lg fa-file-excel text-success"></i>', 'titleAttr' => 'Exportar para Excel', 'exportOptions' => ['columns' => ':not([dt-no-export])']],
                                                                ['extend' => 'pdf', 'className' => 'btn-default', 'text' => '<i class="fas fa-fw fa-lg fa-file-pdf text-danger"></i>', 'titleAttr' => 'Exportar para PDF', 'exportOptions' => ['columns' => ':not([dt-no-export])']],
                                                            ],
                                                        ];
                                                    @endphp

                                                    <div class="card-body">
                                                        <x-adminlte-datatable id="tableX{{ $loop->index }}"
                                                            :heads="$heads" :heads="$heads" :config="$config" striped
                                                            hoverable beautify with-buttons />
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                    @if ($complexes && count($complexes) > 0)
                                        <div class="tab-pane fade" id="custom-tabs-one-complexesApartments" role="tabpanel"
                                            aria-labelledby="custom-tabs-one-complexesApartments-tab">
                                            @foreach ($complexes as $complex)
                                                <div class="card">
                                                    <div class="card-header">
                                                        <div
                                                            class="d-flex flex-wrap justify-content-between col-12 align-content-center">
                                                            <h3 class="card-title align-self-center">Leituras de Água
                                                                Cadastradas
                                                                para o condomínio {{ $complex->alias_name }}
                                                            </h3>
                                                        </div>
                                                    </div>

                                                    @php
                                                        $heads = [['label' => 'ID', 'width' => 5], 'Bl', 'Ap', 'Mês', 'Ano', 'Valor', ['label' => 'Visualizar', 'no-export' => true, 'width' => 10]];
                                                        $config = [
                                                            'ajax' => url('/app/complex-residences-readings-ajax/' . $complex->id),
                                                            'columns' => [['data' => 'id', 'name' => 'id'], ['data' => 'block', 'name' => 'block'], ['data' => 'apartment', 'name' => 'apartment'], ['data' => 'month_ref', 'name' => 'month_ref'], ['data' => 'year_ref', 'name' => 'year_ref'], ['data' => 'total_unit', 'name' => 'total_unit'], ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false]],
                                                            'language' => ['url' => asset('vendor/datatables/js/pt-BR.json')],
                                                            'autoFill' => true,
                                                            'processing' => true,
                                                            'serverSide' => true,
                                                            'responsive' => true,
                                                            'lengthMenu' => [[10, 50, 100, 500, 1000, -1], [10, 50, 100, 500, 1000, 'Tudo']],
                                                            'order' => [[0, 'desc']],
                                                            'dom' => '<"d-flex flex-wrap col-12 justify-content-between"Bf>rtip',
                                                            'buttons' => [
                                                                ['extend' => 'pageLength', 'className' => 'btn-default'],
                                                                ['extend' => 'copy', 'className' => 'btn-default', 'text' => '<i class="fas fa-fw fa-lg fa-copy text-secondary"></i>', 'titleAttr' => 'Copiar', 'exportOptions' => ['columns' => ':not([dt-no-export])']],
                                                                ['extend' => 'print', 'className' => 'btn-default', 'text' => '<i class="fas fa-fw fa-lg fa-print text-info"></i>', 'titleAttr' => 'Imprimir', 'exportOptions' => ['columns' => ':not([dt-no-export])']],
                                                                ['extend' => 'csv', 'className' => 'btn-default', 'text' => '<i class="fas fa-fw fa-lg fa-file-csv text-primary"></i>', 'titleAttr' => 'Exportar para CSV', 'exportOptions' => ['columns' => ':not([dt-no-export])']],
                                                                ['extend' => 'excel', 'className' => 'btn-default', 'text' => '<i class="fas fa-fw fa-lg fa-file-excel text-success"></i>', 'titleAttr' => 'Exportar para Excel', 'exportOptions' => ['columns' => ':not([dt-no-export])']],
                                                                ['extend' => 'pdf', 'className' => 'btn-default', 'text' => '<i class="fas fa-fw fa-lg fa-file-pdf text-danger"></i>', 'titleAttr' => 'Exportar para PDF', 'exportOptions' => ['columns' => ':not([dt-no-export])']],
                                                            ],
                                                        ];
                                                    @endphp

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
