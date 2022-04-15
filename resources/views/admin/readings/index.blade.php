@extends('adminlte::page')

@section('title', '- Leituras de Medidores')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-chart-line"></i> Leituras de Medidores</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Leituras de Medidores</li>
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
                    <div class="card card-solid">
                        <div class="card-header">
                            <div class="d-flex flex-wrap justify-content-between col-12 align-content-center">
                                <h3 class="card-title align-self-center">Leituras Cadastradas</h3>
                                @can('Criar Leituras')
                                    <a href="{{ route('admin.readings.create') }}" title="Nova Leitura"
                                        class="btn btn-success"><i class="fas fa-fw fa-plus"></i>Nova Leitura</a>
                                @endcan
                            </div>
                        </div>

                        <div class="card-body pb-0">
                            <div class="row">
                                @forelse ($readings as $reading)
                                    <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                                        <div class="card bg-light d-flex flex-fill">
                                            <div class="card-header text-muted border-bottom-0">
                                                Leitura #{{ $reading->id }}
                                            </div>
                                            <div class="card-body pt-0">
                                                <div class="row">
                                                    <div class="col-7">
                                                        <p class="text-muted text-sm py-0 my-0"><b>Leitura:</b>
                                                            {{ round($reading->reading, 3) }}
                                                        </p>
                                                        <p class="text-muted text-sm py-0 my-0"><b>Mês Ref:</b>
                                                            {{ $reading->month_ref }}
                                                        </p>
                                                        <p class="text-muted text-sm py-0 my-0"><b>Data da leitura:</b>
                                                            {{ $reading->reading_date }}
                                                        </p>
                                                        <p class="text-muted text-sm py-0 my-0"><b>Próxima leitura:</b>
                                                            {{ $reading->reading_date_next }}
                                                        </p>
                                                    </div>
                                                    <div class="col-5 text-center">
                                                        @if ($reading->cover_base64)
                                                            <img src="{{ url('storage/readings/' . $reading->cover_base64) }}"
                                                                alt="Imagem da Leitura" class="img-circle img-fluid"
                                                                style="object-fit: cover; width: 100%; height: 112px;">
                                                        @elseif ($reading->cover)
                                                            <img src="{{ url('storage/readings/' . $reading->cover) }}"
                                                                alt="Imagem da Leitura" class="img-circle img-fluid"
                                                                style="object-fit: cover; width: 100%; height: 112px;">
                                                        @else
                                                            <img src="{{ asset('img/no-image.png') }}"
                                                                alt="Sem Imagem de Leitura" class="img-circle img-fluid"
                                                                style="object-fit: cover; width: 100%; height: 112px;">
                                                        @endif
                                                    </div>
                                                    <div class="col-12 pt-2 text-center">
                                                        <h2 class="lead">
                                                            <b>{{ 'Condomínio ' .$reading->meter->apartment->getComplexNameAttribute() .' - Bl. ' .$reading->meter->apartment->getBlockNameAttribute() .' - Ap. ' .$reading->meter->apartment['name'] }}</b>
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <div class="text-center d-flex flex-wrap justify-content-center">
                                                    <a href="{{ route('admin.readings.edit', ['reading' => $reading->id]) }}"
                                                        class="btn btn-sm btn-primary mr-2">
                                                        <i class="fas fa-edit mr-2"></i>Editar</a>

                                                    <a href="readings/destroy/{{ $reading->id }}"
                                                        class="btn btn-sm btn-danger ml-2"
                                                        onclick="return confirm('Confirma a exclusão desta leitura?')">
                                                        <i class="fas fa-trash mr-2"></i>Excluir
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @empty
                                    <p>Não há leituras cadastradas</p>
                                @endforelse
                            </div>
                        </div>

                        <div class="card-footer">
                            <nav aria-label="Readings Page Navigation">
                                <ul class="pagination justify-content-center m-0">
                                    {{ $readings->links() }}
                                </ul>
                            </nav>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
