<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ApartmentRequest;
use App\Imports\ApartmentImport;
use App\Models\Apartment;
use App\Models\ApartmentReport;
use App\Models\Block;
use App\Models\Complex;
use App\Models\Meter;
use App\Models\Notification;
use App\Models\Reading;
use App\Models\Resident;
use App\Models\Views\Apartment as ViewApartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;

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
                $apartments = ViewApartment::where('complex_id', $complex->id)->get();
            }
        } else {
            $apartments = ViewApartment::query();
        }

        if ($request->ajax()) {
            return Datatables::of($apartments)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-xs btn-primary mx-1 shadow" title="Editar" href="apartments/' . $row->id . '/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>' . '<a class="btn btn-xs btn-danger mx-1 shadow" title="Excluir" href="apartments/destroy/' . $row->id . '" onclick="return confirm(\'Confirma a exclusão deste apartamento?\')"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $filter = $request['complex'];

        return view('admin.apartments.index', compact('filter'));
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
            $this->cascadeDelete($id);
            return redirect()
                ->back()
                ->with('success', 'Exclusão realizada!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir!');
        }
    }

    public function fileImport(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Apartamentos')) {
            abort(403, 'Acesso não autorizado');
        }

        if (!$request->file()) {
            return redirect()
                ->back()
                ->with('error', 'Nenhum arquivo selecionado!');
        }
        Excel::import(new ApartmentImport, $request->file('file')->store('temp'));
        return back()->with('success', 'Importação realizada!');;
    }

    public function batchDelete(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Excluir Apartamentos')) {
            abort(403, 'Acesso não autorizado');
        }

        if (!$request->ids) {
            return redirect()
                ->back()
                ->with('error', 'Selecione ao menos uma linha!');
        }

        $ids = explode(",", $request->ids);

        foreach ($ids as $id) {
            $apartment = Apartment::find($id);

            if (!$apartment) {
                abort(403, 'Acesso não autorizado');
            }
            $this->cascadeDelete($id);
            $apartment->delete();
        }

        return redirect()
            ->route('admin.apartments.index')
            ->with('success', 'Apartamentos excluídos!');
    }

    private function cascadeDelete($id): void
    {

        $meters = Meter::where('apartment_id', $id)->get();
        foreach ($meters as $meter) {
            Reading::where('meter_id', $meter->id)->delete();
            $meter->delete();
        }
        ApartmentReport::where('apartment_id', $id)->delete();
        Notification::where('apartment_id', $id)->delete();
        Resident::where('apartment_id', $id)->delete();
    }
}
