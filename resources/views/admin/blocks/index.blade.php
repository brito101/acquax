@extends('adminlte::page')

@section('title', '- Blocos')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('content')
    @if (auth()->user()->can('Editar Blocos') &&
    auth()->user()->can('Excluir Blocos'))
        @php

            $list = [];

            if ($complex instanceof Illuminate\Database\Eloquent\Collection) {
                $heads = [['label' => 'ID', 'width' => 5], 'Bloco', 'Condomínio', 'Status', ['label' => 'Ações', 'no-export' => true, 'width' => 10]];
                foreach ($blocks->toArray() as $block) {
                    $c = $list[] = [$block['id'], $block['name'], $block['complex_name'], $block['status'], '<nobr>' . '<a class="btn btn-xs btn-default text-primary mx-1 shadow" title="Editar" href="blocks/' . $block['id'] . '/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>' . '<a class="btn btn-xs btn-default text-danger mx-1 shadow" title="Excluir" href="blocks/destroy/' . $block['id'] . '" onclick="return confirm(\'Confirma a exclusão deste bloco?\')"><i class="fa fa-lg fa-fw fa-trash"></i></a>'];
                }

                $config = [
                    'data' => $list,
                    'order' => [[0, 'asc']],
                    'columns' => [null, null, null, null, ['orderable' => false]],
                    'language' => ['url' => asset('vendor/datatables/js/pt-BR.json')],
                ];
            } else {
                $heads = [['label' => 'ID', 'width' => 5], 'Bloco', 'Condomínio', 'Status', ['label' => 'Ações', 'no-export' => true, 'width' => 10]];
                foreach ($blocks as $block) {
                    $list[] = [$block->id, $block->name, $block->complex_name, $block->status, '<nobr>' . '<a class="btn btn-xs btn-default text-primary mx-1 shadow" title="Editar" href="blocks/' . $block->id . '/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>' . '<a class="btn btn-xs btn-default text-danger mx-1 shadow" title="Excluir" href="blocks/destroy/' . $block->id . '" onclick="return confirm(\'Confirma a exclusão deste bloco?\')"><i class="fa fa-lg fa-fw fa-trash"></i></a>'];
                }

                $config = [
                    'data' => $list,
                    'order' => [[0, 'asc']],
                    'columns' => [null, null, null, null, ['orderable' => false]],
                    'language' => ['url' => asset('vendor/datatables/js/pt-BR.json')],
                ];
            }

        @endphp
    @else
        @php
            $heads = [['label' => 'ID', 'width' => 5], 'Bloco', 'Condomínio', 'Status'];

            $list = [];

            foreach ($blocks as $block) {
                $list[] = [$genrblocke->id, $block->name, $block->complex['alias_name'], $block->status];
            }

            $config = [
                'data' => $list,
                'order' => [[0, 'asc']],
                'columns' => [null, null, null, null],
                'language' => ['url' => asset('vendor/datatables/js/pt-BR.json')],
            ];
        @endphp
    @endif

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-building"></i> Blocos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Blocos</li>
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
                                <h3 class="card-title align-self-center">Blocos Cadastrados</h3>
                                @can('Criar Blocos')
                                    <a href="{{ route('admin.blocks.create') }}" title="Novo Bloco" class="btn btn-success"><i
                                            class="fas fa-fw fa-plus"></i>Novo Bloco</a>
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
