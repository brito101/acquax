@extends('adminlte::page')

@section('title', '- Gerencial: Leituras X Leituristas')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-chart-bar"></i> Leituras X Leituristas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Leituras X Leituristas</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">Qtd de condomínios com leituras executadas por leituristas</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="position-relative mb-4">
                        <div class="chartjs-size-monitor" z>
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas id="meter-readings" style="display: block; width: 489px; height: 300px;"
                            class="chartjs-render-monitor" width="489" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('custom_js')
    <script src="{{ asset('vendor/chart.js/Chart.bundle.min.js') }}"></script>
    <script>
        const meterReadings = document.getElementById('meter-readings');
        if (meterReadings) {
            const meterReadingsChart = new Chart(meterReadings, {
                type: 'bar',
                data: {
                    labels: ({!! json_encode($chart->labels) !!}),
                    datasets: [{
                        label: '',
                        data: {!! json_encode($chart->dataset) !!},
                        backgroundColor: [
                            'rgba(0, 63, 92, 0.5)',
                            'rgba(47, 75, 124, 0.5)',
                            'rgba(102, 81, 145, 0.5)',
                            'rgba(160, 81, 149, 0.5)',
                            'rgba(212, 80, 135, 0.5)',
                            'rgba(249, 93, 106, 0.5)',
                            'rgba(255, 124, 67, 0.5)',
                            'rgba(255, 166, 0, 0.5)'
                        ],
                        borderColor: [
                            'rgba(0, 63, 92)',
                            'rgb(47, 75, 124)',
                            'rgb(102, 81, 145)',
                            'rgb(160, 81, 149)',
                            'rgb(212, 80, 135)',
                            'rgb(249, 93, 106)',
                            'rgb(255, 124, 67)',
                            'rgb(255, 166, 0)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }],
                        xAxes: [{
                            barThickness: 50,
                            maxBarThickness: 50
                        }]
                    },
                    legend: {
                        labels: {
                            boxWidth: 0,
                        }
                    },
                },
            });
        }
    </script>
@endsection
