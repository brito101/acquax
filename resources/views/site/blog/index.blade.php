@extends('site.master.master')

@section('content')
    <div class="inner-banner">
        <div class="container">
            <div class="inner-title text-center">
                <h3>Blog</h3>
            </div>
        </div>
    </div>

    <div class="blog-area pt-100 pb-70">
        <div class="container">
            <div class="section-title text-center">
                <h2>Confira nossas últimas postagens!</h2>
            </div>
            <div class="row pt-45">
                @forelse ($posts as $post)
                    <div class="col-lg-4 col-md-6">
                        <div class="blog-card">
                            <div class="blog-img">
                                <a href="{{ route('site.post', ['slug' => $post->slug]) }}" title="{{ $post->title }}">
                                    <img src="{{ $post->cover ? url('storage/posts/' . $post->cover) : asset('img/share.jpg') }}"
                                        alt="{{ $post->title }}">
                                </a>
                                <div class="blog-tag">
                                    <h3>{{ $post->created_at->format('d') }}</h3>
                                    @php
                                        switch ($post->created_at->format('M')) {
                                            case 'May':
                                                $month = 'Mai';
                                                break;
                                            case 'Aug':
                                                $month = 'Ago';
                                                break;
                                            case 'Sep':
                                                $month = 'Set';
                                                break;
                                            case 'Oct':
                                                $month = 'Out';
                                                break;
                                            case 'Dec':
                                                $month = 'Dez';
                                                break;
                                            default:
                                                $month = $post->created_at->format('M');
                                                break;
                                        }
                                    @endphp
                                    <span>{{ $month }}</span><br />
                                    <span>{{ $post->created_at->format('Y') }}</span>
                                </div>
                            </div>
                            <div class="content">
                                <h3>
                                    <a href="{{ route('site.post', ['slug' => $post->slug]) }}"
                                        title="{{ $post->title }}">{{ $post->title }}</a>
                                </h3>
                                <p style="height: 60px;">{{ Str::limit($post->headline, 80) }}</p>
                            </div>
                        </div>
                    </div>

                @empty
                    <p>Estamos preparando postagens de primeira para você :)</p>
                @endforelse

                @if (count($posts))
                    <div class="col-lg-12 col-md-12 text-center d-flex justify-content-center">
                        <div class="pagination-area">
                            {{ $posts->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
