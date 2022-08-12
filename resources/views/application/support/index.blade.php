@extends('adminlte::page')
@section('plugins.select2', true)

@section('title', '- Suporte')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-life-ring"></i> Suporte</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('app.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Suporte</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @include('components.alert')
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Formulário de Envio</h3>
                        </div>

                        <form method="POST" action="{{ route('app.support.send.mail') }}">
                            @csrf
                            <div class="card-body">

                                <div class="d-flex flex-wrap ">
                                    <div class="col-12 col-md-6 form-group px-0">
                                        <label for="type">Tipo</label>
                                        <x-adminlte-select2 name="type">
                                            <option {{ old('type') == 'Dúvida' ? 'selected' : '' }} value="Dúvida">Dúvida
                                            </option>
                                            <option {{ old('type') == 'Sugestão' ? 'selected' : '' }} value="Sugestão">
                                                Sugestão
                                            </option>
                                            <option {{ old('type') == 'Reclamação' ? 'selected' : '' }}
                                                value="Reclamação">Reclamação
                                            </option>
                                        </x-adminlte-select2>
                                    </div>
                                    <div class="col-12 form-group px-0">
                                        <label for="message">Mensagem</label>
                                        <x-adminlte-textarea name="message" rows=5 placeholder="Texto da Mensagem...."
                                            required />
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
