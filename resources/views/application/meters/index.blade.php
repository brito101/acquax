@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('title', '- Relatórios de Medidores')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-tachometer-alt"></i> Relatórios de Medidores</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('app.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Relatórios de Medidores</li>
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

                    @if ($readings && count($readings) > 0)
                        <h3><span class="badge badge-secondary">Meus Imóveis</span></h3>

                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex flex-wrap justify-content-between col-12 align-content-center">
                                    <h3 class="card-title align-self-center">Medições Cadastradas </h3>
                                </div>
                            </div>

                            @php
                                $heads = [['label' => 'ID', 'width' => 5], 'Medidor', 'Imóvel', 'Tipo', 'Mês Ref', 'Ano Ref', 'Data da Leitura', ['label' => 'Ações', 'no-export' => true, 'width' => 10]];
                                $config = [
                                    'ajax' => url('/app/meters-readings-ajax'),
                                    'columns' => [['data' => 'id', 'name' => 'id'], ['data' => 'register', 'name' => 'register'], ['data' => 'property', 'name' => 'property'], ['data' => 'meter_type', 'name' => 'meter_type'], ['data' => 'month_ref', 'name' => 'month_ref'], ['data' => 'year_ref', 'name' => 'year_ref'], ['data' => 'reading_date', 'name' => 'reading_date'], ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false]],
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
                                <x-adminlte-datatable id="table1" :heads="$heads" :heads="$heads" :config="$config"
                                    striped hoverable beautify with-buttons />
                            </div>
                        </div>
                    @endif

                    @if ($complexReadings && count($complexReadings) > 0)
                        <h3><span class="badge badge-secondary">Condomínios Administrados</span></h3>

                        @php
                            $heads = [['label' => 'ID', 'width' => 5], 'Medidor', 'Imóvel', 'Tipo', 'Mês Ref', 'Ano Ref', 'Data da Leitura', ['label' => 'Ações', 'no-export' => true, 'width' => 10]];
                            $config = [
                                'ajax' => url('/app/meters-complex-readings-ajax'),
                                'columns' => [['data' => 'id', 'name' => 'id'], ['data' => 'register', 'name' => 'register'], ['data' => 'property', 'name' => 'property'], ['data' => 'meter_type', 'name' => 'meter_type'], ['data' => 'month_ref', 'name' => 'month_ref'], ['data' => 'year_ref', 'name' => 'year_ref'], ['data' => 'reading_date', 'name' => 'reading_date'], ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false]],
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

                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex flex-wrap justify-content-between col-12 align-content-center">
                                    <h3 class="card-title align-self-center">Medições Cadastradas </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <x-adminlte-datatable id="table2" :heads="$heads" :heads="$heads" :config="$config"
                                    striped hoverable beautify with-buttons />
                            </div>
                        </div>
                    @endif

                    @if ((!$readings || count($readings) == 0) && (!$complexReadings || count($complexReadings) == 0))
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
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
