@extends('adminlte::page')

@section('title', '- Edição de Concessionária')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-hands-helping"></i> Editar Concessionária</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Configurações</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.dealerships.index') }}">Concessionárias</a>
                        </li>
                        <li class="breadcrumb-item active">Editar Concessionária</li>
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
                            <h3 class="card-title">Dados Cadastrais da Concessionária</h3>
                        </div>

                        <form method="POST"
                            action="{{ route('admin.dealerships.update', ['dealership' => $dealership->id]) }}">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="id" value="{{ $dealership->id }}">
                            <div class="card-body">

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="name">Nome da Concessionária</label>
                                        <input type="text" class="form-control" id="name" placeholder="Nome do Tipo"
                                            name="name" value="{{ old('name') ?? $dealership->name }}" required>
                                    </div>
                                    <div class="col-12 col-md-6 form-group px-0 pl-md-2">
                                        <label for="service">Serviço Prestado</label>
                                        <input type="text" class="form-control" id="service"
                                            placeholder="Água e esgoto, energia elétrica..." name="service"
                                            value="{{ old('service') ?? $dealership->service }}">
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
