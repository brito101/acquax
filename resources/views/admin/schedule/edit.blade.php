@extends('adminlte::page')
@section('plugins.BootstrapSelect', true)
@section('plugins.select2', true)

@section('title', '- Edição de Evento')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-calendar"></i> Editar Evento #{{ $schedule->id }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.schedule.index') }}">Agenda</a></li>
                        <li class="breadcrumb-item active">Editar Evento</li>
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
                            <h3 class="card-title">Dados Cadastrais do Evento</h3>
                        </div>


                        <form method="POST" action="{{ route('admin.schedule.update', ['schedule' => $schedule->id]) }}">
                            @method('PUT')
                            <input type="hidden" name="id" value="{{ $schedule->id }}">
                            @csrf
                            <div class="card-body">

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="title">Título do Evento</label>
                                        <input type="text" class="form-control" id="title"
                                            placeholder="Título do Evento" name="title"
                                            value="{{ old('title') ?? $schedule->title }}" required>
                                    </div>
                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="start">Início</label>
                                        <input type="datetime-local" class="form-control" id="start" name="start"
                                            value="{{ old('start') ?? $schedule->start }}" required>
                                    </div>
                                    <div class="col-12 col-md-3 form-group px-0 pl-md-2">
                                        <label for="end">Término</label>
                                        <input type="datetime-local" class="form-control" id="end" name="end"
                                            value="{{ old('end') ?? $schedule->end }}" required>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 form-group px-0">
                                        <div class="form-group">
                                            <label>Descrição</label>
                                            <textarea name="description" class="form-control" id="description" rows="3" placeholder="Descrição do evento">{{ old('description') ?? $schedule->description }} </textarea>
                                        </div>
                                    </div>
                                </div>

                                @php
                                    $config = [
                                        'title' => 'Selecione múltiplos...',
                                        'liveSearch' => true,
                                        'liveSearchPlaceholder' => 'Pesquisar...',
                                        'showTick' => true,
                                        'actionsBox' => true,
                                    ];
                                @endphp

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 form-group px-0">
                                        <x-adminlte-select-bs id="guests" name="guests[]" label="Participantes"
                                            label-class="text-dark" igroup-size="md" :config="$config" multiple
                                            class="border">
                                            @foreach ($guests as $guest)
                                                <option value="{{ $guest->id }}"
                                                    {{ in_array($guest->id, $schedule->guests->pluck('user_id')->toArray()) ? 'selected' : '' }}>
                                                    {{ $guest->name }}
                                                    ({{ $guest->email }})
                                                </option>
                                            @endforeach
                                        </x-adminlte-select-bs>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between mb-0">
                                    <div class="col-12 col-md-3 form-group px-0 pr-md-2">
                                        <div class="form-group">
                                            <label for="color">Cor</label>
                                            <x-adminlte-select2 name="color" required>
                                                <option
                                                    {{ old('color') == 'teal' ? 'selected' : ($schedule->color == 'teal' ? 'selected' : '') }}
                                                    value="teal">
                                                    Padrão
                                                </option>
                                                <option
                                                    {{ old('color') == 'warning' ? 'selected' : ($schedule->color == 'warning' ? 'selected' : '') }}
                                                    value="warning">
                                                    Amarelo
                                                </option>
                                                <option
                                                    {{ old('color') == 'primary' ? 'selected' : ($schedule->color == 'primary' ? 'selected' : '') }}
                                                    value="primary">
                                                    Azul
                                                </option>
                                                <option
                                                    {{ old('color') == 'secondary' ? 'selected' : ($schedule->color == 'secondary' ? 'selected' : '') }}
                                                    value="secondary">
                                                    Cinza
                                                </option>
                                                <option
                                                    {{ old('color') == 'danger' ? 'selected' : ($schedule->color == 'danger' ? 'selected' : '') }}
                                                    value="danger">
                                                    Vermelho
                                                </option>
                                                <option
                                                    {{ old('color') == 'success' ? 'selected' : ($schedule->color == 'teal' ? 'success' : '') }}
                                                    value="success">
                                                    Verde
                                                </option>
                                            </x-adminlte-select2>
                                        </div>
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
