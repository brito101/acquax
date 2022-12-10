@extends('adminlte::page')
@section('plugins.select2', true)

@section('title', '- Edição de Bloco')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-building"></i> Editar Bloco <br />
                        Condomínio {{ $block->complex['alias_name'] }}
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.blocks.index') }}">Blocos</a>
                        </li>
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
                            <small class="float-right text-black-50">Criado por {{ $block->user->name }} em
                                {{ date('d/m/Y H:i', strtotime($block->created_at)) }}</small>
                        </div>

                        <form method="POST" action="{{ route('admin.blocks.update', ['block' => $block->id]) }}">
                            @method('PUT')
                            @csrf

                            <input type="hidden" name="from" value="{{ url()->previous() }}">

                            <div class="card-body">

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="name">Nome do Bloco</label>
                                        <input type="text" class="form-control" id="name"
                                            placeholder="Nome do Bloco" name="name"
                                            value="{{ old('name') ?? $block->name }}" required>
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="status">Status do Bloco</label>
                                        <x-adminlte-select2 name="status">
                                            <option
                                                {{ old('status') == 'Ativo' ? 'selected' : ($block->status == 'Ativo' ? 'selected' : '') }}>
                                                Ativo</option>
                                            <option
                                                {{ old('status') == 'Inativo' ? 'selected' : ($block->status == 'Inativo' ? 'selected' : '') }}>
                                                Inativo</option>
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
