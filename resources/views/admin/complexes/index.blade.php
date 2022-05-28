@extends('adminlte::page')

@section('title', '- Condomínios')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-map-marked"></i> Condomínios</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Condomínios</li>
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
                                <h3 class="card-title align-self-center">Condomínios Cadastrados</h3>
                                @can('Criar Condomínios')
                                    <a href="{{ route('admin.complexes.create') }}" title="Novo Condomínio"
                                        class="btn btn-success"><i class="fas fa-fw fa-plus"></i>Novo Condomínio</a>
                                @endcan
                            </div>
                        </div>

                        <div class="card-body pb-0">
                            <div class="row">
                                @forelse ($complexes as $complex)
                                    <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                                        <div class="card bg-light d-flex flex-fill">
                                            <div class="card-header text-muted border-bottom-0">
                                                Condomínio #{{ $complex->id }}
                                            </div>
                                            <div class="card-body pt-0">
                                                <div class="row">
                                                    <div class="col-7">
                                                        <h2 class="lead"><b>{{ $complex->alias_name }}</b></h2>
                                                        <p class="text-muted text-sm mb-n1">Qtd de
                                                            Blocos: {{ $complex->blocks->count() }}
                                                        </p>
                                                        <p class="text-muted text-sm">Qtd de Apts:
                                                            {{ $complex->apartments->count() }}</p>
                                                        <p class="text-muted text-sm">Síndicos</p>
                                                        <ul class="ml-4 mb-0 fa-ul text-muted">
                                                            <li class="small"><span class="fa-li"><i
                                                                        class="fas fa-lg fa-building"></i></span>
                                                                {{ $complex->city }}-{{ $complex->state }}
                                                            </li>
                                                            <li class="small"><span class="fa-li"><i
                                                                        class="fas fa-lg fa-phone"></i></span>
                                                                {{ $complex->telephone }}
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="col-5 text-center">
                                                        @if ($complex->photo)
                                                            <img src="{{ url('storage/complexes/' . $complex->photo) }}"
                                                                alt="{{ $complex->alias_name }}"
                                                                class="img-circle img-fluid"
                                                                style="object-fit: cover; width: 100%; aspect-ratio: 1;">
                                                        @else
                                                            <img src="{{ asset('img/building.png') }}"
                                                                alt="{{ $complex->alias_name }}"
                                                                class="img-circle img-fluid">
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <div class="text-center d-flex flex-wrap justify-content-center">
                                                    <div class="col-6">
                                                        <a href="{{ route('admin.complexes.edit', ['complex' => $complex->id]) }}"
                                                            class="btn btn-sm btn-primary w-100">
                                                            <i class="fas fa-edit mr-2"></i>Editar</a>
                                                    </div>
                                                    <div class="col-6">
                                                        <a href="complexes/destroy/{{ $complex->id }}"
                                                            class="btn btn-sm btn-danger w-100"
                                                            onclick="return confirm('Confirma a exclusão deste condomínio?')">
                                                            <i class="fas fa-trash mr-2"></i>Excluir
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="text-center d-flex flex-wrap justify-content-center pt-2">
                                                    <div class="col-6">
                                                        <a href="{{ route('admin.blocks.index', ['complex' => $complex->id]) }}"
                                                            class="btn btn-sm btn-success w-100">
                                                            <i class="fas fa-building mr-2"></i>Blocos</a>
                                                    </div>
                                                    @if ($complex->blocks->count() > 0)
                                                        <div class="col-6">
                                                            <a href="{{ route('admin.apartments.index', ['complex' => $complex->id]) }}"
                                                                class="btn btn-sm btn-info w-100">
                                                                <i class="fas fa-home mr-2"></i>Apts</a>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="text-center d-flex flex-wrap justify-content-center pt-2">
                                                    <div class="col-6">
                                                        <a href="{{ route('admin.syndics.index', ['complex' => $complex->id]) }}"
                                                            class="btn btn-sm btn-secondary w-100">
                                                            <i class="fas fa-users"></i>Síndicos
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @empty
                                    <p>Não há condomínios cadastrados</p>
                                @endforelse
                            </div>
                        </div>

                        <div class="card-footer">
                            <nav aria-label="Complexes Page Navigation">
                                <ul class="pagination justify-content-center m-0">
                                    {{ $complexes->links() }}
                                </ul>
                            </nav>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
