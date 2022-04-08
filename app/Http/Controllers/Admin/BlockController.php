<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlockRequest;
use App\Models\Block;
use App\Models\Complex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = null)
    {
        if (!Auth::user()->hasPermissionTo('Listar Blocos')) {
            abort(403, 'Acesso não autorizado');
        }

        if ($id) {
            $complex = Complex::where('id', $id)->first();
            if (empty($complex->id)) {
                abort(403, 'Acesso não autorizado');
            }
            $blocks = Block::where('complex_id', $id)->get();
        } else {
            $complex = Complex::all();
            $blocks = Block::all();
        }

        return view('admin.blocks.index', compact('blocks', 'complex'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        if (!Auth::user()->hasPermissionTo('Criar Blocos')) {
            abort(403, 'Acesso não autorizado');
        }

        if ($id == 'new') {
            $complex = Complex::all();
        } else {
            $complex = Complex::where('id', $id)->first();
            if (empty($complex->id)) {
                abort(403, 'Acesso não autorizado');
            }
        }

        return view('admin.blocks.create', compact('complex'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlockRequest $request, $id)
    {
        if (!Auth::user()->hasPermissionTo('Criar Blocos')) {
            abort(403, 'Acesso não autorizado');
        }

        if ($id == 'new') {
            $data = $request->all();
        } else {
            $complex = Complex::where('id', $id)->first();
            if (empty($complex->id)) {
                abort(403, 'Acesso não autorizado');
            }
            $data = $request->all();
            $data['complex_id'] = $id;
        }

        $data['user_id'] = Auth::user()->id;

        $block = Block::create($data);

        if ($block->save()) {
            if ($request['from']) {
                $complex = Complex::where('id', $id)->first();
                if (!empty($complex->id)) {
                    return redirect()
                        ->route('admin.blocks.index', ['complex' => $complex->id])
                        ->with('success', 'Cadastro realizado!');
                }
            } else {
                return redirect()
                    ->route('admin.blocks.index')
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
    public function edit(Request $request, $id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Blocos')) {
            abort(403, 'Acesso não autorizado');
        }

        $block = Block::where('id', $id)->first();
        if (empty($block->id)) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.blocks.edit', compact('block'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlockRequest $request, $id)
    {

        if (!Auth::user()->hasPermissionTo('Editar Blocos')) {
            abort(403, 'Acesso não autorizado');
        }

        $block = Block::where('id', $id)->first();
        if (empty($block->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        if ($block->update($data)) {
            return redirect()
                ->route('admin.blocks.index')
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
        if (!Auth::user()->hasPermissionTo('Excluir Blocos')) {
            abort(403, 'Acesso não autorizado');
        }

        $block = Block::where('id', $id)->first();

        if (empty($block->id)) {
            abort(403, 'Acesso não autorizado');
        }

        if ($block->delete()) {
            return redirect()
                ->route('admin.blocks.index')
                ->with('success', 'Exclusão realizada!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir!');
        }
    }
}
