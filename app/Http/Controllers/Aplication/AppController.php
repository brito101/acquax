<?php

namespace App\Http\Controllers\Aplication;

use App\Http\Controllers\Controller;
use App\Models\Complex;
use App\Models\Resident;
use App\Models\Syndic;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
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
        $syndics = Syndic::where('user_id', Auth::user()->id)->get();
        if ($syndics->count() > 0) {
            if (!$syndics->pluck('first_access')->contains('Não')) {
                return redirect()
                    ->route('app.user.edit')
                    ->with('warning', 'Por favor, atualize seus dados pessoais.');
            }
            $complexes = Complex::whereIn('id', $syndics->pluck('complex_id'))->get();
        } else {
            $complexes = null;
        }

        return view('application.home.index', compact('residences', 'complexes'));
    }
}
