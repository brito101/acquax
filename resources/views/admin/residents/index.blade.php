@extends('adminlte::page')

@section('title', '- Moradores')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('content')
    @if (auth()->user()->can('Editar Moradores') &&
    auth()->user()->can('Excluir Moradores'))
        @php
            $list = [];

            $heads = [['label' => 'ID', 'width' => 5], 'Morador', 'Propriedade', 'Status', ['label' => 'Ações', 'no-export' => true, 'width' => 10]];
            foreach ($residents as $resident) {
                $list[] = [$resident->id, $resident->user['name'] . ' - CPF: ' . $resident->user['document_person'] . ' - E-mail: ' . $resident->user['email'], 'Condomínio ' . $resident->apartment->getComplexNameAttribute() . ' - Bl. ' . $resident->apartment->getBlockNameAttribute() . ' - Ap. ' . $resident->apartment['name'], $resident->status, '<nobr>' . '<a class="btn btn-xs btn-default text-primary mx-1 shadow" title="Editar" href="residents/' . $resident->id . '/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>' . '<a class="btn btn-xs btn-default text-danger mx-1 shadow" title="Excluir" href="residents/destroy/' . $resident->id . '" onclick="return confirm(\'Confirma a exclusão deste morador?\')"><i class="fa fa-lg fa-fw fa-trash"></i></a>'];
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

            $heads = [['label' => 'ID', 'width' => 5], 'Morador', 'Propriedade', 'Status'];
            foreach ($residents as $resident) {
                $list[] = [$resident->id, $resident->user['name'] . ' - CPF: ' . $resident->user['document_person'] . ' - E-mail: ' . $resident->user['email'], 'Condomínio ' . $resident->apartment->getComplexNameAttribute() . ' - Bl. ' . $resident->apartment->getBlockNameAttribute() . ' - Ap. ' . $meter->apartment['name'], $meter->status];
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
                    <h1><i class="fas fa-fw fa-house-user"></i> Moradores</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Moradores</li>
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
                                <h3 class="card-title align-self-center">Moradores Cadastrados</h3>
                                @can('Criar Moradores')
                                    <a href="{{ route('admin.residents.create') }}" title="Novo Morador"
                                        class="btn btn-success"><i class="fas fa-fw fa-plus"></i>Novo
                                        Morador</a>
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
