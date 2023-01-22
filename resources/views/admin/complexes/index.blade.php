@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)
@section('plugins.BsCustomFileInput', true)

@section('title', '- Condomínios')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-map-marked"></i> Condomínios</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Condomínios</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 d-flex justify-content-end pb-4">
                    <a class="btn btn-secondary" href="{{ Storage::url('condominio.ods') }}" download>Download
                        Planilha</a>
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
                            <i class="fas fa-fw fa-upload"></i> Importação de Planilha de Cadastro de Condomínios
                        </div>
                        <form action="{{ route('admin.complex.import') }}" method="POST" enctype="multipart/form-data">
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
                                <h3 class="card-title align-self-center">Condomínios Cadastrados</h3>
                                @can('Criar Condomínios')
                                    <a href="{{ route('admin.complexes.create') }}" title="Novo Condomínio"
                                        class="btn btn-success"><i class="fas fa-fw fa-plus"></i>Novo
                                        Condomínio</a>
                                @endcan
                            </div>
                        </div>

                        @php
                            $heads = [['label' => 'ID', 'width' => 5], 'Nome Fantasia', 'Cidade', 'Estado', 'Telefone', 'Qtd Bl', 'Qtd Ap', ['label' => 'Ações', 'no-export' => true, 'width' => 25]];
                            $config = [
                                'ajax' => url('/admin/complexes'),
                                'columns' => [['data' => 'id', 'name' => 'id'], ['data' => 'alias_name', 'name' => 'alias_name'], ['data' => 'city', 'name' => 'city'], ['data' => 'state', 'name' => 'state'], ['data' => 'telephone', 'name' => 'telephone'], ['data' => 'total_blocks', 'name' => 'total_blocks'], ['data' => 'total_apartments', 'name' => 'total_apartments'], ['data' => 'action', 'name' => 'action', 'orderable' => false, 'searchable' => false]],
                                'language' => ['url' => asset('vendor/datatables/js/pt-BR.json')],
                                'autoFill' => true,
                                'processing' => true,
                                'serverSide' => true,
                                'responsive' => true,
                                'lengthMenu' => [[10, 50, 100, 500, 1000, -1], [10, 50, 100, 500, 1000, 'Tudo']],
                                'order' => [[1, 'asc']],
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
                                <form method="POST" action="{{ route('admin.complexes.batchDelete') }}"
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

    {{-- <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @include('components.alert')
                    <div class="card card-solid">
                        <div class="card-header">
                            <i class="fas fa-fw fa-upload"></i> Importação de Planilha de Cadastro de Condomínios
                        </div>
                        <form action="{{ route('admin.complex.import') }}" method="POST" enctype="multipart/form-data">
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
                            <i class="fas fa-fw fa-search"></i> Pesquisa
                        </div>
                        <form method="POST" action="{{ route('admin.complex.search') }}">
                            @csrf
                            <div class="card-body pb-0">
                                <div class="d-flex flex-wrap justify-content-start">
                                    <div class="col-12 col-md-6 form-group px-0 pr-2">
                                        <label for="alias_name">Nome Fantasia</label>
                                        <input type="text" id="alias_name" name="alias_name" class="form-control"
                                            placeholder="Nome Fantasia do Condomínio" value="">
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pl-2">
                                        <label for="city">Cidade</label>
                                        <input type="text" id="city" name="city" class="form-control"
                                            placeholder="Cidade do Condomínio" value="">
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Pequisar</button>
                                <a href="{{ route('admin.complexes.index') }}" class="btn btn-secondary">Limpar</a>
                            </div>
                        </form>
                    </div>

                    <div class="card card-solid">
                        <div class="card-header">
                            <div class="d-flex flex-wrap justify-content-between col-12 align-content-center">
                                <h3 class="card-title align-self-center">Condomínios Cadastrados</h3>
                                @can('Criar Condomínios')
                                    <a href="{{ route('admin.complexes.create') }}" title="Novo Condomínio"
                                        class="btn btn-success"><i class="fas fa-fw fa-plus"></i>Novo Condomínio</a>
                                @endcan
                            </div>
                        </div>

                        <div class="card-body pb-0">
                            <div class="row">
                                @forelse ($complexes as $complex)
                                    <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                                        <div class="card bg-light d-flex flex-fill">
                                            <div class="card-header text-muted border-bottom-0">
                                                Condomínio #{{ $complex->id }}
                                            </div>
                                            <div class="card-body pt-0">
                                                <div class="row">
                                                    <div class="col-7">
                                                        <h2 class="lead"><b>{{ $complex->alias_name }}</b></h2>
                                                        <p class="text-muted text-sm mb-n1">Qtd de
                                                            Blocos: {{ $complex->blocks->count() }}
                                                        </p>
                                                        <p class="text-muted text-sm">Qtd de Apts:
                                                            {{ $complex->apartments->count() }}</p>
                                                        <p class="text-muted text-sm">Síndicos</p>
                                                        <ul class="ml-4 mb-0 fa-ul text-muted">
                                                            <li class="small"><span class="fa-li"><i
                                                                        class="fas fa-lg fa-building"></i></span>
                                                                {{ $complex->city }}-{{ $complex->state }}
                                                            </li>
                                                            <li class="small"><span class="fa-li"><i
                                                                        class="fas fa-lg fa-phone"></i></span>
                                                                {{ $complex->telephone }}
                                                            </li>
                                                        </ul>
                                                        <p class="text-muted text-sm mt-2 mb-0 pb-0">Status:<span
                                                                class="badge {{ $complex->status == 'Ativo' ? 'badge-info' : 'badge-warning' }} ml-2 text-md">{{ $complex->status }}</span>
                                                        </p>
                                                    </div>
                                                    <div class="col-5 text-center">
                                                        @if ($complex->photo)
                                                            <img src="{{ url('storage/complexes/' . $complex->photo) }}"
                                                                alt="{{ $complex->alias_name }}"
                                                                class="img-circle img-fluid"
                                                                style="object-fit: cover; width: 100%; aspect-ratio: 1;">
                                                        @else
                                                            <img src="{{ asset('img/building.png') }}"
                                                                alt="{{ $complex->alias_name }}"
                                                                class="img-circle img-fluid">
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <div class="text-center d-flex flex-wrap justify-content-center">
                                                    <div class="col-6">
                                                        <a href="{{ route('admin.complexes.edit', ['complex' => $complex->id]) }}"
                                                            class="btn btn-sm btn-primary w-100">
                                                            <i class="fas fa-edit mr-2"></i>Editar</a>
                                                    </div>
                                                    <div class="col-6">
                                                        <a href="complexes/destroy/{{ $complex->id }}"
                                                            class="btn btn-sm btn-danger w-100"
                                                            onclick="return confirm('Confirma a exclusão deste condomínio?')">
                                                            <i class="fas fa-trash mr-2"></i>Excluir
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="text-center d-flex flex-wrap justify-content-center pt-2">
                                                    <div class="col-6">
                                                        <a href="{{ route('admin.blocks.index', ['complex' => $complex->id]) }}"
                                                            class="btn btn-sm btn-success w-100">
                                                            <i class="fas fa-building mr-2"></i>Blocos</a>
                                                    </div>
                                                    @if ($complex->blocks->count() > 0)
                                                        <div class="col-6">
                                                            <a href="{{ route('admin.apartments.index', ['complex' => $complex->id]) }}"
                                                                class="btn btn-sm btn-info w-100">
                                                                <i class="fas fa-home mr-2"></i>Apts</a>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="text-center d-flex flex-wrap justify-content-center pt-2">
                                                    <div class="col-6">
                                                        <a href="{{ route('admin.syndics.index', ['complex' => $complex->id]) }}"
                                                            class="btn btn-sm btn-secondary w-100">
                                                            <i class="fas fa-users"></i>Síndicos
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @empty
                                    <p>Não há condomínios cadastrados</p>
                                @endforelse
                            </div>
                        </div>

                        <div class="card-footer">
                            <nav aria-label="Complexes Page Navigation">
                                <ul class="pagination justify-content-center m-0">
                                    {{ $complexes->appends(request()->input())->links() }}
                                </ul>
                            </nav>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </section> --}}

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
