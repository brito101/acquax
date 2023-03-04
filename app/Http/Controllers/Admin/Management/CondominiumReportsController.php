<?php

namespace App\Http\Controllers\Admin\Management;

use App\Http\Controllers\Controller;
use App\Models\Management\Views\CondominiumReports;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;

class CondominiumReportsController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Listar Relatório de Condomínios')) {
            abort(403, 'Acesso não autorizado');
        }

        $reports = CondominiumReports::query();
        if ($request->ajax()) {
            return Datatables::of($reports)
                ->make(true);
        }

        return view('admin.management.condominiums.index');
    }
}
