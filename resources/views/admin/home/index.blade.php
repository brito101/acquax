@extends('adminlte::page')

@section('title', '- Dashboard')
@section('plugins.Chartjs', true)

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

    @can('Listar Eventos na Agenda')
        <section class="content mx-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-fw fa-calendar"></i> Agenda do Dia</h3>
                </div>
                <div class="card-body d-flex flex-wrap justify-content-start px-0 pb-0">
                    @forelse ($schedules as $schedule)
                        <div class="col-6 col-md-3 p-2">
                            @if ($schedule->type == null)
                                <a href="{{ route('admin.schedule.show', ['schedule' => $schedule->id]) }}"
                                    class="btn bg-{{ $schedule->color }} w-100 text-left"
                                    title="Evento na Agenda: {{ $schedule->title }}"><i class="fas fa-calendar"></i>
                                    {{ Str::limit($schedule->title, 15) }}</i>
                                </a>
                            @else
                                <a href="{{ route('admin.reading-schedule.show', ['reading_schedule' => $schedule->id]) }}"
                                    class="btn bg-{{ $schedule->color }} w-100 text-left" title="{{ $schedule->title }}"><i
                                        class="fas fa-calendar-check"></i>
                                    {{ Str::limit($schedule->title, 15) }}</i>
                                </a>
                            @endif
                        </div>
                    @empty
                        <p class="px-3">Não há agendamento de eventos para o dia</p>
                    @endforelse
                </div>
            </div>
        </section>
    @endcan

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-user-shield"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Administradores</span>
                            <span class="info-box-number">{{ $administrators }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-map-marked"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Condomínios</span>
                            <span class="info-box-number">{{ $complexes }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-building"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Blocos</span>
                            <span class="info-box-number">{{ $blocks }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-home"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Apartamentos</span>
                            <span class="info-box-number">{{ $apartments }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-tachometer-alt"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Medidores</span>
                            <span class="info-box-number">{{ $meters }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-user-friends"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Síndicos</span>
                            <span class="info-box-number">{{ $syndics }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-teal elevation-1"><i class="fas fa-house-user"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Moradores</span>
                            <span class="info-box-number">{{ $residents }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-indigo elevation-1"><i class="fas fa-chart-line"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Leituras</span>
                            <span class="info-box-number">{{ $readings }}</span>
                        </div>
                    </div>
                </div>


            </div>


            <div class="row px-0">
                <div class="col-12 col-lg-6">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Usuários Online: <span id="onlineusers">{{ $onlineUsers }}</span>
                                </h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="text-bold text-lg" id="accessdaily">{{ $access }}</span>
                                    <span>Acessos Diários</span>
                                </p>
                                <p class="ml-auto d-flex flex-column text-right">
                                    <span id="percentclass" class="{{ $percent > 0 ? 'text-success' : 'text-danger' }}">
                                        <i id="percenticon"
                                            class="fas {{ $percent > 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}  mr-1"></i><span
                                            id="percentvalue">{{ $percent }}</span>%
                                    </span>
                                    <span class="text-muted">em relação ao dia anterior</span>
                                </p>
                            </div>

                            <div class="position-relative mb-4">
                                <div class="chartjs-size-monitor" z>
                                    <div class="chartjs-size-monitor-expand">
                                        <div class=""></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                        <div class=""></div>
                                    </div>
                                </div>
                                <canvas id="visitors-chart" style="display: block; width: 489px; height: 200px;"
                                    class="chartjs-render-monitor" width="489" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-6" style="display: block; height: 300px;">
                    <div class="card">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Páginas mais Vistas na Aplicação</span>
                                </h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="position-relative mb-4" style="display: block; width: 100%; height: auto;">
                                <div class="chartjs-size-monitor">
                                    <div class="chartjs-size-monitor-expand">
                                        <div></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                        <div></div>
                                    </div>
                                </div>
                                <canvas id="topPageChart" class="chartjs-render-monitor" style="height: auto"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>
@endsection

@section('custom_js')

    <script>
        const ctx = document.getElementById('visitors-chart');
        if (ctx) {
            ctx.getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ({!! json_encode($chart->labels) !!}),
                    datasets: [{
                        label: 'Acessos por horário',
                        data: {!! json_encode($chart->dataset) !!},
                        borderWidth: 1,
                        borderColor: '#007bff',
                        backgroundColor: 'transparent'
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
                        labels: {
                            boxWidth: 0,
                        }
                    },
                },
            });

            let getData = function() {

                $.ajax({
                    url: "{{ route('admin.home.chart') }}",
                    type: "GET",
                    success: function(data) {
                        myChart.data.labels = data.chart.labels;
                        myChart.data.datasets[0].data = data.chart.dataset;
                        myChart.update();
                        $("#onlineusers").text(data.onlineUsers);
                        $("#accessdaily").text(data.access);
                        $("#percentvalue").text(data.percent);
                        const percentclass = $("#percentclass");
                        const percenticon = $("#percenticon");
                        percentclass.removeClass('text-success');
                        percentclass.removeClass('text-danger');
                        percenticon.removeClass('fa-arrow-up');
                        percenticon.removeClass('fa-arrow-down');
                        if (parseInt(data.percent) > 0) {
                            percentclass.addClass('text-success');
                            percenticon.addClass('fa-arrow-up');
                        } else {
                            percentclass.addClass('text-danger');
                            percenticon.addClass('fa-arrow-down');
                        }
                    }
                });
            };
            setInterval(getData, 60 * 1000);
        }

        const topPage = document.getElementById('topPageChart');
        if (topPage) {
            topPage.getContext('2d');
            const topPageChart = new Chart(topPage, {
                type: 'pie',
                data: {
                    labels: ({!! json_encode($topPages->labels) !!}),
                    datasets: [{
                        label: 'Páginas mais vistas',
                        data: {!! json_encode($topPages->dataset) !!},
                        borderWidth: 1,
                        backgroundColor: ['#2f4b7c', '#576191', '#7b78a7', '#9d90bc', '#beaad2', '#dfc5e8',
                            '#ffe1ff', '#ffccf1', '#ffb6de', '#ffa0c7', '#ff89ac', '#ff728c', '#f95d6a',
                        ],
                    }]
                },
                options: {
                    responsive: true,
                    legend: {
                        // display: false,
                        position: 'left',
                    },
                },
            });
        }
    </script>

@endsection
