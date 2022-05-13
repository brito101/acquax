<?php

namespace App\Http\Controllers\Aplication;

use App\Http\Controllers\Controller;
use App\Models\Meter;
use App\Models\Reading;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeterReadingController extends Controller
{
    public function index()
    {
        if (!Auth::user()->hasRole('Usuário')) {
            abort(403, 'Acesso não autorizado');
        }

        if (!Auth::user()->hasPermissionTo('Acessar Medições Apartamento')) {
            abort(403, 'Acesso não autorizado');
        }

        $residences = Resident::where('user_id', Auth::user()->id)->pluck('apartment_id');
        $meters = Meter::whereIn('apartment_id', $residences)->pluck('id');
        $readings = Reading::whereIn('meter_id', $meters)->orderBy('created_at', 'desc')->get();
        return view('application.meters.index', compact('readings'));
    }

    public function show($id)
    {
        if (!Auth::user()->hasRole('Usuário')) {
            abort(403, 'Acesso não autorizado');
        }

        if (!Auth::user()->hasPermissionTo('Acessar Medições Apartamento')) {
            abort(403, 'Acesso não autorizado');
        }

        $residences = Resident::where('user_id', Auth::user()->id)->pluck('apartment_id');
        $meters = Meter::whereIn('apartment_id', $residences)->pluck('id');
        $reading = Reading::whereIn('meter_id', $meters)->where('id', $id)->first();

        if (empty($reading->id)) {
            abort(403, 'Acesso não autorizado');
        }

        return view('application.meters.show', compact('reading'));
    }
}
