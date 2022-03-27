<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use stdClass;

class SiteController extends Controller
{

    public function index()
    {
        $head = new stdClass();
        $head->title = env('APP_NAME');
        $head->description = 'A melhor agência de estágios do Brasil';
        return view('site.home.index', compact('head'));
    }
}
