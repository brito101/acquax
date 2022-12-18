@extends('adminlte::page')
@section('plugins.BootstrapSelect', true)
@section('plugins.select2', true)

@section('title', '- Edição de Agendamento de Leitura')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-calendar-check"></i> Editar Agendamento de Leitura #{{ $schedule->id }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.reading-schedule.index') }}">Agendamentos de
                                Leituras</a></li>
                        <li class="breadcrumb-item active">Editar Agendamento</li>
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
                            <h3 class="card-title">Dados Cadastrais do Agendamento</h3>
                        </div>


                        <form method="POST"
                            action="{{ route('admin.reading-schedule.update', ['reading_schedule' => $schedule->id]) }}">
                            @method('PUT')
                            <input type="hidden" name="id" value="{{ $schedule->id }}">
                            <input type="hidden" name="title" value="{{ $schedule->title }}">
                            @csrf
                            <div class="card-body">

                                <div class="d-flex flex-wrap justify-content-start">
                                    <div class="col-12 col-md-3 form-group px-0 pr-md-2">
                                        <label for="start">Início</label>
                                        <input type="datetime-local" class="form-control" id="start" name="start"
                                            value="{{ old('start') ?? $schedule->start }}" required>
                                    </div>
                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="end">Término</label>
                                        <input type="datetime-local" class="form-control" id="end" name="end"
                                            value="{{ old('end') ?? $schedule->end }}" required>
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="complex_id">Condomínio</label>
                                        <x-adminlte-select2 name="complex_id">
                                            @foreach ($complexes as $complex)
                                                <option
                                                    {{ old('complex_id') == $complex->id ? 'selected' : ($schedule->complex_id == $complex->id ? 'selected' : '') }}
                                                    value="{{ $complex->id }}">
                                                    {{ $complex->alias_name }}</option>
                                            @endforeach
                                        </x-adminlte-select2>
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
                                        <x-adminlte-select-bs id="guests" name="guests[]" label="Leituristas"
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
