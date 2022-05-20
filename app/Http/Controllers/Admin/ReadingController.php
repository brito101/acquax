<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReadingRequest;
use App\Models\Complex;
use App\Models\Meter;
use App\Models\Reading;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use JeroenNoten\LaravelAdminLte\View\Components\Tool\Datatable;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ReadingsImport;

class ReadingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->hasPermissionTo('Listar Leituras')) {
            abort(403, 'Acesso não autorizado');
        }

        $complexes = Complex::all();
        $readings = Reading::orderBy('id', 'desc')->paginate(24);
        return view('admin.readings.index', compact('readings', 'complexes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('Criar Leituras')) {
            abort(403, 'Acesso não autorizado');
        }

        $meters = Meter::all();
        return view('admin.readings.create', compact('meters'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReadingRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Leituras')) {
            abort(403, 'Acesso não autorizado');
        }

        $meter = Meter::where('id', $request['meter_id'])->first();
        if (empty($meter->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();

        $data['editor'] = Auth::user()->id;

        if ($request->hasFile('cover') && $request->file('cover')->isValid()) {
            $name = Str::slug(mb_substr($data['meter_id'], 0, 100) . '-' . $data['month_ref']) . time();
            $extenstion = $request->cover->extension();
            $nameFile = "{$name}.{$extenstion}";
            $data['cover'] = $nameFile;
            $upload = $request->cover->storeAs('readings', $nameFile);

            if (!$upload) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Falha ao fazer o upload da imagem');
            }
        }

        $reading = Reading::create($data);

        if ($reading->save()) {
            if ($request['from']) {
                return redirect($request['from'])
                    ->with('success', 'Cadastro realizado!');
            } else {
                return redirect()
                    ->route('admin.readings.index')
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
        if (!Auth::user()->hasPermissionTo('Editar Leituras')) {
            abort(403, 'Acesso não autorizado');
        }

        $reading = Reading::where('id', $id)->first();
        if (empty($reading->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $meters = Meter::all();

        return view('admin.readings.edit', compact('meters', 'reading'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReadingRequest $request, $id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Leituras')) {
            abort(403, 'Acesso não autorizado');
        }

        $meter = Meter::where('id', $request['meter_id'])->first();
        if (empty($meter->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $reading = Reading::where('id', $id)->first();
        if (empty($reading->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();
        $data['editor'] = Auth::user()->id;

        if ($request->hasFile('cover') && $request->file('cover')->isValid()) {
            $name = Str::slug(mb_substr($data['meter_id'], 0, 100) . '-' . $data['month_ref']) . time();
            $imagePath = storage_path() . '/app/public/readings/' . $reading->cover;
            $imagePathBase64 = storage_path() . '/app/public/readings/' . $reading->cover_base64;

            if (File::isFile($imagePath)) {
                unlink($imagePath);
            }

            if (File::isFile($imagePathBase64)) {
                unlink($imagePathBase64);
            }

            $extenstion = $request->cover->extension();
            $nameFile = "{$name}.{$extenstion}";

            $data['cover'] = $nameFile;
            $data['cover_base64'] = null;

            $upload = $request->cover->storeAs('readings', $nameFile);

            if (!$upload)
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Falha ao fazer o upload da imagem');
        }

        if ($reading->update($data)) {
            if ($request['from']) {
                return redirect($request['from'])
                    ->with('success', 'Cadastro realizado!');
            } else {
                return redirect()
                    ->route('admin.readings.index')
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
        if (!Auth::user()->hasPermissionTo('Excluir Leituras')) {
            abort(403, 'Acesso não autorizado');
        }

        $reading = Reading::where('id', $id)->first();

        if (empty($reading->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $imagePath = storage_path() . '/app/public/readings/' . $reading->cover;
        $imagePathBase64 = storage_path() . '/app/public/readings/' . $reading->cover_base64;

        if ($reading->delete()) {
            if (File::isFile($imagePath)) {
                unlink($imagePath);
                $reading->cover = null;
                $reading->update();
            }

            if (File::isFile($imagePathBase64)) {
                unlink($imagePathBase64);
                $reading->cover_base64 = null;
                $reading->update();
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

    public function search(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Listar Leituras')) {
            abort(403, 'Acesso não autorizado');
        }

        $complexes = Complex::all();
        $query = Reading::query();

        $query->when(request('month_ref') != 'null', function ($q) {
            return $q->where('month_ref', request('month_ref'));
        });
        $query->when(request('year') != 'null', function ($q) {
            return $q->where('year_ref', request('year'));
        });
        $query->when(request('id') != null, function ($q) {
            return $q->where('id', request('id'));
        });

        if ($request['complex_id'] != 'null') {
            $complex = Complex::where('id', $request['complex_id'])->first();
            $meter_list = Meter::whereIn('apartment_id', $complex->apartments->pluck('id'))->get();
            $readings = $query->whereIn('meter_id', $meter_list->pluck('id'))->orderBy('id', 'desc')->paginate(24);
        } else {
            $readings = $query->orderBy('id', 'desc')->paginate(24);
        }

        return view('admin.readings.index', compact('readings', 'complexes'));
    }

    public function fileImport(Request $request)
    {
        if (!$request->file()) {
            return redirect()
                ->back()
                ->with('error', 'Nenhum arquivo selecionado!');
        }
        Excel::import(new ReadingsImport, $request->file('file')->store('temp'));
        return back()->with('success', 'Importação realizada!');;
    }
}
