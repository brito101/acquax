<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ApartmentRequest;
use App\Models\Apartment;
use App\Models\Block;
use App\Models\Complex;
use App\Models\Meter;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Listar Apartamentos')) {
            abort(403, 'Acesso não autorizado');
        }

        if ($request['complex']) {
            $complex = Complex::where('id', $request['complex'])->first();
            if (empty($complex->id)) {
                abort(403, 'Acesso não autorizado');
            } else {
                $blocks = Block::where('complex_id', $complex->id)->get();
                $apartments = Apartment::whereIn('block_id', $blocks->pluck('id'))->get();
            }
        } else {
            $apartments = Apartment::all();
        }

        return view('admin.apartments.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Apartamentos')) {
            abort(403, 'Acesso não autorizado');
        }

        $prev = (substr(url()->previous(), strpos(url()->previous(), '=') + 1));

        if ($prev) {
            $complex = Complex::where('id', $prev)->first();
            if (empty($complex->id)) {
                $complex = null;
                $blocks = Block::all();
            } else {
                $blocks = Block::where('complex_id', $complex->id)->get();
            }
        } else {
            $complex = null;
            $blocks = Block::all();
        }

        return view('admin.apartments.create', compact('blocks', 'complex'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApartmentRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Apartamentos')) {
            abort(403, 'Acesso não autorizado');
        }

        $block = Block::where('id', $request['block_id'])->first();
        if (empty($block->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();

        $data['user_id'] = Auth::user()->id;
        $apartment = Apartment::create($data);

        if ($apartment->save()) {
            if ($request['from']) {
                return redirect($request['from'])
                    ->with('success', 'Cadastro realizado!');
            } else {
                return redirect()
                    ->route('admin.apartments.index')
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
        if (!Auth::user()->hasPermissionTo('Editar Apartamentos')) {
            abort(403, 'Acesso não autorizado');
        }

        $apartment = Apartment::where('id', $id)->first();
        if (empty($apartment->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $blocks = Block::where('complex_id', $apartment->block->complex_id)->get();

        return view('admin.apartments.edit', compact('blocks', 'apartment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ApartmentRequest $request, $id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Apartamentos')) {
            abort(403, 'Acesso não autorizado');
        }

        $apartment = Apartment::where('id', $id)->first();
        if (empty($apartment->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        if ($apartment->update($data)) {
            if ($request['from']) {
                return redirect($request['from'])
                    ->with('success', 'Cadastro realizado!');
            } else {
                return redirect()
                    ->route('admin.apartments.edit')
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
        if (!Auth::user()->hasPermissionTo('Excluir Apartamentos')) {
            abort(403, 'Acesso não autorizado');
        }

        $apartment = Apartment::where('id', $id)->first();

        if (empty($apartment->id)) {
            abort(403, 'Acesso não autorizado');
        }

        if ($apartment->delete()) {
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
