<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Settings\DealershipRequest;
use App\Models\Settings\Dealership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DealershipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->hasPermissionTo('Listar Concessionárias')) {
            abort(403, 'Acesso não autorizado');
        }
        $dealerships = Dealership::all();
        return view('admin.settings.dealerships.index', compact('dealerships'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('Criar Concessionárias')) {
            abort(403, 'Acesso não autorizado');
        }
        return view('admin.settings.dealerships.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DealershipRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Concessionárias')) {
            abort(403, 'Acesso não autorizado');
        }
        $data = $request->all();
        $data['editor'] = auth()->user()->id;
        $dealership = Dealership::create($data);

        if ($dealership->save()) {
            return redirect()
                ->route('admin.dealerships.index')
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
        if (!Auth::user()->hasPermissionTo('Editar Concessionárias')) {
            abort(403, 'Acesso não autorizado');
        }
        $dealership = Dealership::where('id', $id)->first();
        if (empty($dealership->id)) {
            abort(403, 'Acesso não autorizado');
        }
        return view('admin.settings.dealerships.edit', compact('dealership'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DealershipRequest $request, $id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Concessionárias')) {
            abort(403, 'Acesso não autorizado');
        }
        $data = $request->all();
        $dealership = Dealership::where('id', $id)->first();
        if (empty($dealership->id)) {
            abort(403, 'Acesso não autorizado');
        }
        $data['editor'] = auth()->user()->id;
        if ($dealership->update($data)) {
            return redirect()
                ->route('admin.dealerships.index')
                ->with('success', 'Atualização realizada!');
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
        if (!Auth::user()->hasPermissionTo('Excluir Concessionárias')) {
            abort(403, 'Acesso não autorizado');
        }
        $dealership = Dealership::where('id', $id)->first();
        if (empty($dealership->id)) {
            abort(403, 'Acesso não autorizado');
        }
        if ($dealership->delete()) {
            return redirect()
                ->route('admin.dealerships.index')
                ->with('success', 'Exclusão realizada!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir!');
        }
    }
}
