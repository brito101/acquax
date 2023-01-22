<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlockRequest;
use App\Imports\BlockImport;
use App\Models\Apartment;
use App\Models\ApartmentReport;
use App\Models\Block;
use App\Models\Complex;
use App\Models\Meter;
use App\Models\Notification;
use App\Models\Reading;
use App\Models\Resident;
use App\Models\Views\Block as ViewsBlock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;

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
            } else {
                $blocks = ViewsBlock::where('complex_id', $request['complex'])->get();
            }
        } else {
            $blocks = ViewsBlock::query();
        }

        if ($request->ajax()) {
            return Datatables::of($blocks)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-xs btn-primary mx-1 shadow" title="Editar" href="blocks/' . $row->id . '/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>' . '<a class="btn btn-xs btn-danger mx-1 shadow" title="Excluir" href="blocks/destroy/' . $row->id . '" onclick="return confirm(\'Confirma a exclusão deste bloco?\')"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $filter = $request['complex'];

        return view('admin.blocks.index', compact('filter'));
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
        if (!$request->file()) {
            return redirect()
                ->back()
                ->with('error', 'Nenhum arquivo selecionado!');
        }
        Excel::import(new BlockImport, $request->file('file')->store('temp'));
        return back()->with('success', 'Importação realizada!');;
    }

    public function batchDelete(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Excluir Blocos')) {
            abort(403, 'Acesso não autorizado');
        }

        if (!$request->ids) {
            return redirect()
                ->back()
                ->with('error', 'Selecione ao menos uma linha!');
        }

        $ids = explode(",", $request->ids);

        foreach ($ids as $id) {
            $block = Block::find($id);

            if (!$block) {
                abort(403, 'Acesso não autorizado');
            }
            $this->cascadeDelete($id);
            $block->delete();
        }

        return redirect()
            ->route('admin.complexes.index')
            ->with('success', 'Blocos excluídos!');
    }

    private function cascadeDelete($id): void
    {
        $apartments = Apartment::where('block_id', $id)->get();
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
    }
}
