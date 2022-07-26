@extends('adminlte::page')
@section('plugins.BsCustomFileInput', true)
@section('plugins.select2', true)

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

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 form-group px-0">
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
