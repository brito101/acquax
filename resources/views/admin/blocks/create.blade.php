@extends('adminlte::page')
@section('plugins.select2', true)

@section('title', '- Cadastro de Bloco')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @if ($complex->count() <= 1)
                        <h1><i class="fas fa-fw fa-building"></i> Novo Bloco no Condomínio: <br />
                            <span class="text-primary">{{ $complex->alias_name }}</span>
                        </h1>
                    @else
                        <h1><i class="fas fa-fw fa-building"></i> Novo Bloco</h1>
                    @endif
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.blocks.index') }}">Blocos</a></li>
                        <li class="breadcrumb-item active">Novo Bloco</li>
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
                            <h3 class="card-title">Dados Cadastrais do Bloco</h3>
                        </div>

                        @if ($complex instanceof Illuminate\Database\Eloquent\Collection)
                            <form method="POST" action="{{ route('admin.blocks.store', ['complex' => 'new']) }}">
                            @else
                                <form method="POST"
                                    action="{{ route('admin.blocks.store', ['complex' => $complex->id]) }}">
                                    <input type="hidden" name="from" value="{{ $complex->id }}">
                        @endif
                        @csrf
                        <div class="card-body">

                            <div class="d-flex flex-wrap justify-content-between">
                                <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                    <label for="name">Nome do Bloco</label>
                                    <input type="text" class="form-control" id="name" placeholder="Nome do Bloco"
                                        name="name" value="{{ old('name') }}" required>
                                </div>
                                <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                    <label for="status">Status do Bloco</label>
                                    <x-adminlte-select2 name="status">
                                        <option {{ old('status') == 'Ativo' ? 'selected' : '' }}>Ativo</option>
                                        <option {{ old('status') == 'Inativo' ? 'selected' : '' }}>Inativo</option>
                                    </x-adminlte-select2>
                                </div>

                            </div>
                            @if ($complex instanceof Illuminate\Database\Eloquent\Collection)
                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="complex_id">Condomínio</label>
                                        <x-adminlte-select2 name="complex_id">
                                            @foreach ($complex as $item)
                                                <option {{ old('complex_id') == $item->id ? 'selected' : '' }}
                                                    value="{{ $item->id }}">
                                                    {{ $item->alias_name }}</option>
                                            @endforeach
                                        </x-adminlte-select2>
                                    </div>

                                </div>
                            @endif

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