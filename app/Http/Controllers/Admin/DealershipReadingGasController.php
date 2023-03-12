<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DealershipReadingGasRequest;
use App\Models\Complex;
use App\Models\DealershipReadingGas;
use App\Models\Settings\Dealership;
use App\Models\Views\DealershipReadingGas as ViewsDealershipReadingGas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;

class DealershipReadingGasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Listar Leitura das Concessionárias')) {
            abort(403, 'Acesso não autorizado');
        }

        $readings = ViewsDealershipReadingGas::query();
        if ($request->ajax()) {
            return Datatables::of($readings)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-xs btn-primary mx-1 shadow" title="Editar" href="dealerships-readings-gas/' . $row->id . '/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>' . '<a class="btn btn-xs btn-danger mx-1 shadow" title="Excluir" href="dealerships-readings-gas/destroy/' . $row->id . '" onclick="return confirm(\'Confirma a exclusão desta leitura?\')"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.dealerships-readings-gas.index');
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

        $complexes = Complex::all('id', 'alias_name');
        $dealerships = Dealership::where('service', 'Gás')->get();

        return view('admin.dealerships-readings-gas.create', compact('complexes', 'dealerships'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DealershipReadingGasRequest $request)
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

        $data['editor'] = Auth::user()->id;

        $reading = DealershipReadingGas::create($data);

        if ($reading->save()) {
            return redirect()
                ->route('admin.dealerships-readings-gas.index')
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
    public function edit($id, Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Editar Leitura das Concessionárias')) {
            abort(403, 'Acesso não autorizado');
        }

        $reading = DealershipReadingGas::where('id', $id)->first();
        if (empty($reading->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $complexes = Complex::all('id', 'alias_name');
        $dealerships = Dealership::where('service', 'Gás')->get();

        // $reports = ViewsApartmentReport::where('dealership_reading_id', $id)->get();
        // if ($request->ajax()) {
        //     return Datatables::of($reports)
        //         ->addIndexColumn()
        //         ->make(true);
        // }

        // return view('admin.dealerships-readings-gas.edit', compact('reading', 'complexes', 'dealerships', 'reports'));
        return view('admin.dealerships-readings-gas.edit', compact('reading', 'complexes', 'dealerships'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DealershipReadingGasRequest $request, $id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Leitura das Concessionárias')) {
            abort(403, 'Acesso não autorizado');
        }

        $reading = DealershipReadingGas::where('id', $id)->first();
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

        $data['editor'] = Auth::user()->id;

        if ($reading->update($data)) {
            return redirect()
                ->route('admin.dealerships-readings-gas.index')
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

        $reading = DealershipReadingGas::where('id', $id)->first();

        if (empty($reading->id)) {
            abort(403, 'Acesso não autorizado');
        }

        // $reports = $reading->apartmentReports;

        if ($reading->delete()) {
            // if ($reports->count() > 0) {
            //     foreach ($reports as $report) {
            //         $report->delete();
            //     }
            // }
            return redirect()
                ->back()
                ->with('success', 'Exclusão realizada!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir!');
        }
    }

    public function batchDelete(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Excluir Leitura das Concessionárias')) {
            abort(403, 'Acesso não autorizado');
        }

        if (!$request->ids) {
            return redirect()
                ->back()
                ->with('error', 'Selecione ao menos uma linha!');
        }

        $ids = explode(",", $request->ids);

        foreach ($ids as $id) {
            $reading = DealershipReadingGas::where('id', $id)->first();

            if (empty($reading->id)) {
                abort(403, 'Acesso não autorizado');
            }

            $reading->delete();
            // ApartmentReport::where('dealership_reading_id', $id)->delete();
            // Notification::where('apartment_id', $id)->delete();
        }

        return redirect()
            ->route('admin.dealerships-readings-gas.index')
            ->with('success', 'Contas das Concessionárias excluídas!');
    }
}
