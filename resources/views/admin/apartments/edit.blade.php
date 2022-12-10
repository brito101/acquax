@extends('adminlte::page')
@section('plugins.select2', true)

@section('title', '- Edição de Apartamento')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-home"></i> Editar Apartamento</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.apartments.index') }}">Apartamentos</a></li>
                        <li class="breadcrumb-item active">Editar Apartamento</li>
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
                            <h3 class="card-title">Dados Cadastrais do Apartamento</h3>
                            <small class="float-right text-black-50">Criado por {{ $apartment->user->name }} em
                                {{ date('d/m/Y H:i', strtotime($apartment->created_at)) }}</small>
                        </div>


                        <form method="POST"
                            action="{{ route('admin.apartments.update', ['apartment' => $apartment->id]) }}">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="id" value="{{ $apartment->id }}">
                            <input type="hidden" name="from" value="{{ url()->previous() }}">
                            <div class="card-body">

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="name">Nome do Apartamento</label>
                                        <input type="text" class="form-control" id="name"
                                            placeholder="Nome do Apartamento" name="name"
                                            value="{{ old('name') ?? $apartment->name }}" required>
                                    </div>
                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="fraction">Fração Ideal</label>
                                        <input type="text" class="form-control" id="fraction" placeholder="Fração Ideal"
                                            name="fraction" value="{{ old('fraction') ?? $apartment->fraction }}">
                                    </div>
                                    <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                        <label for="status">Status do Apartamento</label>
                                        <x-adminlte-select2 name="status">
                                            <option
                                                {{ old('status') == 'Ativo' ? 'selected' : ($apartment->status == 'Ativo' ? 'selected' : '') }}>
                                                Ativo</option>
                                            <option
                                                {{ old('status') == 'Inativo' ? 'selected' : ($apartment->status == 'Inativo' ? 'selected' : '') }}>
                                                Inativo</option>
                                        </x-adminlte-select2>
                                    </div>

                                </div>
                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="block_id">Bloco</label>
                                        <x-adminlte-select2 name="block_id">
                                            @foreach ($blocks->toArray() as $block)
                                                <option
                                                    {{ old('block_id') == $block['id'] ? 'selected' : ($apartment->block_id == $block['id'] ? 'selected' : '') }}
                                                    value="{{ $block['id'] }}">
                                                    {{ $block['name'] }}
                                                </option>
                                            @endforeach
                                        </x-adminlte-select2>
                                    </div>

                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Enviar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('custom_js')
    <script src="{{ asset('vendor/jquery/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ asset('js/apartment.js') }}"></script>
@endsection
