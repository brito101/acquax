<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ScheduleRequest;
use App\Models\Complex;
use App\Models\Guest;
use App\Models\Schedule;
use App\Models\Views\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;

class ReadingScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Listar Agendamentos de Leitura')) {
            abort(403, 'Acesso não autorizado');
        }

        if ($request->ajax()) {
            if (Auth::user()->hasRole('Programador|Administrador')) {
                $schedules = Schedule::where('type', 'leitura')->get();
                return Datatables::of($schedules)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = '<a class="btn btn-xs btn-success mx-1 shadow" title="Visualizar" href="reading-schedule/' . $row->id . '"><i class="fa fa-lg fa-fw fa-eye"></i></a>' . '<a class="btn btn-xs btn-primary mx-1 shadow" title="Editar" href="reading-schedule/' . $row->id . '/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>' . '<a class="btn btn-xs btn-danger mx-1 shadow" title="Excluir" href="reading-schedule/destroy/' . $row->id . '" onclick="return confirm(\'Confirma a exclusão deste agendamento?\')"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            } else {
                $schedules = Schedule::where('type', 'leitura')
                    ->where(function ($query) {
                        $guests = Guest::where('user_id', Auth::user()->id)->pluck('schedule_id');
                        $query->where('user_id', Auth::user()->id)
                            ->orWhereIn('id', $guests);
                    })->get();

                return Datatables::of($schedules)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btnCheck = '';
                        $guest = Guest::where('schedule_id', $row->id)->where('user_id', Auth::user()->id)->first();
                        if ($guest->executed == true) {
                            $btnCheck = '<a class="btn btn-xs btn-light mx-1 shadow" title="Marcar como não  executado" href="reading-schedule/executed/' . $row->id . '"><i class="fas fa-lg fa-thumbs-down text-danger"></i></a>';
                        } else {
                            $btnCheck = '<a class="btn btn-xs btn-light mx-1 shadow" title="Marcar como executado" href="reading-schedule/executed/' . $row->id . '"><i class="fas fa-lg fa-thumbs-up text-success"></i></a>';
                        }
                        if ($row->user_id == Auth::user()->id) {
                            $btn = '<a class="btn btn-xs btn-success mx-1 shadow" title="Visualizar" href="reading-schedule/' . $row->id . '"><i class="fa fa-lg fa-fw fa-eye"></i></a>' . $btnCheck . '<a class="btn btn-xs btn-primary mx-1 shadow" title="Editar" href="reading-schedule/' . $row->id . '/edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>' . '<a class="btn btn-xs btn-danger mx-1 shadow" title="Excluir" href="reading-schedule/destroy/' . $row->id . '" onclick="return confirm(\'Confirma a exclusão deste agendamento?\')"><i class="fa fa-lg fa-fw fa-trash"></i></a>';
                            return $btn;
                        } else {
                            $btn = '<a class="btn btn-xs btn-success mx-1 shadow" title="Visualizar" href="reading-schedule/' . $row->id . '"><i class="fa fa-lg fa-fw fa-eye"></i></a>' . $btnCheck;
                            return $btn;
                        }
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return response()->json($schedules);
        }

        return view('admin.reading-schedule.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('Criar Agendamentos de Leitura')) {
            abort(403, 'Acesso não autorizado');
        }

        $guests = User::where('type', 'Leiturista')->get();
        $complexes = Complex::all(['alias_name', 'id']);

        return view('admin.reading-schedule.create', compact('guests', 'complexes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ScheduleRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Agendamentos de Leitura')) {
            abort(403, 'Acesso não autorizado');
        }

        $complex = Complex::find($request->complex_id);

        $data = $request->all();
        $data['title'] = 'Agendamento de leitura no Condomínio ' . $complex->alias_name;
        $data['user_id'] = Auth::user()->id;
        $data['type'] = 'leitura';
        $data['color'] = 'dark';

        $schedule = Schedule::create($data);

        if ($schedule->save()) {
            if ($request->guests) {
                foreach ($request->guests as $guest) {
                    $user = User::find($guest);
                    if ($user) {
                        Guest::create([
                            'schedule_id' => $schedule->id,
                            'user_id' => $user->id,
                        ]);
                    }
                }
            }
            return redirect()
                ->route('admin.reading-schedule.index')
                ->with('success', 'Cadastro realizado!');
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erro ao cadastrar!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Auth::user()->hasPermissionTo('Listar Agendamentos de Leitura')) {
            abort(403, 'Acesso não autorizado');
        }

        $guest = Guest::where('user_id', Auth::user()->id)->where('schedule_id', $id)->first();
        if ($guest) {
            $guest->update([
                'visualized' => true
            ]);
        }

        $schedule = Schedule::where('id', $id)->where('type', 'leitura')->with('guests')->first();

        if (!$schedule) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.reading-schedule.show', compact('schedule'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Agendamentos de Leitura')) {
            abort(403, 'Acesso não autorizado');
        }

        $schedule = Schedule::where('id', $id)->where('type', 'leitura')->with('guests')->first();

        if (!$schedule) {
            abort(403, 'Acesso não autorizado');
        }

        if ($schedule->user_id != Auth::user()->id) {
            abort(403, 'Acesso não autorizado');
        }

        $guests = User::where('type', '=', 'Leiturista')->get();
        $complexes = Complex::all(['alias_name', 'id']);

        return view('admin.reading-schedule.edit', compact('schedule', 'guests', 'complexes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ScheduleRequest $request, $id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Agendamentos de Leitura')) {
            abort(403, 'Acesso não autorizado');
        }

        $schedule = Schedule::where('type', 'leitura')->where('id', $id)->first();

        if (!$schedule) {
            abort(403, 'Acesso não autorizado');
        }

        if ($schedule->user_id != Auth::user()->id) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();

        if ($schedule->update($data)) {
            if ($request->guests) {
                $old_guest = Guest::where('schedule_id', $schedule->id)->whereNotIn('user_id', $request->guests)->delete();
                foreach ($request->guests as $guest) {
                    $user = User::find($guest);
                    if ($user) {
                        $guest = Guest::where('schedule_id', $schedule->id)->where('user_id', $user->id)->first();
                        if (!$guest) {
                            Guest::create([
                                'schedule_id' => $schedule->id,
                                'user_id' => $user->id,
                            ]);
                        }
                    }
                }
            } else {
                $guest = Guest::where('schedule_id', $schedule->id)->delete();
            }

            return redirect()
                ->route('admin.reading-schedule.index')
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
        if (!Auth::user()->hasPermissionTo('Excluir Agendamentos de Leitura')) {
            abort(403, 'Acesso não autorizado');
        }

        $schedule = Schedule::where('type', 'leitura')->where('id', $id)->first();

        if (!$schedule) {
            abort(403, 'Acesso não autorizado');
        }
        $guests = Guest::where('schedule_id', $schedule->id);

        if ($schedule->delete()) {
            $guests->delete();
            return redirect()
                ->route('admin.reading-schedule.index')
                ->with('success', 'Exclusão realizada!');
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erro ao excluir!');
        }
    }

    public function executed($id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Agendamentos de Leitura')) {
            abort(403, 'Acesso não autorizado');
        }

        $schedule = Schedule::where('type', 'leitura')->where('id', $id)->first();

        if (!$schedule) {
            abort(403, 'Acesso não autorizado');
        }

        $guest = Guest::where('schedule_id', $schedule->id)->where('user_id', Auth::user()->id)->first();

        if (!$guest) {
            abort(403, 'Acesso não autorizado');
        }

        $data['executed'] = !$guest->executed;

        if ($guest->update($data)) {
            return redirect()
                ->route('admin.reading-schedule.index')
                ->with('success', 'Edição realizada!');
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erro ao excluir!');
        }
    }

    public function batchDelete(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Excluir Agendamentos de Leitura')) {
            abort(403, 'Acesso não autorizado');
        }

        if (!$request->ids) {
            return redirect()
                ->back()
                ->with('error', 'Selecione ao menos uma linha!');
        }

        $ids = explode(",", $request->ids);

        foreach ($ids as $id) {
            $schedule = Schedule::where('type', 'leitura')->where('id', $id)->first();

            if (!$schedule) {
                abort(403, 'Acesso não autorizado');
            }
            $guests = Guest::where('schedule_id', $schedule->id)->delete();
            $schedule->delete();
        }

        return redirect()
            ->route('admin.reading-schedule.index')
            ->with('success', 'Agendamentos de Leituras excluídos!');
    }
}
