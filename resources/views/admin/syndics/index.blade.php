@extends('adminlte::page')

@section('title', '- Síndicos')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('content')
    @if (auth()->user()->can('Editar Síndicos') &&
    auth()->user()->can('Excluir Síndicos'))
        @php
            $list = [];

            $heads = [['label' => 'ID', 'width' => 5], 'Síndico', 'Condomínio', 'Status', ['label' => 'Ações', 'no-export' => true, 'width' => 10]];
            foreach ($syndics as $syndic) {
                $list[] = [$syndic->id, $syndic->user['name'] . ' - CPF: ' . $syndic->user['document_person'] . ' - E-mail: ' . $syndic->user['email'], $syndic->complex['alias_name'], $syndic->status, '<nobr>' . '<a class="btn btn-xs btn-default text-primary mx-1 shadow" title="Editar" href="syndics/' . $syndic->id . '/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>' . '<a class="btn btn-xs btn-default text-danger mx-1 shadow" title="Excluir" href="syndics/destroy/' . $syndic->id . '" onclick="return confirm(\'Confirma a exclusão deste síndico?\')"><i class="fa fa-lg fa-fw fa-trash"></i></a>'];
            }

            $config = [
                'data' => $list,
                'order' => [[0, 'asc']],
                'columns' => [null, null, null, null, ['orderable' => false]],
                'language' => ['url' => asset('vendor/datatables/js/pt-BR.json')],
            ];

        @endphp
    @else
        @php

            $list = [];

            $heads = [['label' => 'ID', 'width' => 5], 'Síndico', 'Condomínio', 'Status'];
            foreach ($syndics as $syndic) {
                $list[] = [$syndic->id, $syndic->user['name'] . ' - CPF: ' . $syndic->user['document_person'] . ' - E-mail: ' . $syndic->user['email'], $syndic->complex['alias_name'], $meter->status];
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
                    <h1><i class="fas fa-fw fa-user-friends"></i> Síndicos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Síndicos</li>
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
                                <h3 class="card-title align-self-center">Síndicos Cadastrados</h3>
                                @can('Criar Síndicos')
                                    <a href="{{ route('admin.syndics.create') }}" title="Novo Síndico"
                                        class="btn btn-success"><i class="fas fa-fw fa-plus"></i>Novo
                                        Síndico</a>
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
