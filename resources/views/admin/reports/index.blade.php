@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.BsCustomFileInput', true)

@section('title', '- Relatórios de Apartamentos')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-list-ul"></i> Relatórios de Apartamentos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Relatórios de Apartamentos</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 d-flex justify-content-end pb-4">
                    <a class="btn btn-secondary" href="{{ Storage::url('relatorio.ods') }}" download>Download Planilha</a>
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
                        <div class="card-header d-flex justify-content-between">
                            <div class="d-flex justify-content-start align-items-center col-12 col-md-6"><i
                                    class="fas fa-fw fa-upload"></i>
                                Importação de Planilha de Relatórios</div>
                            <div class="d-flex justify-content-end col-12 col-md-6">
                                <x-adminlte-button label="" data-toggle="modal" data-target="#tip"
                                    class="float-right bg-purple" icon="fa fa-question" />
                            </div>
                        </div>
                        <form action="{{ route('admin.reports.import') }}" method="POST" enctype="multipart/form-data">
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
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex flex-wrap justify-content-between col-12 align-content-center">
                                <h3 class="card-title align-self-center">Relatórios</h3>
                                @can('Criar Relatórios')
                                    <a href="{{ route('admin.reports.create') }}" title="Novo Relatório"
                                        class="btn btn-success"><i class="fas fa-fw fa-plus"></i>Novo
                                        Relatório</a>
                                @endcan
                            </div>
                        </div>

                        @php
                            $heads = [['label' => 'ID', 'width' => 5], 'Condomínio', 'Bl.', 'Ap.', 'Ano', 'Mês', 'Consumo (m3)', 'Total', ['label' => 'Ações', 'no-export' => true, 'width' => 10]];
                            $config = [
                                'ajax' => url('/admin/reports'),
                                'columns' => [['data' => 'id', 'name' => 'id'], ['data' => 'complex', 'name' => 'complex'], ['data' => 'block', 'name' => 'block'], ['data' => 'apartment', 'name' => 'apartment'], ['data' => 'year_ref', 'name' => 'year_ref'], ['data' => 'month_ref', 'name' => 'month_ref'], ['data' => 'consumed', 'name' => 'consumed'], ['data' => 'total_unit', 'name' => 'total_unit'], ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false]],
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

    <x-adminlte-modal id="tip" title="Informações sobre a importação" theme="purple" icon="fas fa-question"
        size='lg' disable-animations>
        <p>A importação dos relatórios de cada apartamento poderá ser realizado via importação de planilha própria, no botão
            de <b>download</b> presente nesta página, ou inserido um a um como novo cadastro (viável para condomínios com
            poucos apartamentos).</p>
        <p>Para importar, basta preencher os valores dos campos, levando em consideração o nome fantasia exato do
            condomínio, nome do bloco e do apartamento. Caso não sejam localizáveis, o armazenamento não armazenará e
            passará para a próxima linha. <b class="text-red">IMPORTANTE</b>: a conta da concessionária deverá já estar
            lançanda, pois será utilizada como referência para o armazenamento e será localizada a partir das informações do
            condomínio, mês e ano de referência</p>
        <p>Caso um relatório já exista para um apartamento e período de referência, ele será deletado e as informações da
            última
            importação serão apresentadas. Desta forma, caso haja algum erro, uma nova importação poderá ser realizada de
            forma tranquila, pois não existirá duplicidade de relatórios.</p>
        <p>Passo a passo ideal de cadastro:</p>
        <ul>
            <li>Cadastrar as medições dos medidores via importação</li>
            <li>Cadastrar a conta do condomínio recebida pela concessionária</li>
            <li>Cadastrar os relatórios para os apartamentos via importação</li>
        </ul>
        <p>A apresentação para os moradores seguirá da mesma, incluindo a notificação em caso de consumo acima da média do
            condomínio.</p>
        <x-slot name="footerSlot">
            <x-adminlte-button theme="primary" label="Fechar" data-dismiss="modal" />
        </x-slot>
    </x-adminlte-modal>

@endsection
