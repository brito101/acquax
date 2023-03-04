<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Meta;

class HomeController extends Controller
{
    public function index()
    {
        Meta::set('title', 'Acqua X do Brasil - Individualização e Medição de Água');
        Meta::set('description', 'Acqua X do Brasil - Garantimos o futuro trabalhando com sustentabilidade.');
        Meta::set('robots', 'index,follow');
        Meta::set('image', asset('img/share.png'));
        Meta::set('canonical', env('APP_URL'));

        $posts = Post::where('status', 'Publicado')
            ->orderBy('created_at', 'desc')->limit(3)->get();
        return view('site.home.index', compact('posts'));
    }
}
