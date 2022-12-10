@extends('adminlte::page')
@section('plugins.select2', true)

@section('title', '- Edição de Síndico')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-user-friends"></i> Editar Síndico</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.syndics.index') }}">Síndicos</a></li>
                        <li class="breadcrumb-item active">Editar Síndicos</li>
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
                            <h3 class="card-title">Dados Cadastrais do Síndico</h3>
                            <small class="float-right text-black-50">Criado por {{ $syndic->editorName()->name }} em
                                {{ date('d/m/Y H:i', strtotime($syndic->created_at)) }}</small>
                        </div>


                        <form method="POST" action="{{ route('admin.syndics.update', ['syndic' => $syndic->id]) }}">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="id" value="{{ $syndic->id }}">
                            <input type="hidden" name="from" value="{{ url()->previous() }}">
                            <div class="card-body">

                                <div class="col-12 form-group px-0 pr-md-2">
                                    <label for="user_id">Síndico</label>
                                    <x-adminlte-select2 name="user_id">
                                        @foreach ($users as $user)
                                            <option
                                                {{ old('user_id') == $user->id ? 'selected' : ($syndic->user_id == $user->id ? 'selected' : '') }}
                                                value="{{ $user->id }}">
                                                {{ $user->name . ' - CPF: ' . $user->document_person . ' - E-mail: ' . $user->email }}
                                            </option>
                                        @endforeach
                                    </x-adminlte-select2>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="complex_id">Condomínio</label>
                                        <x-adminlte-select2 name="complex_id">
                                            @foreach ($complexes as $complex)
                                                <option
                                                    {{ old('complex_id') == $complex->id ? 'selected' : ($syndic->complex_id == $complex->id ? 'selected' : '') }}
                                                    value="{{ $complex->id }}">
                                                    {{ $complex->alias_name }}
                                                </option>
                                            @endforeach
                                        </x-adminlte-select2>
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="status">Status</label>
                                        <x-adminlte-select2 name="status">
                                            <option
                                                {{ old('status') == 'Ativo' ? 'selected' : ($syndic->status == 'Ativo' ? 'selected' : '') }}>
                                                Ativo</option>
                                            <option
                                                {{ old('status') == 'Inativo' ? 'selected' : ($syndic->status == 'Inativo' ? 'selected' : '') }}>
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
