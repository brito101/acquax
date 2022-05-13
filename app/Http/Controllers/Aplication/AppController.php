<?php

namespace App\Http\Controllers\Aplication;

use App\Http\Controllers\Controller;
use App\Models\Complex;
use App\Models\Resident;
use App\Models\Syndic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->hasAnyRole('Usuário')) {
            abort(403, 'Acesso não autorizado');
        }

        $residences = Resident::where('user_id', Auth::user()->id)->get();
        $syndic = Syndic::where('user_id', Auth::user()->id)->pluck('complex_id');
        if ($syndic->count() > 0) {
            $complexes = Complex::whereIn('id', $syndic)->get();
        } else {
            $complexes = null;
        }

        return view('application.home.index', compact('residences', 'complexes'));
    }
}
