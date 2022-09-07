@extends('adminlte::page')

@section('title', '- Posts')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-fw fa-blog"></i> Posts</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Posts</li>
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
                            <div class="d-flex flex-wrap justify-content-between col-12 align-content-center">
                                <h3 class="card-title align-self-center">Posts Cadastrados</h3>
                                @can('Criar Posts')
                                    <a href="{{ route('admin.posts.create') }}" title="Novo Post" class="btn btn-success"><i
                                            class="fas fa-fw fa-plus"></i>Novo Post</a>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap justify-content-start">
                                @forelse ($posts as $post)
                                    <div class="col-12 col-md-4">
                                        <div class="card p-2">
                                            <img src="{{ Storage::url('posts/' . $post->cover) }}"
                                                class="card-img-top shadow-sm" alt="{{ $post->title }}"
                                                style="min-height: 200px; max-height: 200px; object-fit: cover">
                                            <div class="card-body">
                                                <h5 class="card-title mb-2">{{ $post->title }}</h5>
                                                <p class="card-text text-muted">{{ $post->headline }}</p>
                                                <p class="text-muted text-sm mt-2 mb-0 pb-0">Status:<span
                                                        class="badge {{ $post->status == 'Publicado' ? 'badge-info' : ($post->status == 'Rascunho' ? 'badge-warning' : 'badge-danger') }} ml-2 text-md">{{ $post->status }}</span>
                                                </p>
                                                <p class="card-text text-right text-muted">Visualizações:
                                                    {{ $post->views }}</p>
                                            </div>
                                            <div class="card-footer">
                                                <div class="row d-flex flex-wrap justify-content-center">
                                                    <div class="col-12 col-md-6">
                                                        <a href="{{ route('site.post', ['slug' => $post->slug]) }}"
                                                            class="btn btn-success w-100 m-1" target="_blank">Ver</a>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <a href="{{ route('admin.posts.edit', ['post' => $post->id]) }}"
                                                            class="btn btn-primary w-100 m-1">Editar</a>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <a href="posts/destroy/{{ $post->id }}"
                                                            class="btn btn-danger w-100 m-1">Excluir</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p>Não existem posts cadastrados</p>
                                @endforelse
                                @if (count($posts) > 0)
                                    <div class="d-flex flex-wrap justify-content-center col-12">
                                        {{ $posts->links() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
