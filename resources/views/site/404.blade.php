@extends('site.master.master')

@section('content')
    <div class="error-area">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="error-content">
                    <img src="{{ asset('img/404-error.jpg') }}" alt="Image">
                    <h3>Oops! Página não encontrada</h3>
                    <p>A página que você está procurando pode ter sido removida teve seu nome alterado ou está
                        temporariamente indisponível.</p>
                    <a href="{{ route('site.home') }}" class="default-btn btn-bg-one">
                        Retornar à página inicial
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
