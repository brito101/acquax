<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlockRequest;
use App\Models\Apartment;
use App\Models\Block;
use App\Models\Complex;
use App\Models\Meter;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Listar Blocos')) {
            abort(403, 'Acesso não autorizado');
        }

        if ($request['complex']) {
            $complex = Complex::where('id', $request['complex'])->first();
            if (empty($complex->id)) {
                abort(403, 'Acesso não autorizado');
            }
            $blocks = Block::where('complex_id', $request['complex'])->get();
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
    public function create(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Blocos')) {
            abort(403, 'Acesso não autorizado');
        }

        $prev = (substr(url()->previous(), strpos(url()->previous(), '=') + 1));

        if ($prev) {
            $complex = Complex::where('id', $prev)->first();
            if (empty($complex->id)) {
                $complex = Complex::all();
            }
        } else {
            $complex = Complex::all();
        }

        return view('admin.blocks.create', compact('complex'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlockRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Blocos')) {
            abort(403, 'Acesso não autorizado');
        }

        $complex = Complex::where('id', $request['complex_id'])->first();
        if (empty($complex->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();

        $data['user_id'] = Auth::user()->id;

        $block = Block::create($data);

        if ($block->save()) {
            if ($request['from']) {
                return redirect($request['from'])
                    ->with('success', 'Cadastro realizado!');
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
    public function edit($id)
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
            if ($request['from']) {
                return redirect($request['from'])
                    ->with('success', 'Cadastro realizado!');
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

            $apartments = Apartment::where('block_id', $id)->get();
            if ($apartments->isNotEmpty()) {
                foreach ($apartments as $apartment) {
                    if ($apartments->isNotEmpty()) {
                        $residents = Resident::where('apartment_id', $apartment->id)->get();
                        if ($residents->isNotEmpty()) {
                            foreach ($residents as $resident) {
                                $resident->delete();
                            }
                        }
                        $meters = Meter::where('apartment_id', $apartment->id)->get();
                        if ($meters->isNotEmpty()) {
                            foreach ($meters as $meter) {
                                $meter->delete();
                            }
                        }
                        $apartment->delete();
                    }
                }
            }

            return redirect()
                ->back()
                ->with('success', 'Exclusão realizada!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir!');
        }
    }
}
