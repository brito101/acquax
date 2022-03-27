@extends('adminlte::page')

@section('title', '- Perfis')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('content')
    @if (auth()->user()->can('Editar Perfis') &&
    auth()->user()->can('Sincronizar Perfis') &&
    auth()->user()->can('Excluir Perfis'))
        @php
            $heads = [['label' => 'ID', 'width' => 5], 'Nome', ['label' => 'Ações', 'no-export' => true, 'width' => 10]];

            $list = [];

            foreach ($roles as $role) {
                $list[] = [$role->id, $role->name, '<nobr>' . '<a class="btn btn-xs btn-default text-primary mx-1 shadow" title="Editar" href="role/' . $role->id . '/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>' . '<a class="btn btn-xs btn-default text-primary mx-1 shadow" title="Sincronizar Permissões" href="role/' . $role->id . '/permission"><i class="fa fa-lg fa-fw fa-sync"></i></a>' . '<a class="btn btn-xs btn-default text-danger mx-1 shadow" title="Excluir" href="role/destroy/' . $role->id . '" onclick="return confirm(\'Confirma a exclusão deste Perfil?\')"><i class="fa fa-lg fa-fw fa-trash"></i></a>'];
            }

            $config = [
                'data' => $list,
                'order' => [[0, 'asc']],
                'columns' => [null, null, ['orderable' => false]],
                'language' => ['url' => asset('vendor/datatables/js/pt-BR.json')],
            ];
        @endphp
    @else
        @php
            $heads = [['label' => 'ID', 'width' => 10], 'Nome'];

            $list = [];

            foreach ($roles as $role) {
                $list[] = [$role->id, $role->name];
            }

            $config = [
                'data' => $list,
                'order' => [[0, 'asc']],
                'columns' => [null, null],
                'language' => ['url' => asset('vendor/datatables/js/pt-BR.json')],
            ];
        @endphp
    @endif

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-user-cog"></i> Perfis</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">ACL</a></li>
                        <li class="breadcrumb-item active">Perfis</li>
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
                                <h3 class="card-title align-self-center">Perfis Cadastrados</h3>
                                @can('Criar Perfis')
                                    <a href="{{ route('admin.role.create') }}" title="Novo Perfil" class="btn btn-success"><i
                                            class="fas fa-fw fa-plus"></i>Novo Perfil</a>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body">
                            <x-adminlte-datatable id="table1" :heads="$heads" :heads="$heads" :config="$config" striped
                                hoverable beautify with-buttons />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
