@extends('adminlte::page')

@section('title', '- Medidores')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('content')
    @if (auth()->user()->can('Editar Medidores') &&
    auth()->user()->can('Excluir Medidores'))
        @php
            $list = [];

            $heads = [['label' => 'ID', 'width' => 5], 'Identificador', 'Propriedade', 'Tipo', 'Status', ['label' => 'Ações', 'no-export' => true, 'width' => 10]];
            foreach ($meters as $meter) {
                $list[] = [$meter->id, $meter->register, 'Condomínio ' . $meter->apartment->getComplexNameAttribute() . ' - Bl. ' . $meter->apartment->getBlockNameAttribute() . ' - Ap. ' . $meter->apartment['name'], $meter->typeMeter['name'], $meter->status, '<nobr>' . '<a class="btn btn-xs btn-default text-primary mx-1 shadow" title="Editar" href="meters/' . $meter->id . '/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>' . '<a class="btn btn-xs btn-default text-danger mx-1 shadow" title="Excluir" href="meters/destroy/' . $meter->id . '" onclick="return confirm(\'Confirma a exclusão deste medidor?\')"><i class="fa fa-lg fa-fw fa-trash"></i></a>'];
            }

            $config = [
                'data' => $list,
                'order' => [[0, 'asc']],
                'columns' => [null, null, null, null, null, ['orderable' => false]],
                'language' => ['url' => asset('vendor/datatables/js/pt-BR.json')],
            ];

        @endphp
    @else
        @php

            $list = [];

            $heads = [['label' => 'ID', 'width' => 5], 'Identificador', 'Propriedade', 'Tipo', 'Status'];
            foreach ($meters as $meter) {
                $list[] = [$meter->id, $meter->register, $meter->register, 'Condomínio ' . $meter->apartment->getComplexNameAttribute() . ' - Bl. ' . $meter->apartment->getBlockNameAttribute() . ' - Ap. ' . $meter->apartment['name'], $meter->typeMeter['name'], $meter->status];
            }

            $config = [
                'data' => $list,
                'order' => [[0, 'asc']],
                'columns' => [null, null, null, null, null],
                'language' => ['url' => asset('vendor/datatables/js/pt-BR.json')],
            ];

        @endphp
    @endif
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-tachometer-alt"></i> Medidores</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Medidores</li>
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
                                <h3 class="card-title align-self-center">Medidores Cadastrados</h3>
                                @can('Criar Medidores')
                                    <a href="{{ route('admin.meters.create') }}" title="Novo Medidor"
                                        class="btn btn-success"><i class="fas fa-fw fa-plus"></i>Novo
                                        Medidor</a>
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
