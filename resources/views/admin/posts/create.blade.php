@extends('adminlte::page')

@section('title', '- Cadastro de Post')
@section('plugins.BsCustomFileInput', true)
@section('plugins.Summernote', true)
@section('plugins.select2', true)

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-blog"></i> Novo Post</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.posts.index') }}">Posts</a></li>
                        <li class="breadcrumb-item active">Novo Post</li>
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
                            <h3 class="card-title">Dados Cadastrais do Post</h3>
                        </div>

                        <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="title">Título</label>
                                        <input type="text" class="form-control" id="title"
                                            placeholder="Título do Post" name="title" value="{{ old('title') }}"
                                            required>
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="headline">Headline</label>
                                        <input type="text" class="form-control" id="headline"
                                            placeholder="Headline para o Post" name="headline" value="{{ old('headline') }}"
                                            required>
                                    </div>
                                </div>

                                <div class="col-12 form-group px-0 d-flex flex-wrap">
                                    <div class="col-md-12 px-0">
                                        <x-adminlte-input-file name="cover"
                                            label="Foto de Capa (recomendável 1200 x 630 pixels)"
                                            placeholder="Selecione uma imagem..." legend="Selecionar" />
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-12 form-group px-0">
                                        @php
                                            $config = [
                                                'height' => '300',
                                                'toolbar' => [
                                                    // [groupName, [list of button]]
                                                    ['style', ['bold', 'italic', 'underline', 'clear']],
                                                    ['font', ['strikethrough', 'superscript', 'subscript']],
                                                    ['fontsize', ['fontsize']],
                                                    ['color', ['color']],
                                                    ['para', ['ul', 'ol', 'paragraph']],
                                                    ['height', ['height']],
                                                    ['table', ['table']],
                                                    ['insert', ['link', 'picture', 'video']],
                                                    ['view', ['fullscreen', 'codeview', 'help']],
                                                ],
                                            ];
                                        @endphp
                                        <x-adminlte-text-editor name="content" label="Texto" igroup-size="sm"
                                            placeholder="Escreva o conteúdo do post aqui..." :config="$config">
                                            {{ old('content') }}
                                        </x-adminlte-text-editor>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-4 form-group px-0 pr-md-2">
                                        <label for="status">Status</label>
                                        <x-adminlte-select2 name="status">
                                            <option {{ old('status') == 'Publicado' ? 'selected' : '' }}>Publicado
                                            </option>
                                            <option {{ old('status') == 'Rascunho' ? 'selected' : '' }}>Rascunho
                                            </option>
                                            <option {{ old('status') == 'Lixo' ? 'selected' : '' }}>Lixo
                                            </option>
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
