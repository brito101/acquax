@extends('adminlte::page')

@section('title', '- Concessionárias')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('content')
    @if (auth()->user()->can('Editar Concessionárias') &&
        auth()->user()->can('Excluir Concessionárias'))
        @php
            $heads = [['label' => 'ID', 'width' => 5], 'Nome', 'Serviço', ['label' => 'Ações', 'no-export' => true, 'width' => 10]];

            $list = [];

            foreach ($dealerships as $dealership) {
                $list[] = [$dealership->id, $dealership->name, $dealership->service, '<nobr>' . '<a class="btn btn-xs btn-default text-primary mx-1 shadow" title="Editar" href="dealerships/' . $dealership->id . '/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>' . '<a class="btn btn-xs btn-default text-danger mx-1 shadow" title="Excluir" href="dealerships/destroy/' . $dealership->id . '" onclick="return confirm(\'Confirma a exclusão desta concessionária?\')"><i class="fa fa-lg fa-fw fa-trash"></i></a>'];
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
            $heads = [['label' => 'ID', 'width' => 5], 'Nome', 'Serviço'];

            $list = [];

            foreach ($dealerships as $dealership) {
                $list[] = [$dealership->id, $dealership->name, $dealership->service];
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
                    <h1><i class="fas fa-fw fa-hands-helping"></i> Concessionárias</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Configurações</a></li>
                        <li class="breadcrumb-item active">Concessionárias</li>
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
                                <h3 class="card-title align-self-center">Concessionárias Cadastradas</h3>
                                @can('Criar Concessionárias')
                                    <a href="{{ route('admin.dealerships.create') }}" title="Nova Concessionária"
                                        class="btn btn-success"><i class="fas fa-fw fa-plus"></i>Nova Concessionária</a>
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
