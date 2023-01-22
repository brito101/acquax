<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SyndicRequest;
use App\Models\Complex;
use App\Models\Syndic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SyndicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Listar Síndicos')) {
            abort(403, 'Acesso não autorizado');
        }

        if ($request['complex']) {
            $complex = Complex::where('id', $request['complex'])->first();
            if (empty($complex->id)) {
                abort(403, 'Acesso não autorizado');
            } else {
                $syndics = Syndic::where('complex_id', $complex->id)->get();
            }
        } else {
            $syndics = Syndic::all();
        }

        return view('admin.syndics.index', compact('syndics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('Criar Síndicos')) {
            abort(403, 'Acesso não autorizado');
        }

        $prev = (substr(url()->previous(), strpos(url()->previous(), '=') + 1));

        if ($prev) {
            $complex = Complex::where('id', $prev)->first();
            if (empty($complex->id)) {
                $complexes = Complex::all();
            } else {
                $complexes = Complex::where('id', $complex->id)->get();
            }
        } else {
            $complexes = Complex::all();
        }

        $users = User::role(['Usuário'])->get();

        return view('admin.syndics.create', compact('users', 'complexes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SyndicRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Síndicos')) {
            abort(403, 'Acesso não autorizado');
        }

        $complex = Complex::where('id', $request['complex_id'])->first();
        if (empty($complex->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $user = User::where('id', $request['user_id'])->first();
        if (empty($user->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();

        $data['editor'] = Auth::user()->id;

        $syndic = Syndic::create($data);

        if ($syndic->save()) {
            if ($request['from']) {
                return redirect($request['from'])
                    ->with('success', 'Cadastro realizado!');
            } else {
                return redirect()
                    ->route('admin.syndics.index')
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
        if (!Auth::user()->hasPermissionTo('Editar Síndicos')) {
            abort(403, 'Acesso não autorizado');
        }

        $syndic = Syndic::where('id', $id)->first();
        if (empty($syndic->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $complexes = Complex::all();
        $users = User::role(['Usuário'])->get();

        return view('admin.syndics.edit', compact('syndic', 'complexes', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SyndicRequest $request, $id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Síndicos')) {
            abort(403, 'Acesso não autorizado');
        }

        $syndic = Syndic::where('id', $id)->first();
        if (empty($syndic->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();
        $data['editor'] = Auth::user()->id;

        if ($syndic->update($data)) {
            if ($request['from']) {
                return redirect($request['from'])
                    ->with('success', 'Cadastro realizado!');
            } else {
                return redirect()
                    ->route('admin.syndics.index')
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
        if (!Auth::user()->hasPermissionTo('Excluir Síndicos')) {
            abort(403, 'Acesso não autorizado');
        }

        $syndic = Syndic::where('id', $id)->first();

        if (empty($syndic->id)) {
            abort(403, 'Acesso não autorizado');
        }

        if ($syndic->delete()) {
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
        if (!Auth::user()->hasPermissionTo('Excluir Síndicos')) {
            abort(403, 'Acesso não autorizado');
        }

        if (!$request->ids) {
            return redirect()
                ->back()
                ->with('error', 'Selecione ao menos uma linha!');
        }

        $ids = explode(",", $request->ids);

        foreach ($ids as $id) {
            $syndic = Syndic::find($id);

            if (!$syndic) {
                abort(403, 'Acesso não autorizado');
            }
            $syndic->delete();
        }

        return redirect()
            ->route('admin.syndics.index')
            ->with('success', 'Síndicos excluídos!');
    }
}
