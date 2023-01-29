<?php

namespace App\Http\Controllers\Admin\Management;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MeterReadersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->hasPermissionTo('Listar Relatório de Leitura X Leiturista')) {
            abort(403, 'Acesso não autorizado');
        }

        $guests = DB::table('guests')
            ->select('guests.user_id', 'users.name', DB::raw('count(*) as total'))
            ->where('executed', true)
            ->leftJoin('users', 'guests.user_id', 'users.id')
            ->groupBy('guests.user_id', 'users.name')
            ->get();

        $dataList = [];
        foreach ($guests as $guest) {
            $dataList[$guest->name] = $guest->total;
        }

        $chart = new \stdClass();
        $chart->labels = (array_keys($dataList));
        $chart->dataset = (array_values($dataList));

        return view('admin.management.meter-readers.index', \compact('chart'));
    }
}
