<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DealershipReadingRequest;
use App\Http\Requests\Admin\Settings\DealershipRequest;
use App\Models\Apartment;
use App\Models\ApartmentReport;
use App\Models\Block;
use App\Models\Complex;
use App\Models\DealershipReading;
use App\Models\Settings\Dealership;
use App\Models\Views\Apartment as ViewsApartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DealershipReadingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->hasPermissionTo('Listar Leitura das Concessionárias')) {
            abort(403, 'Acesso não autorizado');
        }

        $readings = DealershipReading::all();
        return view('admin.dealerships-readings.index', compact('readings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('Criar Leitura das Concessionárias')) {
            abort(403, 'Acesso não autorizado');
        }

        $complexes = Complex::all();
        $dealerships = Dealership::all();

        return view('admin.dealerships-readings.create', compact('complexes', 'dealerships'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DealershipReadingRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Leitura das Concessionárias')) {
            abort(403, 'Acesso não autorizado');
        }

        $complex = Complex::where('id', $request['complex_id'])->first();
        if (empty($complex->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $dealership = Dealership::where('id', $request['dealership_id'])->first();
        if (empty($dealership->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();

        /** computed data forced */
        $data['monthly_consumption'] = 'forced';
        $data['diff_consumption'] = 'forced';
        $data['previous_monthly_consumption'] = 'forced';
        $data['previous_billed_consumption'] = 'forced';
        $data['units_inside_tax_1'] = 'forced';
        $data['units_above_tax_1'] = 'forced';

        $data['editor'] = Auth::user()->id;

        $reading = DealershipReading::create($data);

        if ($reading->save()) {
            $this->generateApartmentReport($reading);
            $reading->finalCalc();
            return redirect()
                ->route('admin.dealerships-readings.index')
                ->with('success', 'Cadastro realizado!');
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erro ao cadastrar!');
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Leitura das Concessionárias')) {
            abort(403, 'Acesso não autorizado');
        }

        $reading = DealershipReading::where('id', $id)->first();
        if (empty($reading->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $complexes = Complex::all();
        $dealerships = Dealership::all();

        return view('admin.dealerships-readings.edit', compact('reading', 'complexes', 'dealerships'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DealershipReadingRequest $request, $id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Leitura das Concessionárias')) {
            abort(403, 'Acesso não autorizado');
        }

        $reading = DealershipReading::where('id', $id)->first();
        if (empty($reading->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $complex = Complex::where('id', $request['complex_id'])->first();
        if (empty($complex->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $dealership = Dealership::where('id', $request['dealership_id'])->first();
        if (empty($dealership->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();

        /** computed data forced */
        $data['monthly_consumption'] = 'forced';
        $data['diff_consumption'] = 'forced';
        $data['previous_monthly_consumption'] = 'forced';
        $data['previous_billed_consumption'] = 'forced';
        $data['units_inside_tax_1'] = 'forced';
        $data['units_above_tax_1'] = 'forced';

        $data['editor'] = Auth::user()->id;

        if ($reading->update($data)) {
            $this->generateApartmentReport($reading);
            $reading->finalCalc();
            return redirect()
                ->route('admin.dealerships-readings.index')
                ->with('success', 'Cadastro realizado!');
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erro ao cadastrar!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Auth::user()->hasPermissionTo('Excluir Leitura das Concessionárias')) {
            abort(403, 'Acesso não autorizado');
        }

        $reading = DealershipReading::where('id', $id)->first();

        if (empty($reading->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $reports = $reading->apartmentReports;

        if ($reading->delete()) {
            if ($reports->count() > 0) {
                foreach ($reports as $report) {
                    $report->delete();
                }
            }
            return redirect()
                ->back()
                ->with('success', 'Exclusão realizada!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir!');
        }
    }

    public function generateApartmentReport($reading)
    {
        $blocks = Block::where('complex_id', $reading->complex_id)->pluck('id');
        $apartments = ViewsApartment::whereIn('block_id', $blocks)->get();
        $reports = [];

        foreach ($apartments as $apartment) {
            $result = $reading->getApartmentReport($apartment);

            if ($result) {
                $report = ApartmentReport::where('dealership_reading_id', $reading->id)->where('apartment_id',  $apartment->id)->first();

                $data = [
                    'consumed' => $result['volume_consumed'],
                    'consumed_cost' => $result['consumed_cost'],
                    'sewage_cost' => $result['sewage_cost'],
                    // 'total_unit' => $result['total_unit'],
                    // 'partial' => $result['partial'],
                    'dealership_reading_id' => $reading->id,
                    'readings' => $result['readings'],
                    'apartment_id' => $apartment->id,
                    'month_ref' => $reading->month_ref,
                    'year_ref' => $reading->year_ref
                ];
                if ($report) {
                    $report->update($data);
                } else {
                    ApartmentReport::create($data);
                }
            }
        }
    }
}
