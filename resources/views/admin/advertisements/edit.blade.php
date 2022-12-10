@extends('adminlte::page')
@section('plugins.BsCustomFileInput', true)
@section('plugins.select2', true)
@section('plugins.BootstrapSelect', true)

@section('title', '- Editar Propaganda')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-bullhorn"></i> Editar Propaganda</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.advertisements.index') }}">Propagandas</a></li>
                        <li class="breadcrumb-item active">Editar Propaganda</li>
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
                            <h3 class="card-title">Dados Cadastrais da Propaganda</h3>
                            <small class="float-right text-black-50">Criado por {{ $advertisement->user->name }} em
                                {{ date('d/m/Y H:i', strtotime($advertisement->created_at)) }}</small>
                        </div>

                        <form method="POST"
                            action="{{ route('admin.advertisements.update', ['advertisement' => $advertisement->id]) }}"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="id" value="{{ $advertisement->id }}">
                            <div class="card-body">

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="title">Título</label>
                                        <input type="text" class="form-control" id="title"
                                            placeholder="Título da Propaganda" name="title"
                                            value="{{ old('title') ?? $advertisement->title }}" required>
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 px-md-2">
                                        <label for="link">Link</label>
                                        <input type="text" class="form-control" id="link"
                                            placeholder="Link para a propaganda no site de referência" name="link"
                                            value="{{ old('link') ?? $advertisement->link }}" required>
                                    </div>

                                    <div class="col-12 col-md-4 form-group px-0 pl-md-2">
                                        <label for="status">Status</label>
                                        <x-adminlte-select2 name="status">
                                            <option
                                                {{ old('status') == 'Ativo' ? 'selected' : ($advertisement->status == 'Ativo' ? 'selected' : '') }}
                                                value="Ativo">
                                                Ativo</option>
                                            <option
                                                {{ old('status') == 'Inativo' ? 'selected' : ($advertisement->status == 'Inativo' ? 'selected' : '') }}
                                                value="Inativo">
                                                Inativo</option>
                                        </x-adminlte-select2>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-start">
                                    @php
                                        $config = [
                                            'liveSearch' => true,
                                            'liveSearchPlaceholder' => 'Pesquisar...',
                                            'title' => 'Podem ser selecionados um ou mais...',
                                            'enable-old-support' => true,
                                            'showTick' => true,
                                            'actionsBox' => true,
                                        ];
                                    @endphp
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <x-adminlte-select-bs id="complexes" name="complexes[]" label="Condomínios"
                                            class="border" igroup-size="md" :config="$config" multiple required>
                                            @foreach ($complexes as $complex)
                                                <option value="{{ $complex->id }}"
                                                    {{ in_array($complex->id, $advertisingComplex->pluck('complex_id')->toArray()) ? 'selected' : '' }}>
                                                    {{ $complex->alias_name }}
                                                </option>
                                            @endforeach
                                        </x-adminlte-select-bs>
                                    </div>

                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <x-adminlte-input-file name="cover" label="Imagem de Exibição"
                                            placeholder="Selecione uma imagem..." legend="Selecionar" />
                                    </div>
                                </div>

                                @if ($advertisement->cover)
                                    <div class="col-12 img-responsive-16by9 text-center shadow-lg mb-2">
                                        <img src="{{ Storage::url('advertisements/' . $advertisement->cover) }}"
                                            class="radius" alt="" width="100%"
                                            style="max-height: 500px; object-fit: cover">
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
