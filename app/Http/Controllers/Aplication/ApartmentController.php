<?php

namespace App\Http\Controllers\Aplication;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\ApartmentReport;
use App\Models\Block;
use App\Models\Complex;
use App\Models\DealershipReading;
use App\Models\Reading;
use App\Models\Resident;
use App\Models\Syndic;
use App\Models\Views\ApartmentReport as ViewsApartmentReport;
use App\Models\Views\DealershipReading as ViewsDealershipReading;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;

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
        } else {
            $complexes = null;
        }

        return view('application.apartments.index', compact('apartments', 'complexes'));
    }

    public function apartmentReading($id)
    {
        if (!Auth::user()->hasRole('Usuário')) {
            abort(403, 'Acesso não autorizado');
        }

        if (!Auth::user()->hasPermissionTo('Acessar Leituras Apartamento')) {
            abort(403, 'Acesso não autorizado');
        }

        $reading = ApartmentReport::where('id', $id)->first();

        if (empty($reading->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $apartment = Apartment::where('id', $reading->apartment_id)->first();
        if (empty($apartment->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $readings = Reading::whereIn('id', $reading->readings)->get();

        return view('application.apartments.show', compact('reading', 'apartment', 'readings'));
    }

    public function apartmentPrint($id)
    {
        if (!Auth::user()->hasRole('Usuário')) {
            abort(403, 'Acesso não autorizado');
        }

        if (!Auth::user()->hasPermissionTo('Acessar Leituras Apartamento')) {
            abort(403, 'Acesso não autorizado');
        }

        $reading = ApartmentReport::where('id', $id)->first();

        if (empty($reading->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $apartment = Apartment::where('id', $reading->apartment_id)->first();
        if (empty($apartment->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $readings = Reading::whereIn('id', $reading->readings)->get();

        return view('application.apartments.print', compact('reading', 'apartment', 'readings'));
    }

    public function complexReading($id)
    {
        if (!Auth::user()->hasRole('Usuário')) {
            abort(403, 'Acesso não autorizado');
        }

        if (!Auth::user()->hasPermissionTo('Acessar Leituras Apartamento')) {
            abort(403, 'Acesso não autorizado');
        }

        $reading = DealershipReading::where('id', $id)->first();
        if (empty($reading->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $complex = Complex::where('id', $reading->complex_id)->first();
        if (empty($complex->id)) {
            abort(403, 'Acesso não autorizado');
        }

        return view('application.complexes.show', compact('reading', 'complex'));
    }

    public function complexPrint($id)
    {
        if (!Auth::user()->hasRole('Usuário')) {
            abort(403, 'Acesso não autorizado');
        }

        if (!Auth::user()->hasPermissionTo('Acessar Leituras Apartamento')) {
            abort(403, 'Acesso não autorizado');
        }

        $reading = DealershipReading::where('id', $id)->first();
        if (empty($reading->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $complex = Complex::where('id', $reading->complex_id)->first();
        if (empty($complex->id)) {
            abort(403, 'Acesso não autorizado');
        }


        return view('application.complexes.print', compact('reading', 'complex'));
    }

    public function residencesReadingAjax(Request $request, $id)
    {
        $reports = ViewsApartmentReport::where('apartment_id', $id)->get();
        if ($request->ajax()) {
            return Datatables::of($reports)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<nobr>' . '<a class="btn btn-xs btn-default bg-primary mx-1 shadow" title="Visualizar" href="residences-readings/' . $row->id . '"><i class="fa fa-lg fa-fw fa-eye"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function complexReadingAjax(Request $request, $id)
    {
        $readings = ViewsDealershipReading::where('complex_id', $id)->get();
        if ($request->ajax()) {
            return Datatables::of($readings)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<nobr>' . '<a class="btn btn-xs btn-default bg-primary mx-1 shadow" title="Visualizar"    href="complex-readings/' . $row->id . '"><i class="fa fa-lg fa-fw fa-eye"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function complexResidencesReadingAjax(Request $request, $id)
    {
        $blocks = Block::where('complex_id', $id)->pluck('id');
        $apartments = Apartment::whereIn('block_id', $blocks)->pluck('id');
        $reports = ViewsApartmentReport::whereIn('apartment_id', $apartments)->get();
        if ($request->ajax()) {
            return Datatables::of($reports)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<nobr>' . '<a class="btn btn-xs btn-default bg-primary mx-1 shadow" title="Visualizar" href="residences-readings/' . $row->id . '"><i class="fa fa-lg fa-fw fa-eye"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function readingsReportAjax(Request $request, $id)
    {
        $reports = ViewsApartmentReport::where('dealership_reading_id', $id)->get();
        if ($request->ajax()) {
            return Datatables::of($reports)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<nobr>' . '<a class="btn btn-xs btn-default bg-primary mx-1 shadow" title="Visualizar" href="' . url('/app/residences-readings/') . '/' . $row->id . '"><i class="fa fa-lg fa-fw fa-eye"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
