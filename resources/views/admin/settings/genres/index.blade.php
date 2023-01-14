@extends('adminlte::page')

@section('title', '- Gêneros')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('content')
    @if (auth()->user()->can('Editar Gêneros') &&
        auth()->user()->can('Excluir Gêneros'))
        @php
            $heads = [['label' => 'ID', 'width' => 5], 'Nome', 'Sigla', ['label' => 'Ações', 'no-export' => true, 'width' => 10]];

            $list = [];

            foreach ($genres as $genre) {
                $list[] = [$genre->id, $genre->name, $genre->acronym, '<nobr>' . '<a class="btn btn-xs btn-default text-primary mx-1 shadow" title="Editar" href="genres/' . $genre->id . '/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>' . '<a class="btn btn-xs btn-default text-danger mx-1 shadow" title="Excluir" href="genres/destroy/' . $genre->id . '" onclick="return confirm(\'Confirma a exclusão deste gênero?\')"><i class="fa fa-lg fa-fw fa-trash"></i></a>'];
            }

            $config = [
                'data' => $list,
                'lengthMenu' => [[10, 50, 100, 500, 1000, -1], [10, 50, 100, 500, 1000, 'Tudo']],
                'order' => [[0, 'asc']],
                'columns' => [null, null, null, ['orderable' => false]],
                'language' => ['url' => asset('vendor/datatables/js/pt-BR.json')],
            ];
        @endphp
    @else
        @php
            $heads = [['label' => 'ID', 'width' => 5], 'Nome', 'Sigla'];

            $list = [];

            foreach ($genres as $genre) {
                $list[] = [$genre->id, $genre->name, $genre->acronym];
            }

            $config = [
                'data' => $list,
                'order' => [[0, 'asc']],
                'columns' => [null, null, null],
                'language' => ['url' => asset('vendor/datatables/js/pt-BR.json')],
            ];
        @endphp
    @endif

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-genderless"></i> Gêneros</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Configurações</a></li>
                        <li class="breadcrumb-item active">Gênero</li>
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
                            <div class="d-flex flex-wrap justify-content-between col-12 align-content-center">
                                <h3 class="card-title align-self-center">Gêneros Cadastrados</h3>
                                @can('Criar Gêneros')
                                    <a href="{{ route('admin.genres.create') }}" title="Novo Gênero" class="btn btn-success"><i
                                            class="fas fa-fw fa-plus"></i>Novo Gênero</a>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body">
                            <x-adminlte-datatable id="table1" :heads="$heads" :heads="$heads" :config="$config"
                                striped hoverable beautify with-buttons />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
