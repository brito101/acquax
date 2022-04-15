<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ComplexRequest;
use App\Models\Apartment;
use App\Models\Block;
use App\Models\Complex;
use App\Models\Resident;
use App\Models\Syndic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ComplexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->hasPermissionTo('Listar Condomínios')) {
            abort(403, 'Acesso não autorizado');
        }

        $complexes = Complex::orderBy('created_at', 'desc')->paginate(6);

        return view('admin.complexes.index', compact('complexes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('Criar Condomínios')) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.complexes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ComplexRequest $request)
    {

        if (!Auth::user()->hasPermissionTo('Criar Condomínios')) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $name = Str::slug(mb_substr($data['alias_name'], 0, 100)) . time();
            $extenstion = $request->photo->extension();
            $nameFile = "{$name}.{$extenstion}";
            $data['photo'] = $nameFile;
            $upload = $request->photo->storeAs('complexes', $nameFile);

            if (!$upload) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Falha ao fazer o upload da imagem');
            }
        }

        $complex = Complex::create($data);

        if ($complex->save()) {
            return redirect()
                ->route('admin.complexes.index')
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
        if (!Auth::user()->hasPermissionTo('Editar Condomínios')) {
            abort(403, 'Acesso não autorizado');
        }

        $complex = Complex::where('id', $id)->first();

        if (empty($complex->id)) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.complexes.edit', compact('complex'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ComplexRequest $request, $id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Condomínios')) {
            abort(403, 'Acesso não autorizado');
        }

        $complex = Complex::where('id', $id)->first();

        if (empty($complex->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $name = Str::slug(mb_substr($data['alias_name'], 0, 10)) . time();
            $imagePath = storage_path() . '/app/public/complexes/' . $complex->photo;

            if (File::isFile($imagePath)) {
                unlink($imagePath);
            }

            $extenstion = $request->photo->extension();
            $nameFile = "{$name}.{$extenstion}";

            $data['photo'] = $nameFile;

            $upload = $request->photo->storeAs('complexes', $nameFile);

            if (!$upload) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Falha ao fazer o upload da imagem');
            }
        }

        if ($complex->update($data)) {
            return redirect()
                ->route('admin.complexes.index')
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
        if (!Auth::user()->hasPermissionTo('Excluir Condomínios')) {
            abort(403, 'Acesso não autorizado');
        }

        $complex = Complex::where('id', $id)->first();

        if (empty($complex->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $imagePath = storage_path() . '/app/public/complexes/' . $complex->photo;
        if ($complex->delete()) {
            if (File::isFile($imagePath)) {
                unlink($imagePath);
                $complex->photo = null;
                $complex->update();
            }

            $blocks = Block::where('complex_id', $id)->get();
            if ($blocks->isNotEmpty()) {
                foreach ($blocks as $block) {
                    $apartments = Apartment::where('block_id', $block->id)->get();
                    if ($apartments->isNotEmpty()) {
                        foreach ($apartments as $apartment) {
                            $residents = Resident::where('apartment_id', $apartment->id)->get();
                            if ($residents->isNotEmpty()) {
                                foreach ($residents as $resident) {
                                    $resident->delete();
                                }
                            }
                            $apartment->delete();
                        }
                    }
                    $block->delete();
                }
            }

            $syndics = Syndic::where('complex_id', $id)->get();
            if ($syndics->isNotEmpty()) {
                foreach ($syndics as $syndic) {
                    $syndic->delete();
                }
            }

            return redirect()
                ->route('admin.complexes.index')
                ->with('success', 'Exclusão realizada!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir!');
        }
    }
}
