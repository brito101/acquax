<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ComplexRequest;
use App\Imports\ComplexImport;
use App\Models\AdvertisingComplex;
use App\Models\Apartment;
use App\Models\ApartmentReport;
use App\Models\Block;
use App\Models\Complex;
use App\Models\DealershipReading;
use App\Models\Meter;
use App\Models\Notification;
use App\Models\Reading;
use App\Models\Resident;
use App\Models\Schedule;
use App\Models\Syndic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;
use Image;

class ComplexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Listar Condomínios')) {
            abort(403, 'Acesso não autorizado');
        }
        // $complexes = Complex::orderBy('created_at', 'desc')->paginate(6);
        $complexes = Complex::get();

        if ($request->ajax()) {
            return Datatables::of($complexes)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-xs btn-primary mx-1 shadow" title="Editar" href="complexes/' . $row->id . '/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>' . '<a class="btn btn-xs btn-danger mx-1 shadow" title="Excluir" href="complexes/destroy/' . $row->id . '" onclick="return confirm(\'Confirma a exclusão deste condomínio?\')"><i class="fa fa-lg fa-fw fa-trash"></i></a><a class="btn btn-xs btn-success mx-1 shadow" title="Blocos" href="blocks?complex=' . $row->id . '"><i class="fa fa-lg fa-fw fa-building"></i></a>' . ($row->total_blocks > 0 ? '<a class="btn btn-xs btn-info mx-1 shadow" title="Apartamentos" href="apartments?complex=' . $row->id . '"><i class="fa fa-lg fa-fw fa-home"></i></a>' : '') . '<a class="btn btn-xs btn-secondary mx-1 shadow" title="Síndicos" href="syndics?complex=' . $row->id . '"><i class="fa fa-lg fa-fw fa-user-friends"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        // return view('admin.complexes.index', \compact('complexes'));
        return view('admin.complexes.index');
    }

    public function search(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Listar Condomínios')) {
            abort(403, 'Acesso não autorizado');
        }

        $complexes = Complex::where('alias_name', 'like', "%{$request['alias_name']}%")->where('city', 'like', "%{$request['city']}%")->orderBy('created_at', 'desc')->paginate(6);

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

            $this->cascadeDelete($id);

            return redirect()
                ->route('admin.complexes.index')
                ->with('success', 'Exclusão realizada!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir!');
        }
    }

    public function fileImport(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Condomínios')) {
            abort(403, 'Acesso não autorizado');
        }

        if (!$request->file()) {
            return redirect()
                ->back()
                ->with('error', 'Nenhum arquivo selecionado!');
        }
        Excel::import(new ComplexImport, $request->file('file')->store('temp'));
        return back()->with('success', 'Importação realizada!');;
    }

    public function photo()
    {
        if (!Auth::user()->hasPermissionTo('Editar Condomínios')) {
            abort(403, 'Acesso não autorizado');
        }
        toastr()->info('O nome da foto deve ser igual ao nome fantasia do condomínio', 'Dica!', ['timeOut' => 5000]);
        return view('admin.complexes.photo');
    }

    public function photoImport(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Editar Condomínios')) {
            abort(403, 'Acesso não autorizado');
        }

        $validator = Validator::make($request->only('photos'), ['photos.*' => 'image|max:10240']);

        if ($validator->fails() == true) {
            return redirect()->back()->withInput()->with('error', 'Todas as imagens devem ser do tipo jpg, jpeg ou png.');
        }

        $counterImg = 0;
        $counterComplex = 0;

        if ($request->allFiles()) {
            foreach ($request->allFiles()['photos'] as $image) {
                $originalName = (str_replace('.' . $image->extension(), '', $image->getClientOriginalName()));

                $imageName = Str::slug(mb_substr($originalName, 0, 100) . '-' . $request['month_ref']) . time() . '.' . $image->extension();

                $destinationPath = storage_path() . '/app/public/complexes';
                $img = Image::make($image->path());
                $img->resize(500, 500, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath . '/' . $imageName);

                $counterImg++;

                $complex = Complex::where('alias_name', $originalName)->first();
                if (!empty($complex->id)) {

                    $imagePath = storage_path() . '/app/public/complexes/' . $complex->photo;

                    if (File::isFile($imagePath)) {
                        unlink($imagePath);
                    }

                    $data['photo'] = $imageName;

                    if ($complex->update($data)) {
                        $counterComplex++;
                    }
                }
            }
        }

        return redirect()->back()->with('success', "Foram importadas {$counterImg} imagens com sucesso e atualizado o total de {$counterComplex} condomínios");
    }

    public function batchDelete(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Excluir Condomínios')) {
            abort(403, 'Acesso não autorizado');
        }

        if (!$request->ids) {
            return redirect()
                ->back()
                ->with('error', 'Selecione ao menos uma linha!');
        }

        $ids = explode(",", $request->ids);

        foreach ($ids as $id) {
            $complex = Complex::find($id);

            if (!$complex) {
                abort(403, 'Acesso não autorizado');
            }
            $this->cascadeDelete($id);
            $complex->delete();
        }

        return redirect()
            ->route('admin.complexes.index')
            ->with('success', 'Condomínios excluídos!');
    }

    private function cascadeDelete($id): void
    {
        $blocks = Block::where('complex_id', $id)->get();
        foreach ($blocks as $block) {
            $apartments = Apartment::where('block_id', $block->id)->get();
            foreach ($apartments as $apartment) {
                $meters = Meter::where('apartment_id', $apartment->id)->get();
                foreach ($meters as $meter) {
                    Reading::where('meter_id', $meter->id)->delete();
                    $meter->delete();
                }
                ApartmentReport::where('apartment_id', $apartment->id)->delete();
                Notification::where('apartment_id', $apartment->id)->delete();
                Resident::where('apartment_id', $apartment->id)->delete();
                $apartment->delete();
            }
            $block->delete();
        }
        AdvertisingComplex::where('complex_id', $id)->delete();
        $dealershipReadings = DealershipReading::where('complex_id', $id)->get();
        foreach ($dealershipReadings as $dealershipReading) {
            Notification::where('dealership_reading_id', $dealershipReading->id)->delete();
            $dealershipReading->delete();
        }
        Schedule::where('complex_id', $id)->delete();
        Syndic::where('complex_id', $id)->delete();
    }
}
