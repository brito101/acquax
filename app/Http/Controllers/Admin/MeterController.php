<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MeterRequest;
use App\Imports\MetersImport;
use App\Models\Apartment;
use App\Models\Settings\TypeMeter;
use App\Models\Meter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class MeterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->hasPermissionTo('Listar Medidores')) {
            abort(403, 'Acesso não autorizado');
        }
        $meters = Meter::all();
        return view('admin.meters.index', compact('meters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('Criar Medidores')) {
            abort(403, 'Acesso não autorizado');
        }

        $apartments = Apartment::all();
        $typeMeters = TypeMeter::all();

        return view('admin.meters.create', compact('typeMeters', 'apartments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MeterRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Medidores')) {
            abort(403, 'Acesso não autorizado');
        }

        $apartment = Apartment::where('id', $request['apartment_id'])->first();
        if (empty($apartment->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();

        $data['user_id'] = Auth::user()->id;

        $meter = Meter::create($data);

        if ($meter->save()) {
            if ($request['from']) {
                return redirect($request['from'])
                    ->with('success', 'Cadastro realizado!');
            } else {
                return redirect()
                    ->route('admin.meters.index')
                    ->with('success', 'Cadastro realizado!');
            }
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
        if (!Auth::user()->hasPermissionTo('Editar Medidores')) {
            abort(403, 'Acesso não autorizado');
        }

        $meter = Meter::where('id', $id)->first();
        if (empty($meter->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $apartments = Apartment::all();
        $typeMeters = TypeMeter::all();

        return view('admin.meters.edit', compact('meter', 'apartments', 'typeMeters'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MeterRequest $request, $id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Medidores')) {
            abort(403, 'Acesso não autorizado');
        }

        $meter = Meter::where('id', $id)->first();
        if (empty($meter->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        if ($meter->update($data)) {
            if ($request['from']) {
                return redirect($request['from'])
                    ->with('success', 'Cadastro realizado!');
            } else {
                return redirect()
                    ->route('admin.meters.index')
                    ->with('success', 'Cadastro realizado!');
            }
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
        if (!Auth::user()->hasPermissionTo('Excluir Medidores')) {
            abort(403, 'Acesso não autorizado');
        }

        $meter = Meter::where('id', $id)->first();

        if (empty($meter->id)) {
            abort(403, 'Acesso não autorizado');
        }

        if ($meter->delete()) {
            return redirect()
                ->back()
                ->with('success', 'Exclusão realizada!');
        } else {
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
        Excel::import(new MetersImport, $request->file('file')->store('temp'));
        return back()->with('success', 'Importação realizada!');;
    }
}
