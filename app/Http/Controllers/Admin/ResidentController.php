<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ResidentRequest;
use App\Imports\ResidentsImport;
use App\Models\Apartment;
use App\Models\Resident;
use App\Models\User;
use App\Models\Views\Resident as ViewsResident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Maatwebsite\Excel\Facades\Excel;

class ResidentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Listar Moradores')) {
            abort(403, 'Acesso não autorizado');
        }

        $residents = ViewsResident::query();

        if ($request->ajax()) {
            return Datatables::eloquent($residents)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-xs btn-primary mx-1 shadow" title="Editar" href="residents/' . $row->id . '/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>' . '<a class="btn btn-xs btn-danger mx-1 shadow" title="Excluir" href="residents/destroy/' . $row->id . '" onclick="return confirm(\'Confirma a exclusão deste morador?\')"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.residents.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('Criar Moradores')) {
            abort(403, 'Acesso não autorizado');
        }

        $apartments = Apartment::all();
        $users = User::role(['Usuário'])->get();

        return view('admin.residents.create', compact('users', 'apartments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ResidentRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Moradores')) {
            abort(403, 'Acesso não autorizado');
        }

        $apartment = Apartment::where('id', $request['apartment_id'])->first();
        if (empty($apartment->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $user = User::where('id', $request['user_id'])->first();
        if (empty($user->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();

        $data['editor'] = Auth::user()->id;

        $resident = Resident::create($data);

        if ($resident->save()) {
            if ($request['from']) {
                return redirect($request['from'])
                    ->with('success', 'Cadastro realizado!');
            } else {
                return redirect()
                    ->route('admin.residents.index')
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
        if (!Auth::user()->hasPermissionTo('Editar Moradores')) {
            abort(403, 'Acesso não autorizado');
        }

        $resident = Resident::where('id', $id)->first();
        if (empty($resident->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $apartments = Apartment::all();
        $users = User::role(['Usuário'])->get();

        return view('admin.residents.edit', compact('resident', 'apartments', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ResidentRequest $request, $id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Moradores')) {
            abort(403, 'Acesso não autorizado');
        }

        $resident = Resident::where('id', $id)->first();
        if (empty($resident->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();
        $data['editor'] = Auth::user()->id;

        if ($resident->update($data)) {
            if ($request['from']) {
                return redirect($request['from'])
                    ->with('success', 'Cadastro realizado!');
            } else {
                return redirect()
                    ->route('admin.residents.index')
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
        if (!Auth::user()->hasPermissionTo('Excluir Moradores')) {
            abort(403, 'Acesso não autorizado');
        }

        $resident = Resident::where('id', $id)->first();

        if (empty($resident->id)) {
            abort(403, 'Acesso não autorizado');
        }

        if ($resident->delete()) {
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
        if (!Auth::user()->hasPermissionTo('Criar Moradores')) {
            abort(403, 'Acesso não autorizado');
        }

        if (!$request->file()) {
            return redirect()
                ->back()
                ->with('error', 'Nenhum arquivo selecionado!');
        }
        Excel::import(new ResidentsImport, $request->file('file')->store('temp'));
        return back()->with('success', 'Importação realizada!');
    }

    public function batchDelete(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Excluir Moradores')) {
            abort(403, 'Acesso não autorizado');
        }

        if (!$request->ids) {
            return redirect()
                ->back()
                ->with('error', 'Selecione ao menos uma linha!');
        }

        $ids = explode(",", $request->ids);

        foreach ($ids as $id) {
            $resident = Resident::find($id);

            if (!$resident) {
                abort(403, 'Acesso não autorizado');
            }
            $resident->delete();
        }

        return redirect()
            ->route('admin.residents.index')
            ->with('success', 'Moradores excluídos!');
    }
}
