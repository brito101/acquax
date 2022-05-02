<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Settings\TypeMetersRequest;
use App\Models\Settings\TypeMeter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TypeMetersController extends Controller
{
    public function index()
    {
        if (!Auth::user()->hasPermissionTo('Listar Tipos de Medidores')) {
            abort(403, 'Acesso não autorizado');
        }
        $typeMeters = TypeMeter::all();
        return view('admin.settings.typeMeters.index', compact('typeMeters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('Criar Tipos de Medidores')) {
            abort(403, 'Acesso não autorizado');
        }
        return view('admin.settings.typeMeters.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TypeMetersRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Tipos de Medidores')) {
            abort(403, 'Acesso não autorizado');
        }
        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        $typeMeter = TypeMeter::create($data);

        if ($typeMeter->save()) {
            return redirect()
                ->route('admin.type-meters.index')
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
        if (!Auth::user()->hasPermissionTo('Editar Tipos de Medidores')) {
            abort(403, 'Acesso não autorizado');
        }
        $typeMeter = TypeMeter::where('id', $id)->first();
        if (empty($typeMeter->id)) {
            abort(403, 'Acesso não autorizado');
        }
        return view('admin.settings.typeMeters.edit', compact('typeMeter'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TypeMetersRequest $request, $id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Tipos de Medidores')) {
            abort(403, 'Acesso não autorizado');
        }
        $data = $request->all();
        $typeMeter = TypeMeter::where('id', $id)->first();
        if (empty($typeMeter->id)) {
            abort(403, 'Acesso não autorizado');
        }
        if ($typeMeter->update($data)) {
            return redirect()
                ->route('admin.type-meters.index')
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
        if (!Auth::user()->hasPermissionTo('Excluir Gêneros')) {
            abort(403, 'Acesso não autorizado');
        }
        $typeMeter = TypeMeter::where('id', $id)->first();
        if (empty($typeMeter->id)) {
            abort(403, 'Acesso não autorizado');
        }
        if ($typeMeter->delete()) {
            return redirect()
                ->route('admin.type-meters.index')
                ->with('success', 'Exclusão realizada!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir!');
        }
    }
}
