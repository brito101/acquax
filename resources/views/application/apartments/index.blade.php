@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('title', '- Leituras')

@section('content')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-chart-line"></i> Leituras</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('app.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Leituras</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    @include('components.alert')

                    @foreach ($apartments as $apartment)
                        @php
                            $list = [];
                            $heads = [['label' => 'ID', 'width' => 5], 'Mês', 'Ano', 'Valor', ['label' => 'Visualizar', 'no-export' => true, 'width' => 10]];
                            foreach ($apartment->getFullReports() as $report) {
                                $list[] = [$report[0]->id, $report[0]->month_ref, $report[0]->year_ref, $report[1]['total_unit'], '<nobr>' . '<a class="btn btn-xs btn-default text-primary mx-1 shadow" title="Visualizar" href="residences-readings/' . $report[0]->id . '/apartment/' . $report[1]['apartment'] . '"><i class="fa fa-lg fa-fw fa-eye"></i></a>'];
                            }

                            $config = [
                                'data' => $list,
                                'order' => [[0, 'asc']],
                                'columns' => [null, null, null, null, ['orderable' => false]],
                                'language' => ['url' => asset('vendor/datatables/js/pt-BR.json')],
                            ];

                        @endphp

                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex flex-wrap justify-content-between col-12 align-content-center">
                                    <h3 class="card-title align-self-center">Leituras Cadastradas para o Ap.
                                        {{ $apartment->name }}, Bl. {{ $apartment->block['name'] }} no Condomínio
                                        {{ $apartment->block->complex['alias_name'] }}
                                    </h3>
                                </div>
                            </div>
                            <div class="card-body">

                                <x-adminlte-datatable id="table{{ $loop->index }}" :heads="$heads" :heads="$heads"
                                    :config="$config" striped hoverable beautify with-buttons />
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </section>
@endsection
