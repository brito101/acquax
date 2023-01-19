@extends('adminlte::page')

@section('title', '- Usuários')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.BsCustomFileInput', true)

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-users-cog"></i> Usuários</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Usuários</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 d-flex justify-content-end pb-4">
                    <a class="btn btn-secondary" href="{{ Storage::url('email.ods') }}" download>Download Planilha
                        de atualização de email</a>
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
                            <i class="fas fa-fw fa-upload"></i> Importação de Planilha de Atualização de E-mail
                        </div>
                        <form action="{{ route('admin.users.importEmail') }}" method="POST" enctype="multipart/form-data">
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
                                <h3 class="card-title align-self-center">Usuários Cadastrados</h3>
                                @can('Criar Usuários')
                                    <a href="{{ route('admin.users.create') }}" title="Novo Usuário" class="btn btn-success"><i
                                            class="fas fa-fw fa-plus"></i>Novo Usuário</a>
                                @endcan
                            </div>
                        </div>

                        @php
                            $heads = [['label' => 'ID', 'width' => 10], 'Nome', 'CPF', 'E-mail', 'Tipo', ['label' => 'Ações', 'no-export' => true, 'width' => 10]];
                            $config = [
                                'ajax' => url('/admin/users'),
                                'columns' => [['data' => 'id', 'name' => 'id'], ['data' => 'name', 'name' => 'name'], ['data' => 'document_person', 'name' => 'document_person'], ['data' => 'email', 'name' => 'email'], ['data' => 'type', 'name' => 'type'], ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false]],
                                'language' => ['url' => asset('vendor/datatables/js/pt-BR.json')],
                                'autoFill' => true,
                                'processing' => true,
                                'serverSide' => true,
                                'responsive' => true,
                                'lengthMenu' => [[10, 50, 100, 500, 1000, -1], [10, 50, 100, 500, 1000, 'Tudo']],
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

                        <div class="card-body pb-0">
                            <div class="px-2 col-12">
                                <form method="POST" action="{{ route('admin.users.batchDelete') }}"
                                    class="w-100 flex-wrap d-flex justify-content-end">
                                    @csrf
                                    <input type="hidden" name="ids" value="" id="ids" class="ids">
                                    <button type="submit" id="batch-delete" class="btn btn-danger"
                                        data-confirm="Confirma a exclusão desta seleção?"><i class="fas fa-fw fa-trash"></i>
                                        Exclusão em Lote</button>
                                </form>
                            </div>
                        </div>

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

@section('custom_js')
    <script>
        $('#table1 tbody').on('click', 'tr', function() {
            $(this).toggleClass('selected bg-dark');
            let rows = $('#table1')[0].rows;
            let ids = [];
            $.each(rows, function(i, el) {
                if ($(el).hasClass('selected')) {
                    ids.push(el.children[0].textContent);
                }
            });
            $(".ids").val(ids)
        });

        $("#batch-delete").on('click', function(e) {
            if (!confirm($(this).data('confirm'))) {
                e.stopImmediatePropagation();
                e.preventDefault();
            }
        });
    </script>
@endsection
