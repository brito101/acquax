<?php

namespace App\Http\Controllers\Aplication;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Block;
use App\Models\Complex;
use App\Models\DealershipReading;
use App\Models\Resident;
use App\Models\Syndic;
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

        $user_id = Auth::user()->id;

        $residences = Resident::where('user_id', $user_id)->pluck('apartment_id');
        $apartments = Apartment::whereIn('id', $residences)->get();

        $syndic = Syndic::where('user_id', $user_id)->pluck('complex_id');
        if (count($syndic) > 0) {
            $complexes = Complex::whereIn('id', $syndic)->get();
            $blocks = Block::whereIn('complex_id', $complexes->pluck('id'))->pluck('id');
            $complexesApartments = Apartment::whereIn('block_id', $blocks)->get();
        } else {
            $complexesApartments = null;
            $complexes = null;
        }

        return view('application.apartments.index', compact('apartments', 'complexesApartments', 'complexes'));
    }

    public function apartmentReading($re, $ap)
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

    public function apartmentPrint($re, $ap)
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

    public function complexReading($re, $c)
    {
        if (!Auth::user()->hasRole('Usuário')) {
            abort(403, 'Acesso não autorizado');
        }

        if (!Auth::user()->hasPermissionTo('Acessar Leituras Apartamento')) {
            abort(403, 'Acesso não autorizado');
        }

        $complex = Complex::where('id', $c)->first();
        if (empty($complex->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $reading = DealershipReading::where('id', $re)
            ->where('complex_id', $complex->id)->first();
        if (empty($reading->id)) {
            abort(403, 'Acesso não autorizado');
        }

        return view('application.complexes.show', compact('reading', 'complex'));
    }

    public function complexPrint($re, $c)
    {
        if (!Auth::user()->hasRole('Usuário')) {
            abort(403, 'Acesso não autorizado');
        }

        if (!Auth::user()->hasPermissionTo('Acessar Leituras Apartamento')) {
            abort(403, 'Acesso não autorizado');
        }

        $complex = Complex::where('id', $c)->first();
        if (empty($complex->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $reading = DealershipReading::where('id', $re)
            ->where('complex_id', $complex->id)->first();
        if (empty($reading->id)) {
            abort(403, 'Acesso não autorizado');
        }

        return view('application.complexes.print', compact('reading', 'complex'));
    }
}
