@extends('adminlte::page')
@section('plugins.Chartjs', true)

@section('title', '- Dashboard')

@section('content')

    @if ($advertisement)
        <x-adminlte-modal id="advertisementModal" title="{{ $advertisement->title }}" size="lg" theme="light"
            icon="fas fa-gift" v-centered scrollable>
            <div>
                <img src="{{ Storage::url('advertisements/' . $advertisement->cover) }}"
                    class="card-img-top img-fluid rounded" alt="{{ $advertisement->title }}"
                    style="max-height: 800px; object-fit: cover">
            </div>
            <x-slot name="footerSlot">
                <a href="{{ $advertisement->link }}" target="_blank" class="btn btn-primary ml-auto" theme="primary">Saiba
                    Mais!</a>
            </x-slot>
        </x-adminlte-modal>
        <x-adminlte-button label="Abrir Modal" data-toggle="modal" data-target="#advertisementModal" class="bg-teal"
            id="advertisementModalButton" class="d-none" />
    @endif

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-tachometer-alt"></i> Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>

                        @if ($notifications->count() > 0)
                            <li class="nav-item dropdown show mb-n3">
                                <a class="nav-link text-danger" data-toggle="dropdown" href="#" aria-expanded="true">
                                    <i class="far fa-bell fa-2x"></i>
                                    <span class="badge badge-warning navbar-badge">{{ $notifications->count() }}</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right"
                                    style="left: inherit; right: 0px;">
                                    <span class="dropdown-item dropdown-header">{{ $notifications->count() }}
                                        {{ $notifications->count() == 1 ? 'Notificação' : 'Notificações' }}</span>
                                    <div class="dropdown-divider"></div>
                                    @foreach ($notifications as $notification)
                                        <p class="px-2">{{ $notification->message }} <span
                                                class="float-right text-muted text-sm">{{ date('d/m/Y H:i', strtotime($notification->created_at)) }}</span>
                                        </p>
                                        <a href="{{ route('app.notificationRead', ['notification' => $notification->id]) }}"
                                            class="dropdown-item bg-gradient-blue notification" style="white-space: unset;">
                                            Marcar como lido
                                        </a>
                                        <div class="dropdown-divider"></div>
                                    @endforeach
                                </div>
                            </li>
                        @endif
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <section class="content">
        <div class="container-fluid">
            @include('components.alert')
            <div>
                <h4 class="text-center text-primary font-weight-bold">Consumo de Água</h4>
            </div>
            @if ($complexes)
                @foreach ($complexes as $complex)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-gradient-info">
                                    <h5 class="card-title">Condomínio {{ $complex->alias_name }}</h5>
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
                                        <div class="col-md-8 d-flex flex-wrap justify-content-center align-content-center">
                                            <p class="text-center">
                                                <strong>Gráfico de Consumo {{ date('Y') }}</strong>
                                            </p>
                                            <div class="chart col-12">
                                                <div class="chartjs-size-monitor">
                                                    <div class="chartjs-size-monitor-expand">
                                                        <div class=""></div>
                                                    </div>
                                                    <div class="chartjs-size-monitor-shrink">
                                                        <div class=""></div>
                                                    </div>
                                                </div>

                                                <canvas style="height: 250px; display: block; width: 684px;"
                                                    id="chart-complex-reading-{{ $loop->index }}"
                                                    class="chart-complex-reading" width="684" height="250px"></canvas>
                                            </div>

                                        </div>

                                        <div class="col-md-4">
                                            <p class="text-center">
                                                <strong>Dados da Última Leitura</strong>
                                            </p>
                                            @php  $data = $complex->lastReading() @endphp
                                            @if ($data)
                                                <div class="card">
                                                    <div class="card-header bg-light">
                                                        <h5 class="card-title">Concessionária:
                                                            {{ $data->dealership['name'] }}
                                                        </h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <p class="card-text my-0">{{ $data->month_ref }} /
                                                            {{ $data->year_ref }} </p>
                                                        <p class="card-text my-0">Consumo em m<sup>3</sup>:
                                                            {{ Str::limit($data->monthly_consumption, 11, '') }}</p>
                                                        <p class="card-text my-0">Consumo anterior em m<sup>3</sup>:
                                                            {{ Str::limit($data->previous_monthly_consumption, 11, '') }}
                                                        </p>
                                                    </div>
                                                    <div class="card-footer">
                                                        <a href="{{ route('app.residences.readings.complex', ['reading' => $data->id, 'complex' => $complex->id]) }}"
                                                            class="card-link">Visualizar</a>
                                                    </div>
                                                </div>
                                            @else
                                                <p class="text-center text-muted">Não há dados disponíveis</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-sm-3 col-6">
                                            <div class="description-block border-right">
                                                <h5 class="description-header">
                                                    {{ number_format($complex->getAverageConsume(), 2, ',', '.') }}
                                                    m<sup>3</sup>
                                                </h5>
                                                <span class="description-text">Consumo médio anual</span>
                                            </div>

                                        </div>

                                        <div class="col-sm-3 col-6">
                                            <div class="description-block border-right">
                                                <h5 class="description-header">
                                                    {{ number_format($complex->getTotalConsume(), 2, ',', '.') }}
                                                    m<sup>3</sup>
                                                </h5>
                                                <span class="description-text">Consumo total anual</span>
                                            </div>

                                        </div>

                                        <div class="col-sm-3 col-6">
                                            <div class="description-block border-right">
                                                <h5 class="description-header">
                                                    {{ 'R$ ' . number_format($complex->getAverageCost(), 2, ',', '.') }}
                                                </h5>
                                                <span class="description-text">Custo médio anual</span>
                                            </div>

                                        </div>

                                        <div class="col-sm-3 col-6">
                                            <div class="description-block">
                                                <h5 class="description-header">
                                                    {{ 'R$ ' . number_format($complex->getAverageCommonArea(), 2, ',', '.') }}
                                                </h5>
                                                <span class="description-text">Custo médio área comum anual</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
            @if ($residences)
                @foreach ($residences as $residence)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-gradient-blue">
                                    <h5 class="card-title">
                                        {{ $residence->apartment->block->complex['alias_name'] }} -
                                        Bl: {{ $residence->apartment->block['name'] }} -
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
                                        <div class="col-md-8 d-flex flex-wrap justify-content-center align-content-center">
                                            <p class="text-center">
                                                <strong>Gráfico de Consumo {{ date('Y') }}</strong>
                                            </p>
                                            <div class="chart col-12">
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
                                                    class="chart-appartment-reading" width="684"
                                                    height="250px"></canvas>
                                            </div>

                                        </div>

                                        <div class="col-md-4">
                                            <p class="text-center">
                                                <strong>Dados da Última Leitura</strong>
                                            </p>
                                            @forelse ($residence->apartment->meter as $meter)
                                                @php  $data = $meter->lastReading() @endphp
                                                @if ($data)
                                                    <div class="card">
                                                        <div class="card-header bg-light">
                                                            <h5 class="card-title">Medidor: {{ $meter->register }}
                                                            </h5>
                                                            @if ($meter->location)
                                                                <span
                                                                    class="text-muted badge">{{ $meter->location }}</span>
                                                            @endif
                                                        </div>
                                                        <div class="card-body">
                                                            <p class="card-text my-0">{{ $data->month_ref }} /
                                                                {{ $data->year_ref }} </p>
                                                            <p class="card-text my-0">Consumo em m<sup>3</sup>:
                                                                {{ Str::limit($data->volume_consumed, 11, '') }}</p>
                                                            <p class="card-text my-0">Consumo anterior em m<sup>3</sup>:
                                                                {{ Str::limit($data->previous_volume_consumed, 11, '') }}
                                                            </p>
                                                            <p class="card-text my-0">Porcentagem Comparativa:
                                                                <span
                                                                    class="
                                                            {{ str_contains($data->comparative_percentage, '-') ? 'bg-success' : ($data->comparative_percentage == 'Inexistente' ? '' : 'bg-warning') }}">{{ $data->comparative_percentage }}</span>
                                                            </p>
                                                        </div>
                                                        <div class="card-footer">
                                                            <a href="{{ route('app.meter.readings.show', ['reading' => $data->id]) }}"
                                                                class="card-link">Visualizar</a>
                                                        </div>
                                                    </div>
                                                @else
                                                    <p class="text-center text-muted">Não há dados disponíveis</p>
                                                @endif
                                            @empty
                                                <div class="card">
                                                    <div class="card-header bg-light">
                                                        Não há dados para ser exibidos
                                                    </div>
                                                    <div class="card-body">
                                                        <p class="card-text">Ainda não há registros de leituras.</p>
                                                        <p class="card-text">Em breve, dados do seu imóvel serão
                                                            exibidos aqui.</p>
                                                    </div>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-sm-3 col-6">
                                            <div class="description-block border-right">
                                                <h5 class="description-header">
                                                    {{ number_format($residence->apartment->getAverageConsume(), 2, ',', '.') }}
                                                    m<sup>3</sup>
                                                </h5>
                                                <span class="description-text">Consumo médio anual</span>
                                            </div>

                                        </div>

                                        <div class="col-sm-3 col-6">
                                            <div class="description-block border-right">
                                                <h5 class="description-header">
                                                    {{ number_format($residence->apartment->getTotalConsume(), 2, ',', '.') }}
                                                    m<sup>3</sup>
                                                </h5>
                                                <span class="description-text">Consumo total anual</span>
                                            </div>

                                        </div>

                                        <div class="col-sm-3 col-6">
                                            <div class="description-block border-right">
                                                <h5 class="description-header">
                                                    {{ 'R$ ' . number_format($residence->apartment->getAverageCost(), 2, ',', '.') }}
                                                </h5>
                                                <span class="description-text">Custo médio anual</span>
                                            </div>

                                        </div>

                                        <div class="col-sm-3 col-6">
                                            <div class="description-block">
                                                <h5 class="description-header">
                                                    {{ 'R$ ' . number_format($residence->apartment->getAverageCommonArea(), 2, ',', '.') }}
                                                </h5>
                                                <span class="description-text">Custo médio área comum anual</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
            @if (!$complexes && count($residences) == 0)
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header bg-info">
                                Não há dados para ser exibidos
                            </div>
                            <div class="card-body">
                                <p class="card-text">Por favor, verifique com a administração do condomínio se sua
                                    conta foi vinculada a um imóvel, ou, no caso de possuir a função de síndico, se este
                                    cadastro foi realizado.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    @if (count($posts) > 0)
        <section class="py-4">
            <h2 class="mb-3"><i class="fas fa-fw fa-blog"></i> Confira nossas últimas postagens!</h2>
            <div class="col-12 d-flex flex-wrap justify-content-start px-0">
                @foreach ($posts as $post)
                    <div class="col-12 col-md-4">
                        <div class="card p-2">
                            <img src="{{ Storage::url('posts/' . $post->cover) }}" class="card-img-top shadow-sm"
                                alt="{{ $post->title }}"
                                style="min-height: 200px; max-height: 200px; object-fit: cover">
                            <div class="card-body">
                                <h5 class="card-title mb-2">{{ $post->title }}</h5>
                                <p class="card-text text-muted">{{ $post->headline }}</p>
                            </div>
                            <div class="card-footer">
                                <div class="row d-flex flex-wrap justify-content-center">
                                    <div class="col-12 col-md-6">
                                        <a href="{{ route('site.post', ['slug' => $post->slug]) }}"
                                            class="btn btn-success w-100 m-1" target="_blank">Acessar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif
@endsection


@section('custom_js')
    <script src="{{ asset('js/app-home.js') }}"></script>
    @if ($residences)
        @foreach ($residences as $residence)
            <script>
                const ctx{!! $loop->index !!} = document.getElementById("chart-appartment-reading-{!! $loop->index !!}");
                const datas{!! $loop->index !!} = {!! json_encode($residence->apartment->getValuesChart()) !!};
                const volume{!! $loop->index !!} = [];
                const percentual{!! $loop->index !!} = [];
                const commonArea{!! $loop->index !!} = [];
                const totalUnit{!! $loop->index !!} = [];
                datas{!! $loop->index !!}.forEach(el => {
                    volume{!! $loop->index !!}.push(el[0]);
                    percentual{!! $loop->index !!}.push(el[1]);
                    commonArea{!! $loop->index !!}.push(el[2]);
                    totalUnit{!! $loop->index !!}.push(el[3]);
                });

                if (ctx{!! $loop->index !!}) {
                    ctx{!! $loop->index !!}.getContext('2d');
                    const myChart{!! $loop->index !!} = new Chart(ctx{!! $loop->index !!}, {
                        type: 'line',
                        data: {
                            labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto',
                                'Setembro', 'Outubro', 'Novembro', 'Dezembro'
                            ],
                            datasets: [{
                                    label: 'Volume Consumido em m3',
                                    data: volume{!! $loop->index !!},
                                    borderWidth: 2,
                                    fill: false,
                                    borderColor: '#0B55DE',
                                    pointStyle: 'triangle',
                                },
                                {
                                    label: '% Comparativo',
                                    data: percentual{!! $loop->index !!},
                                    borderWidth: 2,
                                    fill: false,
                                    borderColor: '#E5750B',
                                    pointStyle: 'circle',
                                },
                                {
                                    label: 'Área Comum em m3',
                                    data: commonArea{!! $loop->index !!},
                                    borderWidth: 2,
                                    fill: false,
                                    borderColor: '#01E044',
                                    pointStyle: 'rect',
                                },
                                {
                                    label: 'Total em Reais',
                                    data: totalUnit{!! $loop->index !!},
                                    borderWidth: 2,
                                    fill: false,
                                    borderColor: '#E0D900',
                                    pointStyle: 'cross',
                                }
                            ]
                        },
                        options: {
                            maintainAspectRatio: false,
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: false
                                }
                            },
                            legend: {
                                position: 'bottom',
                                align: 'center',
                                labels: {
                                    boxWidth: 20
                                }
                            },
                        },
                    });
                }
            </script>
        @endforeach
    @endif

    @if ($complexes)
        @foreach ($complexes as $complex)
            <script>
                const cty{!! $loop->index !!} = document.getElementById("chart-complex-reading-{!! $loop->index !!}");
                const datasY{!! $loop->index !!} = {!! json_encode($complex->getValuesChart()) !!};
                const volumeY{!! $loop->index !!} = [];
                const commonAreaY{!! $loop->index !!} = [];
                const totalY{!! $loop->index !!} = [];
                datasY{!! $loop->index !!}.forEach(el => {
                    volumeY{!! $loop->index !!}.push(el[0]);
                    commonAreaY{!! $loop->index !!}.push(el[1]);
                    totalY{!! $loop->index !!}.push(el[2]);
                });

                if (cty{!! $loop->index !!}) {
                    cty{!! $loop->index !!}.getContext('2d');
                    const myChartY{!! $loop->index !!} = new Chart(cty{!! $loop->index !!}, {
                        type: 'line',
                        data: {
                            labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto',
                                'Setembro', 'Outubro', 'Novembro', 'Dezembro'
                            ],
                            datasets: [{
                                    label: 'Volume Consumido em m3',
                                    data: volumeY{!! $loop->index !!},
                                    borderWidth: 2,
                                    fill: false,
                                    borderColor: '#0B55DE',
                                    pointStyle: 'triangle',
                                },
                                {
                                    label: 'Área Comum em m3',
                                    data: commonAreaY{!! $loop->index !!},
                                    borderWidth: 2,
                                    fill: false,
                                    borderColor: '#01E044',
                                    pointStyle: 'rect',
                                },
                                {
                                    label: 'Total em Reais',
                                    data: totalY{!! $loop->index !!},
                                    borderWidth: 2,
                                    fill: false,
                                    borderColor: '#E0D900',
                                    pointStyle: 'cross',
                                }
                            ]
                        },
                        options: {
                            maintainAspectRatio: false,
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: false
                                }
                            },
                            legend: {
                                position: 'bottom',
                                align: 'center',
                                labels: {
                                    boxWidth: 20
                                }
                            },
                        },
                    });
                }
            </script>
        @endforeach
    @endif
@endsection
