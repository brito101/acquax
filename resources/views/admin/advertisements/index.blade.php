@extends('adminlte::page')

@section('title', '- Propagandas')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-bullhorn"></i> Propagandas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Propagandas</li>
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
                                <h3 class="card-title align-self-center">Propagandas Cadastradas</h3>
                                @can('Criar Propagandas')
                                    <a href="{{ route('admin.advertisements.create') }}" title="Nova Propaganda"
                                        class="btn btn-success"><i class="fas fa-fw fa-plus"></i>Nova Propaganda</a>
                                @endcan
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="d-flex flex-wrap justify-content-start">
                                @forelse ($advertisements as $advertisement)
                                    <div class="col-12 col-md-4">
                                        <div class="card p-2">
                                            <img src="{{ Storage::url('advertisements/' . $advertisement->cover) }}"
                                                class="card-img-top" alt="{{ $advertisement->title }}"
                                                style="min-height: 200px; max-height: 200px; object-fit: cover">
                                            <div class="card-body">
                                                <h5 class="card-title mb-2">{{ $advertisement->title }}</h5>
                                                <p class="card-text">
                                                    <a href="{{ $advertisement->link }}" target="_blank"
                                                        class="card-text text-muted">{{ $advertisement->link }}</a>
                                                </p>
                                                <p>
                                                    <span class="badge badge-info">{{ $advertisement->status }}</span>
                                                </p>
                                                <p class="card-text text-right text-muted">Visualizações:
                                                    {{ $advertisement->views }}</p>
                                            </div>
                                            <div class="card-footer">
                                                <div class="row d-flex flex-wrap justify-content-center">
                                                    <div class="col-12 col-md-6">
                                                        <a href="{{ route('admin.advertisements.edit', ['advertisement' => $advertisement->id]) }}"
                                                            class="btn btn-primary w-100 m-1">Editar</a>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <a href="advertisements/destroy/{{ $advertisement->id }}"
                                                            class="btn btn-danger w-100 m-1">Excluir</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p>Não há propagandas cadastradas</p>
                                @endforelse
                            </div>
                        </div>

                        <div class="card-footer">
                            <nav aria-label="Advertisements Page Navigation">
                                <ul class="pagination justify-content-center m-0">
                                    {{ $advertisements->appends(request()->input())->links() }}
                                </ul>
                            </nav>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
