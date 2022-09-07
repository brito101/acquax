<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Meta;

class PostController extends Controller
{
    public function index()
    {
        Meta::set('title', 'Acqua X do Brasil - Blog');
        Meta::set('description', 'Acqua X do Brasil - Confira nossas dicas e acompanhe nosso trabalho alinhado com sustentabilidade.');
        Meta::set('robots', 'index,follow');
        Meta::set('image', asset('img/share.png'));
        Meta::set('canonical', env('APP_URL'));
        $posts = Post::where('status', 'Publicado')
            ->orderBy('created_at', 'desc')->paginate(6);
        return view('site.blog.index', compact('posts'));
    }

    public function post($slug)
    {
        $post = Post::where('slug', $slug)->where('status', 'Publicado')->first();
        if (empty($post->id)) {
            abort(404, 'Página não encontrada');
        }

        $post->views += 1;
        $post->update();

        $posts = Post::whereNotIn('id', [$post->id])->where('status', 'Publicado')->inRandomOrder()->limit(3)->get();

        Meta::set('title', "Acqua X do Brasil - {$post->title}");
        Meta::set('description', $post->headline);
        Meta::set('robots', 'index,follow');
        Meta::set('image', $post->cover ? url('storage/posts/' . $post->cover) : asset('img/share.jpg'));
        Meta::set('canonical', env('APP_URL'));

        return view('site.blog.post', compact('post', 'posts'));
    }
}
