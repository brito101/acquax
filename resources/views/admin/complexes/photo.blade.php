@extends('adminlte::page')
@section('plugins.select2', true)
@section('plugins.BsCustomFileInput', true)

@section('title', '- Cadastro de Fotos de Condomínios')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-camera"></i> Cadastro de Fotos de Condomínios</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.complexes.index') }}">Condomínios</a>
                        </li>
                        <li class="breadcrumb-item active">Fotos de Condomínios</li>
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
                            <h3 class="card-title">Importação de Fotos</h3>
                        </div>

                        <form method="POST" action="{{ route('admin.complexes.photo.import') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 form-group px-0">
                                        <x-adminlte-input-file id="photos" name="photos[]" label="Fotos de Condomíos"
                                            placeholder="Selecione até 1000 arquivos com o máximo de 10GB" igroup-size="md"
                                            legend="Selecione" multiple>
                                            <x-slot name="prependSlot">
                                                <div class="input-group-text text-primary">
                                                    <i class="fas fa-file-upload"></i>
                                                </div>
                                            </x-slot>
                                        </x-adminlte-input-file>
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
    <script src="{{ asset('js/reading.js') }}"></script>
@endsection
