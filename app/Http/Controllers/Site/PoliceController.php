<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Meta;

class PoliceController extends Controller
{
    public function index()
    {
        Meta::set('title', 'Acqua X do Brasil - Política de privacidade');
        Meta::set('description', 'Acqua X do Brasil - Termos de nossa Política de privacidade.');
        Meta::set('robots', 'index,follow');
        Meta::set('image', asset('img/share.png'));
        Meta::set('canonical', env('APP_URL'));
        return view('site.police.index');
    }
}
