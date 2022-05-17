<?php

namespace App\Http\Controllers\Aplication;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Block;
use App\Models\Complex;
use App\Models\Meter;
use App\Models\Reading;
use App\Models\Resident;
use App\Models\Syndic;
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

        $user_id = Auth::user()->id;

        $syndic = Syndic::where('user_id', $user_id)->pluck('complex_id');
        if (count($syndic) > 0) {
            $complexes = Complex::whereIn('id', $syndic)->get();
            $blocks = Block::whereIn('complex_id', $complexes->pluck('id'))->pluck('id');
            $complexesApartments = Apartment::whereIn('block_id', $blocks)->pluck('id');
            $meters = Meter::whereIn('apartment_id', $complexesApartments)->pluck('id');
            $complexReadings = Reading::whereIn('meter_id', $meters)->orderBy('created_at', 'desc')->get();
        } else {
            $complexReadings = null;
        }

        $residences = Resident::where('user_id', $user_id)->pluck('apartment_id');
        $meters = Meter::whereIn('apartment_id', $residences)->pluck('id');
        $readings = Reading::whereIn('meter_id', $meters)->orderBy('created_at', 'desc')->get();
        return view('application.meters.index', compact('readings', 'complexReadings'));
    }

    public function show($id)
    {
        if (!Auth::user()->hasRole('Usuário')) {
            abort(403, 'Acesso não autorizado');
        }

        if (!Auth::user()->hasPermissionTo('Acessar Medições Apartamento')) {
            abort(403, 'Acesso não autorizado');
        }

        $user_id = Auth::user()->id;

        $complexesApartments = [];
        $syndic = Syndic::where('user_id', $user_id)->pluck('complex_id');
        if (count($syndic) > 0) {
            $complexes = Complex::whereIn('id', $syndic)->get();
            $blocks = Block::whereIn('complex_id', $complexes->pluck('id'))->pluck('id');
            $complexesApartments = Apartment::whereIn('block_id', $blocks)->pluck('id');
        }

        $residences = Resident::where('user_id', $user_id)->pluck('apartment_id');
        $meters = Meter::whereIn('apartment_id', $residences->merge($complexesApartments))->pluck('id');
        $reading = Reading::whereIn('meter_id', $meters)->where('id', $id)->first();

        if (empty($reading->id)) {
            abort(403, 'Acesso não autorizado');
        }

        return view('application.meters.show', compact('reading'));
    }
}
