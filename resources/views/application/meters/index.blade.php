@extends('adminlte::page')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugins', true)

@section('title', '- Relatórios de Medidores')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-tachometer-alt"></i> Relatórios de Medidores</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('app.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Relatórios de Medidores</li>
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

                    @php

                        $list = [];

                        $heads = [['label' => 'ID', 'width' => 5], 'Medidor', 'Imóvel', 'Localização', 'Mês Ref', 'Ano Ref', 'Data da Leitura', ['label' => 'Ações', 'no-export' => true, 'width' => 10]];
                        foreach ($readings as $reading) {
                            $list[] = [$reading->id, $reading->meter['register'], $reading->meter->apartment['complex_name'] . ' - ' . $reading->meter->apartment['block_name'] . ' - ' . $reading->meter->apartment['name'], $reading->meter['location'], $reading->month_ref, $reading->year_ref, $reading->reading_date, '<nobr>' . '<a class="btn btn-xs btn-default text-primary mx-1 shadow" title="Visualizar" href="meter-readings/' . $reading->id . '"><i class="fa fa-lg fa-fw fa-eye"></i></a>'];
                        }

                        $config = [
                            'data' => $list,
                            'order' => [[0, 'desc']],
                            'columns' => [null, null, null, null, null, null, null, ['orderable' => false]],
                            'language' => ['url' => asset('vendor/datatables/js/pt-BR.json')],
                        ];

                    @endphp

                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex flex-wrap justify-content-between col-12 align-content-center">
                                <h3 class="card-title align-self-center">Medições Cadastradas </h3>
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
