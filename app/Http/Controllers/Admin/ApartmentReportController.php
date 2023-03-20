<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ApartmentReportRequest;
use App\Imports\ApartmentReportImport;
use App\Models\Apartment;
use App\Models\ApartmentReport;
use App\Models\DealershipReading;
use App\Models\Meter;
use App\Models\Notification;
use App\Models\Reading;
use App\Models\Views\ApartmentReport as ViewsApartmentReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Maatwebsite\Excel\Facades\Excel;

class ApartmentReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Listar Relatórios')) {
            abort(403, 'Acesso não autorizado');
        }

        $reports = ViewsApartmentReport::query();
        if ($request->ajax()) {
            return Datatables::of($reports)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-xs btn-primary mx-1 shadow" title="Editar" href="reports/' . $row->id . '/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>' . '<a class="btn btn-xs btn-danger mx-1 shadow" title="Excluir" href="reports/destroy/' . $row->id . '" onclick="return confirm(\'Confirma a exclusão deste relatório?\')"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.reports.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('Criar Relatórios')) {
            abort(403, 'Acesso não autorizado');
        }

        $dealershipReadings = DealershipReading::orderBy('created_at', 'desc')->get();

        return \view('admin.reports.create', compact('dealershipReadings'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApartmentReportRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Relatórios')) {
            abort(403, 'Acesso não autorizado');
        }

        $dealershipReading = DealershipReading::find($request->dealership_reading_id);
        $data = $request->all();
        $year = $dealershipReading->year_ref;
        $month = $dealershipReading->month_ref;
        $data['year_ref'] = $year;
        $data['month_ref'] = $month;

        $meters = Meter::where('apartment_id', $request->apartment_id)->pluck('id');
        $readings = Reading::whereIn('meter_id', $meters)
            ->where('year_ref', $year)
            ->where('month_ref', $month)
            ->pluck('id');
        $data['readings'] = $readings->toArray();

        $data['editor'] = Auth::user()->id;

        $apartmentReport = ApartmentReport::create($data);

        if ($apartmentReport->save()) {
            $old = ApartmentReport::where('apartment_id', $apartmentReport->apartment_id)
                ->where('year_ref', $year)
                ->where('month_ref', $month)
                ->where('id', '!=', $apartmentReport->id)
                ->delete();
            return redirect()
                ->route('admin.reports.index')
                ->with('success', 'Cadastro realizado!');
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erro ao cadastrar!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Relatórios')) {
            abort(403, 'Acesso não autorizado');
        }

        $report = ApartmentReport::find($id);
        if (!$report) {
            abort(403, 'Acesso não autorizado');
        }

        $dealershipReadings = DealershipReading::orderBy('created_at', 'desc')->get();

        return view('admin.reports.edit', compact('report', 'dealershipReadings'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ApartmentReportRequest $request, $id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Relatórios')) {
            abort(403, 'Acesso não autorizado');
        }

        $report = ApartmentReport::find($id);
        if (!$report) {
            abort(403, 'Acesso não autorizado');
        }

        $dealershipReading = DealershipReading::find($request->dealership_reading_id);
        $data = $request->all();
        $year = $dealershipReading->year_ref;
        $month = $dealershipReading->month_ref;
        $data['year_ref'] = $year;
        $data['month_ref'] = $month;

        $meters = Meter::where('apartment_id', $request->apartment_id)->pluck('id');
        $readings = Reading::whereIn('meter_id', $meters)
            ->where('year_ref', $year)
            ->where('month_ref', $month)
            ->pluck('id');
        $data['readings'] = $readings->toArray();

        if ($report->update($data)) {
            $old = ApartmentReport::where('apartment_id', $report->apartment_id)
                ->where('year_ref', $year)
                ->where('month_ref', $month)
                ->where('id', '!=', $report->id)
                ->delete();
            return redirect()
                ->route('admin.reports.index')
                ->with('success', 'Edição realizada!');
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erro ao atualizar!');
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
        if (!Auth::user()->hasPermissionTo('Excluir Relatórios')) {
            abort(403, 'Acesso não autorizado');
        }

        $report = ApartmentReport::find($id);

        if (!$report) {
            abort(403, 'Acesso não autorizado');
        }

        if ($report->delete()) {
            return redirect()
                ->route('admin.reports.index')
                ->with('success', 'Exclusão realizada!');
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir!');
        }
    }

    public function fileImport(Request $request)
    {
        if (!$request->file()) {
            return redirect()
                ->back()
                ->with('error', 'Nenhum arquivo selecionado!');
        }
        Excel::import(new ApartmentReportImport, $request->file('file')->store('temp'));
        return back()->with('success', 'Importação realizada!');;
    }

    public function batchDelete(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Excluir Relatórios')) {
            abort(403, 'Acesso não autorizado');
        }

        if (!$request->ids) {
            return redirect()
                ->back()
                ->with('error', 'Selecione ao menos uma linha!');
        }

        $ids = explode(",", $request->ids);

        foreach ($ids as $id) {
            $report = ApartmentReport::find($id);

            if (!$report) {
                abort(403, 'Acesso não autorizado');
            }

            $report->delete();
            Notification::where('apartment_id', $id)->delete();
        }

        return redirect()
            ->route('admin.reports.index')
            ->with('success', 'Relatórios excluídos!');
    }
}
