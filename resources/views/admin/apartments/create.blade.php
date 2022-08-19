@extends('adminlte::page')
@section('plugins.select2', true)

@section('title', '- Cadastro de Apartamento')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-home"></i> Novo Apartamento</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.apartments.index') }}">Apartamentos</a></li>
                        <li class="breadcrumb-item active">Novo Apartamento</li>
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
                            <h3 class="card-title">Dados Cadastrais do Apartamento</h3>
                        </div>


                        <form method="POST" action="{{ route('admin.apartments.store') }}">
                            @csrf
                            <input type="hidden" name="from" value="{{ url()->previous() }}">
                            <div class="card-body">

                                <div class="d-flex flex-wrap justify-content-between">
                                    <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                        <label for="name">Nome do Apartamento</label>
                                        <input type="text" class="form-control" id="name"
                                            placeholder="Nome do Apartamento" name="name" value="{{ old('name') }}"
                                            required>
                                    </div>
                                    <div class="col-12 col-md-3 form-group px-0 px-md-2">
                                        <label for="fraction">Fração Ideal</label>
                                        <input type="text" class="form-control" id="fraction" placeholder="Fração Ideal"
                                            name="fraction" value="{{ old('fraction') }}">
                                    </div>
                                    <div class="col-12 col-md-3 form-group pl-0 px-md-2">
                                        <label for="status">Status do Apartamento</label>
                                        <x-adminlte-select2 name="status">
                                            <option {{ old('status') == 'Ativo' ? 'selected' : '' }}>Ativo</option>
                                            <option {{ old('status') == 'Inativo' ? 'selected' : '' }}>Inativo</option>
                                        </x-adminlte-select2>
                                    </div>

                                </div>
                                @if ($blocks instanceof Illuminate\Database\Eloquent\Collection)
                                    <div class="d-flex flex-wrap justify-content-between">
                                        <div class="col-12 col-md-6 form-group px-0 pr-md-2">
                                            <label for="block_id">Bloco</label>
                                            <x-adminlte-select2 name="block_id">
                                                @foreach ($blocks->toArray() as $block)
                                                    <option {{ old('block_id') == $block['id'] ? 'selected' : '' }}
                                                        value="{{ $block['id'] }}">
                                                        {{ $block['name'] }}
                                                        @if (empty($complex))
                                                            - {{ $block['complex_name'] }}
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </x-adminlte-select2>
                                        </div>

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

@section('custom_js')
    <script src="{{ asset('vendor/jquery/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ asset('js/apartment.js') }}"></script>
@endsection
