<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ScheduleRequest;
use App\Models\Guest;
use App\Models\Schedule;
use App\Models\Views\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Listar Eventos na Agenda')) {
            abort(403, 'Acesso não autorizado');
        }

        if ($request->ajax()) {
            if (Auth::user()->hasRole('Programador|Administrador')) {
                $schedules = Schedule::whereDate('start', '>=', $request->start)
                    ->whereDate('end',   '<=', $request->end)
                    ->where('type', null)
                    ->get(['id', 'title', 'start', 'end']);
            } else {
                $guests = Guest::where('user_id', Auth::user()->id)->pluck('schedule_id');
                $schedules = Schedule::whereDate('start', '>=', $request->start)
                    ->whereDate('end',   '<=', $request->end)
                    ->where('user_id', Auth::user()->id)
                    ->where('type', null)
                    ->orWhereIn('id', $guests)
                    ->get(['id', 'title', 'start', 'end']);
            }

            return response()->json($schedules);
        }

        return view('admin.schedule.index');
    }

    public function day(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Eventos na Agenda')) {
            abort(403, 'Acesso não autorizado');
        }

        $date = date('Y-m-d H:i');
        if ($request->day) {
            $date = date('Y-m-d H:i', strtotime($request->day));
        }

        $guests = User::where('type', '!=', 'Usuário')->where('id', '!=', Auth::user()->id)->get();

        return view('admin.schedule.create', compact('date', 'guests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('Criar Eventos na Agenda')) {
            abort(403, 'Acesso não autorizado');
        }

        $guests = User::where('type', '!=', 'Usuário')->where('id', '!=', Auth::user()->id)->get();

        return view('admin.schedule.create', compact('guests'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ScheduleRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Eventos na Agenda')) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

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
                ->route('admin.schedule.index')
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
        if (!Auth::user()->hasPermissionTo('Listar Eventos na Agenda')) {
            abort(403, 'Acesso não autorizado');
        }

        $guest = Guest::where('user_id', Auth::user()->id)->where('schedule_id', $id)->first();
        if ($guest) {
            $guest->update([
                'visualized' => true
            ]);
        }

        $schedule = Schedule::where('id', $id)->where('type', null)->with('guests')->first();

        if (!$schedule) {
            abort(403, 'Acesso não autorizado');
        }

        return view('admin.schedule.show', compact('schedule'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Eventos na Agenda')) {
            abort(403, 'Acesso não autorizado');
        }

        $schedule = Schedule::where('id', $id)->where('type', null)->with('guests')->first();

        if (!$schedule) {
            abort(403, 'Acesso não autorizado');
        }

        if ($schedule->user_id != Auth::user()->id) {
            abort(403, 'Acesso não autorizado');
        }

        $guests = User::where('type', '!=', 'Usuário')->where('id', '!=', Auth::user()->id)->get();

        return view('admin.schedule.edit', compact('schedule', 'guests'));
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
        if (!Auth::user()->hasPermissionTo('Editar Eventos na Agenda')) {
            abort(403, 'Acesso não autorizado');
        }

        $schedule = Schedule::where('type', null)->where('id', $id)->first();

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
                ->route('admin.schedule.index')
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
        if (!Auth::user()->hasPermissionTo('Excluir Eventos na Agenda')) {
            abort(403, 'Acesso não autorizado');
        }

        $schedule = Schedule::where('type', null)->where('id', $id)->first();

        if (!$schedule) {
            abort(403, 'Acesso não autorizado');
        }
        $guests = Guest::where('schedule_id', $schedule->id);

        if ($schedule->delete()) {
            $guests->delete();
            return redirect()
                ->route('admin.schedule.index')
                ->with('success', 'Exclusão realizada!');
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erro ao excluir!');
        }
    }
}
