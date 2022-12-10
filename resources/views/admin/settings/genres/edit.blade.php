@extends('adminlte::page')

@section('title', '- Editar Gênero')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-genderless"></i> Editar Gênero</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Configurações</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.genres.index') }}">Gêneros</a></li>
                        <li class="breadcrumb-item active">Editar Gênero</li>
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
                            <h3 class="card-title">Dados Cadastrais do Gênero</h3>
                            <small class="float-right text-black-50">Criado por {{ $genre->user->name }} em
                                {{ date('d/m/Y H:i', strtotime($genre->created_at)) }}</small>
                        </div>

                        <form method="POST" action="{{ route('admin.genres.update', ['genre' => $genre->id]) }}">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="id" value="{{ $genre->id }}">
                            <div class="card-body">
                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="name">Nome do Gênero</label>
                                        <input type="text" class="form-control" id="name"
                                            placeholder="Nome do Gênero" name="name"
                                            value="{{ old('name') ?? $genre->name }}" required>
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="acronym">Abreviatura</label>
                                        <input type="text" class="form-control" id="acronym" placeholder="Abreviatura"
                                            name="acronym" value="{{ old('acronym') ?? $genre->acronym }}">
                                    </div>
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Atualizar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('adminlte_js')
    <script src="{{ asset('vendor/jquery/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ asset('js/company.js') }}"></script>
@endsection
