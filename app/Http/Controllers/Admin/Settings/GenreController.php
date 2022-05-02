<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Settings\GenreRequest;
use App\Models\Settings\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GenreController extends Controller
{

    public function index()
    {
        if (!Auth::user()->hasPermissionTo('Listar Gêneros')) {
            abort(403, 'Acesso não autorizado');
        }
        $genres = Genre::all();
        return view('admin.settings.genres.index', compact('genres'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('Criar Gêneros')) {
            abort(403, 'Acesso não autorizado');
        }
        return view('admin.settings.genres.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GenreRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Gêneros')) {
            abort(403, 'Acesso não autorizado');
        }
        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        $genre = Genre::create($data);

        if ($genre->save()) {
            return redirect()
                ->route('admin.genres.index')
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
        if (!Auth::user()->hasPermissionTo('Editar Gêneros')) {
            abort(403, 'Acesso não autorizado');
        }
        $genre = Genre::where('id', $id)->first();
        if (empty($genre->id)) {
            abort(403, 'Acesso não autorizado');
        }
        return view('admin.settings.genres.edit', compact('genre'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GenreRequest $request, $id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Gêneros')) {
            abort(403, 'Acesso não autorizado');
        }
        $data = $request->all();
        $genre = Genre::where('id', $id)->first();
        if (empty($genre->id)) {
            abort(403, 'Acesso não autorizado');
        }
        $data['user_id'] = auth()->user()->id;
        if ($genre->update($data)) {
            return redirect()
                ->route('admin.genres.index')
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
        $genre = Genre::where('id', $id)->first();
        if (empty($genre->id)) {
            abort(403, 'Acesso não autorizado');
        }
        if ($genre->delete()) {
            return redirect()
                ->route('admin.genres.index')
                ->with('success', 'Exclusão realizada!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir!');
        }
    }
}
