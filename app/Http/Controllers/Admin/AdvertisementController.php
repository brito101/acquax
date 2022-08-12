<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdvertisementRequest;
use App\Models\Advertisement;
use App\Models\AdvertisingComplex;
use App\Models\Complex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->hasPermissionTo('Listar Propagandas')) {
            abort(403, 'Acesso não autorizado');
        }

        $advertisements = Advertisement::orderBy('created_at', 'desc')->paginate();
        return view('admin.advertisements.index', compact('advertisements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('Criar Propagandas')) {
            abort(403, 'Acesso não autorizado');
        }

        $complexes = Complex::orderBy('alias_name')->get();

        return view('admin.advertisements.create', compact('complexes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdvertisementRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Propagandas')) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();

        if ($request->hasFile('cover') && $request->file('cover')->isValid()) {
            $name = Str::slug(mb_substr($data['title'], 0, 100)) . time();
            $extension = $request->cover->extension();
            $nameFile = "{$name}.{$extension}";

            $data['cover'] = $nameFile;

            $destinationPath = storage_path() . '/app/public/advertisements';
            $img = Image::make($request->cover);
            $img->resize(null, 800, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($destinationPath . '/' . $nameFile);

            if (!$img) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Falha ao fazer o upload da imagem');
            }
        }

        $data['editor'] = Auth::user()->id;

        $advertisement = Advertisement::create($data);

        if ($advertisement->save()) {
            if ($request->complexes) {
                foreach ($request->complexes as $complex) {
                    $item = new AdvertisingComplex();
                    $item->complex_id = $complex;
                    $item->advertisement_id = $advertisement->id;
                    $item->save();
                }
            }
            return redirect()
                ->route('admin.advertisements.index')
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
        if (!Auth::user()->hasPermissionTo('Editar Propagandas')) {
            abort(403, 'Acesso não autorizado');
        }

        $advertisement = Advertisement::find($id);

        if (!$advertisement) {
            abort(403, 'Acesso não autorizado');
        }

        $complexes = Complex::orderBy('alias_name')->get();
        $advertisingComplex = AdvertisingComplex::whereIn('complex_id', $complexes->pluck('id'))->get();

        return view('admin.advertisements.edit', compact('advertisement', 'complexes', 'advertisingComplex'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdvertisementRequest $request, $id)
    {

        if (!Auth::user()->hasPermissionTo('Editar Propagandas')) {
            abort(403, 'Acesso não autorizado');
        }

        $advertisement = Advertisement::find($id);

        if (!$advertisement) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();

        if ($request->hasFile('cover') && $request->file('cover')->isValid()) {
            $name = Str::slug(mb_substr($data['title'], 0, 100)) . time();
            $extension = $request->cover->extension();
            $nameFile = "{$name}.{$extension}";

            $imagePath = storage_path() . '/app/public/advertisements/' . $advertisement->cover;

            if (File::isFile($imagePath)) {
                unlink($imagePath);
            }

            $data['cover'] = $nameFile;

            $destinationPath = storage_path() . '/app/public/advertisements';
            $img = Image::make($request->cover);
            $img->resize(null, 800, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($destinationPath . '/' . $nameFile);

            if (!$img)
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Falha ao fazer o upload da imagem');
        }

        $data['editor'] = Auth::user()->id;

        if ($advertisement->update($data)) {
            if ($request->complexes) {
                $old = AdvertisingComplex::where('advertisement_id', $advertisement->id)->get();
                if ($old) {
                    foreach ($old as $o) {
                        $o->delete();
                    }
                }
                foreach ($request->complexes as $complex) {
                    $item = new AdvertisingComplex();
                    $item->complex_id = $complex;
                    $item->advertisement_id = $advertisement->id;
                    $item->save();
                }
            }
            return redirect()
                ->route('admin.advertisements.index')
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
        if (!Auth::user()->hasPermissionTo('Excluir Propagandas')) {
            abort(403, 'Acesso não autorizado');
        }

        $advertisement = Advertisement::find($id);

        if (!$advertisement) {
            abort(403, 'Acesso não autorizado');
        }

        $imagePath = storage_path() . '/app/public/advertisements/' . $advertisement->cover;
        if ($advertisement->delete()) {
            if (File::isFile($imagePath)) {
                unlink($imagePath);
                $advertisement->cover = null;
                $advertisement->update();
            }

            $old = AdvertisingComplex::where('advertisement_id', $advertisement->id)->get();
            if ($old) {
                foreach ($old as $o) {
                    $o->delete();
                }
            }

            return redirect()
                ->route('admin.advertisements.index')
                ->with('success', 'Exclusão realizada!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir!');
        }
    }
}
