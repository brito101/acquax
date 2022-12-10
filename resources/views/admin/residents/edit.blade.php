@extends('adminlte::page')
@section('plugins.select2', true)

@section('title', '- Edição de Morador')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-house-user"></i> Editar Morador</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.residents.index') }}">Moradores</a></li>
                        <li class="breadcrumb-item active">Editar Morador</li>
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
                            <h3 class="card-title">Dados Cadastrais do Morador</h3>
                            <small class="float-right text-black-50">Criado por {{ $resident->editorName()->name }} em
                                {{ date('d/m/Y H:i', strtotime($resident->created_at)) }}</small>
                        </div>


                        <form method="POST" action="{{ route('admin.residents.update', ['resident' => $resident->id]) }}">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="id" value="{{ $resident->id }}">
                            <input type="hidden" name="from" value="{{ url()->previous() }}">
                            <div class="card-body">

                                <div class="col-12 form-group px-0 pr-md-2">
                                    <label for="user_id">Morador</label>
                                    <x-adminlte-select2 name="user_id">
                                        @foreach ($users as $user)
                                            <option
                                                {{ old('user_id') == $user->id ? 'selected' : ($resident->user_id == $user->id ? 'selected' : '') }}
                                                value="{{ $user->id }}">
                                                {{ $user->name . ' - CPF: ' . $user->document_person . ' - E-mail: ' . $user->email }}
                                            </option>
                                        @endforeach
                                    </x-adminlte-select2>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="apartment_id">Apartamento</label>
                                        <x-adminlte-select2 name="apartment_id">
                                            @foreach ($apartments as $apartment)
                                                <option
                                                    {{ old('apartment_id') == $apartment->id ? 'selected' : ($resident->apartment_id == $apartment->id ? 'selected' : '') }}
                                                    value="{{ $apartment->id }}">
                                                    {{ 'Condomínio ' . $apartment->getComplexNameAttribute() . ' - Bloco ' . $apartment->getBlockNameAttribute() . ' - Apartamento ' . $apartment->name }}
                                                </option>
                                            @endforeach
                                        </x-adminlte-select2>
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="status">Status</label>
                                        <x-adminlte-select2 name="status">
                                            <option
                                                {{ old('status') == 'Ativo' ? 'selected' : ($resident->status == 'Ativo' ? 'selected' : '') }}>
                                                Ativo</option>
                                            <option
                                                {{ old('status') == 'Inativo' ? 'selected' : ($resident->status == 'Inativo' ? 'selected' : '') }}>
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
