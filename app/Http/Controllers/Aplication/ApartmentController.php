<?php

namespace App\Http\Controllers\Aplication;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\DealershipReading;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApartmentController extends Controller
{
    public function index()
    {
        if (!Auth::user()->hasRole('Usuário')) {
            abort(403, 'Acesso não autorizado');
        }

        if (!Auth::user()->hasPermissionTo('Acessar Leituras Apartamento')) {
            abort(403, 'Acesso não autorizado');
        }

        $residences = Resident::where('user_id', Auth::user()->id)->pluck('apartment_id');
        $apartments = Apartment::whereIn('id', $residences)->get();

        return view('application.apartments.index', compact('apartments'));
    }

    public function show($re, $ap)
    {
        if (!Auth::user()->hasRole('Usuário')) {
            abort(403, 'Acesso não autorizado');
        }

        if (!Auth::user()->hasPermissionTo('Acessar Leituras Apartamento')) {
            abort(403, 'Acesso não autorizado');
        }

        $apartment = Apartment::where('id', $ap)->first();
        if (empty($apartment->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $reading = DealershipReading::where('id', $re)
            ->where('complex_id', $apartment->block->complex['id'])->first();
        if (empty($reading->id)) {
            abort(403, 'Acesso não autorizado');
        }

        return view('application.apartments.show', compact('reading', 'apartment'));
    }

    public function print($re, $ap)
    {
        if (!Auth::user()->hasRole('Usuário')) {
            abort(403, 'Acesso não autorizado');
        }

        if (!Auth::user()->hasPermissionTo('Acessar Leituras Apartamento')) {
            abort(403, 'Acesso não autorizado');
        }

        $apartment = Apartment::where('id', $ap)->first();
        if (empty($apartment->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $reading = DealershipReading::where('id', $re)
            ->where('complex_id', $apartment->block->complex['id'])->first();
        if (empty($reading->id)) {
            abort(403, 'Acesso não autorizado');
        }

        return view('application.apartments.print', compact('reading', 'apartment'));
    }
}
