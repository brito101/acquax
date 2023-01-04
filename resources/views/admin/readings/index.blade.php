@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.BsCustomFileInput', true)

@section('title', '- Leituras de Medidores')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-chart-line"></i> Leituras de Medidores</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Leituras de Medidores</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 d-flex justify-content-end pb-4">
                    <a class="btn btn-secondary" href="{{ Storage::url('planilha.ods') }}" download>Download Planilha</a>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @include('components.alert')
                    <div class="card card-solid">
                        <div class="card-header">
                            <i class="fas fa-fw fa-upload"></i> Importação de Planilha
                        </div>
                        <form action="{{ route('admin.readings.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body pb-0">
                                <x-adminlte-input-file name="file" label="Arquivo" placeholder="Selecione o arquivo..."
                                    legend="Selecionar" />
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-primary">Importar</button>
                            </div>
                        </form>
                    </div>

                    <div class="card card-solid">
                        <div class="card-header">
                            <div class="d-flex flex-wrap justify-content-between col-12 align-content-center">
                                <h3 class="card-title align-self-center">Leituras Cadastradas</h3>
                                @can('Criar Leituras')
                                    <a href="{{ route('admin.readings.create') }}" title="Nova Leitura"
                                        class="btn btn-success"><i class="fas fa-fw fa-plus"></i>Nova Leitura</a>
                                @endcan
                            </div>
                        </div>

                        @php
                            $heads = [['label' => 'ID', 'width' => 5], 'Unidade', 'Medidor', 'Leitura', 'Mês', 'Ano', 'Imagem', ['label' => 'Ações', 'no-export' => true, 'width' => 10]];
                            $config = [
                                'ajax' => url('/admin/readings'),
                                'columns' => [['data' => 'id', 'name' => 'id'], ['data' => 'property', 'name' => 'property'], ['data' => 'meter', 'name' => 'meter'], ['data' => 'value', 'name' => 'reading'], ['data' => 'month_ref', 'name' => 'month_ref'], ['data' => 'year_ref', 'name' => 'year_ref'], ['data' => 'image', 'name' => 'image'], ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false]],
                                'language' => ['url' => asset('vendor/datatables/js/pt-BR.json')],
                                'autoFill' => true,
                                'processing' => true,
                                'serverSide' => true,
                                'responsive' => true,
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
                                striped hoverable beautify />
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
