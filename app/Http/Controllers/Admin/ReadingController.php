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
use App\Models\ApartmentReport;
use App\Models\Views\AdminReading;
use Illuminate\Support\Facades\Validator;
use Image;
use DataTables;

class ReadingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Listar Leituras')) {
            abort(403, 'Acesso não autorizado');
        }

        $readings = AdminReading::query();

        if ($request->ajax()) {
            return Datatables::of($readings)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-xs btn-primary mx-1 shadow" title="Editar" href="readings/' . $row->id . '/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>' . '<a class="btn btn-xs btn-danger mx-1 shadow" title="Excluir" href="readings/destroy/' . $row->id . '" onclick="return confirm(\'Confirma a exclusão desta leitura?\')"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
                    return $btn;
                })
                ->addColumn('value', function ($row) {
                    return number_format($row->reading, 3, ",", ".");
                })
                ->rawColumns(['action', 'value'])
                ->make(true);
        }

        return view('admin.readings.index');
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
        if (!Auth::user()->hasPermissionTo('Criar Leituras')) {
            abort(403, 'Acesso não autorizado');
        }

        if (!$request->file()) {
            return redirect()
                ->back()
                ->with('error', 'Nenhum arquivo selecionado!');
        }
        Excel::import(new ReadingsImport, $request->file('file')->store('temp'));
        return back()->with('success', 'Importação realizada!');
    }

    public function photo()
    {
        if (!Auth::user()->hasPermissionTo('Editar Leituras')) {
            abort(403, 'Acesso não autorizado');
        }
        toastr()->info('O nome da foto deve ser igual ao chassi do medidor', 'Dica!', ['timeOut' => 5000]);
        return view('admin.readings.photo');
    }

    public function photoImport(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Editar Leituras')) {
            abort(403, 'Acesso não autorizado');
        }

        $validator = Validator::make($request->only('photos'), ['photos.*' => 'image|max:10240']);

        if ($validator->fails() == true) {
            return redirect()->back()->withInput()->with('error', 'Todas as imagens devem ser do tipo jpg, jpeg ou png.');
        }

        $counterImg = 0;
        $counterReadings = 0;
        if ($request->allFiles()) {
            foreach ($request->allFiles()['photos'] as $image) {
                $originalName = (str_replace('.' . $image->extension(), '', $image->getClientOriginalName()));

                $imageName = Str::slug(mb_substr($originalName, 0, 100) . '-' . $request['month_ref']) . time() . '.' . $image->extension();

                $destinationPath = storage_path() . '/app/public/readings';
                $img = Image::make($image->path());
                $img->resize(500, 500, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath . '/' . $imageName);

                $counterImg++;

                $meter = Meter::where('register', $originalName)->first();
                if (!empty($meter->id)) {
                    $reading = Reading::where('month_ref', $request['month_ref'])->where('year_ref', $request['year_ref'])->where('meter_id', $meter->id)->first();

                    if (!empty($reading->id)) {
                        $imagePath = storage_path() . '/app/public/readings/' . $reading->cover;
                        $imagePathBase64 = storage_path() . '/app/public/readings/' . $reading->cover_base64;

                        if (File::isFile($imagePath)) {
                            unlink($imagePath);
                        }

                        if (File::isFile($imagePathBase64)) {
                            unlink($imagePathBase64);
                        }

                        $data['cover'] = $imageName;

                        if ($reading->update($data)) {
                            $counterReadings++;
                        }
                    }
                }
            }
        }

        return redirect()->back()->with('success', "Foram importadas {$counterImg} imagens com sucesso e atualizado o total de {$counterReadings} leituras");
    }

    public function batchDelete(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Excluir Leituras')) {
            abort(403, 'Acesso não autorizado');
        }

        if (!$request->ids) {
            return redirect()
                ->back()
                ->with('error', 'Selecione ao menos uma linha!');
        }

        $ids = explode(",", $request->ids);

        foreach ($ids as $id) {
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
            }
        }

        return redirect()
            ->route('admin.readings.index')
            ->with('success', 'Leituras excluídas!');
    }
}
