@extends('adminlte::page')
@section('plugins.Chartjs', true)

@section('title', '- Dashboard')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            @foreach ($residences as $residence)
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h5 class="card-title">
                                    {{ $residence->apartment['complex_name'] }} -
                                    Bl: {{ $residence->apartment['block_name'] }} -
                                    Ap: {{ $residence->apartment['name'] }}</h5>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus text-white"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                                        <i class="fas fa-times text-white"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <p class="text-center">
                                            <strong>Gráfico de Consumo {{ date('Y') }}</strong>
                                        </p>
                                        <div class="chart">
                                            <div class="chartjs-size-monitor">
                                                <div class="chartjs-size-monitor-expand">
                                                    <div class=""></div>
                                                </div>
                                                <div class="chartjs-size-monitor-shrink">
                                                    <div class=""></div>
                                                </div>
                                            </div>

                                            <canvas style="height: 250px; display: block; width: 684px;"
                                                id="chart-appartment-reading-{{ $loop->index }}"
                                                class="chart-appartment-reading" width="684" height="250px"></canvas>
                                        </div>

                                    </div>

                                    <div class="col-md-4">
                                        <p class="text-center">
                                            <strong>Dados da Última Leitura</strong>
                                        </p>
                                        @foreach ($residence->apartment->meter as $meter)
                                            <div class="card">
                                                <div class="card-header bg-light">
                                                    <h5 class="card-title">Medidor: {{ $meter->register }}</h5>
                                                </div>
                                                <div class="card-body">
                                                    @php  $data = $meter->lastReading() @endphp
                                                    <p class="card-text my-0">{{ $data->month_ref }} /
                                                        {{ $data->year_ref }} </p>
                                                    <p class="card-text my-0">Consumo em m<sup>3</sup>:
                                                        {{ Str::limit($data->volume_consumed, 11, '') }}</p>
                                                    <p class="card-text my-0">Consumo anterior em m<sup>3</sup>:
                                                        {{ Str::limit($data->previous_volume_consumed, 11, '') }}</p>
                                                    <p class="card-text my-0">Porcentagem Comparativa:
                                                        <span
                                                            class="
                                                            {{ str_contains($data->comparative_percentage, '-') ? 'bg-success' : ($data->comparative_percentage == 'Inexistente' ? '' : 'bg-warning') }}">{{ $data->comparative_percentage }}</span>
                                                    </p>
                                                </div>
                                                <div class="card-footer">
                                                    <a href="#" class="card-link">Visualizar</a>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-sm-3 col-6">
                                        <div class="description-block border-right">
                                            <span class="description-percentage text-success"><i
                                                    class="fas fa-caret-up"></i> 17%</span>
                                            <h5 class="description-header">$35,210.43</h5>
                                            <span class="description-text">TOTAL REVENUE</span>
                                        </div>

                                    </div>

                                    <div class="col-sm-3 col-6">
                                        <div class="description-block border-right">
                                            <span class="description-percentage text-warning"><i
                                                    class="fas fa-caret-left"></i> 0%</span>
                                            <h5 class="description-header">$10,390.90</h5>
                                            <span class="description-text">TOTAL COST</span>
                                        </div>

                                    </div>

                                    <div class="col-sm-3 col-6">
                                        <div class="description-block border-right">
                                            <span class="description-percentage text-success"><i
                                                    class="fas fa-caret-up"></i> 20%</span>
                                            <h5 class="description-header">$24,813.53</h5>
                                            <span class="description-text">TOTAL PROFIT</span>
                                        </div>

                                    </div>

                                    <div class="col-sm-3 col-6">
                                        <div class="description-block">
                                            <span class="description-percentage text-danger"><i
                                                    class="fas fa-caret-down"></i> 18%</span>
                                            <h5 class="description-header">1200</h5>
                                            <span class="description-text">GOAL COMPLETIONS</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection


@section('custom_js')
    @foreach ($residences as $residence)
        {{-- {{ $residence->apartment->getYarlyConsumtion() }} --}}
        <script>
            const ctx{!! $loop->index !!} = document.getElementById("chart-appartment-reading-{!! $loop->index !!}");
            if (ctx{!! $loop->index !!}) {
                ctx{!! $loop->index !!}.getContext('2d');
                const myChart{!! $loop->index !!} = new Chart(ctx{!! $loop->index !!}, {
                    type: 'line',
                    data: {
                        labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Agosto',
                            'Setembro', 'Outubro', 'Novembro', 'Dezembro'
                        ],
                        datasets: [{
                            label: 'Volume Consumido em m3',
                            data: {!! json_encode($residence->apartment->getYarlyConsumtion()) !!},
                            borderWidth: 1,
                            borderColor: '#007bff',
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        legend: {
                            position: 'top',
                        },
                    },
                });
            }
        </script>
    @endforeach
@endsection
