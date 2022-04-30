@extends('adminlte::page')

@section('title', '- Consumo de Condomínios')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('content')
    @if (auth()->user()->can('Editar Leitura das Concessionárias') &&
    auth()->user()->can('Excluir Leitura das Concessionárias'))
        @php

            $list = [];

            $heads = [['label' => 'ID', 'width' => 5], 'Condomínio', 'Mês Ref', 'Data da Leitura', 'Próx Leitura', ['label' => 'Ações', 'no-export' => true, 'width' => 10]];
            foreach ($readings as $reading) {
                $list[] = [$reading->id, $reading->complex['alias_name'], $reading->month_ref, $reading->reading_date, $reading->reading_date_next, '<nobr>' . '<a class="btn btn-xs btn-default text-primary mx-1 shadow" title="Editar" href="dealerships-readings/' . $reading->id . '/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>' . '<a class="btn btn-xs btn-default text-danger mx-1 shadow" title="Excluir" href="dealerships-readings/destroy/' . $reading->id . '" onclick="return confirm(\'Confirma a exclusão deste consumo?\')"><i class="fa fa-lg fa-fw fa-trash"></i></a>'];
            }

            $config = [
                'data' => $list,
                'order' => [[0, 'desc']],
                'columns' => [null, null, null, null, null, ['orderable' => false]],
                'language' => ['url' => asset('vendor/datatables/js/pt-BR.json')],
            ];

        @endphp
    @else
        @php
            $heads = [['label' => 'ID', 'width' => 5], 'Condomínio', 'Mês Ref', 'Data da Leitura', 'Próx Leitura'];

            $list = [];

            foreach ($readings as $reading) {
                $list[] = [$reading->id, $reading->complex['alias_name'], $reading->month_ref, $reading->reading_date, $reading->reading_date_next];
            }

            $config = [
                'data' => $list,
                'order' => [[0, 'desc']],
                'columns' => [null, null, null, null, null],
                'language' => ['url' => asset('vendor/datatables/js/pt-BR.json')],
            ];
        @endphp
    @endif

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-chart-bar"></i> Consumo de Condomínios</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Consumo de Condomínios</li>
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
                                <h3 class="card-title align-self-center">Consumo de Condomínios Cadastrados</h3>
                                @can('Criar Leitura das Concessionárias')
                                    <a href="{{ route('admin.dealerships-readings.create') }}" title="Novo Consumo"
                                        class="btn btn-success"><i class="fas fa-fw fa-plus"></i>Novo Consumo</a>
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
