<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->hasPermissionTo('Listar Usuários')) {
            abort(403, 'Acesso não autorizado');
        }

        if (Auth::user()->hasRole('Programador')) {
            $users = User::all();
        } elseif (Auth::user()->hasRole('Administrador')) {
            $users = User::role(['Administrador'])->get();
        } else {
            $users = null;
        }

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('Criar Usuários')) {
            abort(403, 'Acesso não autorizado');
        }
        if (Auth::user()->hasRole('Programador')) {
            $roles = Role::all();
        } elseif (Auth::user()->hasRole('Administrador')) {
            $roles = Role::where('name', '!=', 'Programador')->get();
        } else {
            $roles = [];
        }
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Usuários')) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();
        $data['password'] = bcrypt($request->password);

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $name = Str::slug(mb_substr($data['name'], 0, 100)) . time();
            $extenstion = $request->photo->extension();
            $nameFile = "{$name}.{$extenstion}";
            $data['photo'] = $nameFile;
            $upload = $request->photo->storeAs('users', $nameFile);

            if (!$upload) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Falha ao fazer o upload da imagem');
            }
        }

        $user = User::create($data);

        if ($user->save()) {
            if (!empty($request->role)) {
                $user->syncRoles($request->role);
            }
            return redirect()
                ->route('admin.users.index')
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
    public function edit($id = null)
    {

        if ($id && !Auth::user()->hasPermissionTo('Editar Usuários')) {
            abort(403, 'Acesso não autorizado');
        }

        if (is_null($id) && !Auth::user()->hasPermissionTo('Editar Usuário')) {
            abort(403, 'Acesso não autorizado');
        }

        if (is_null($id)) {
            $id = Auth::user()->id;
        }

        if (Auth::user()->hasRole('Programador')) {
            $roles = Role::all();
            $user = User::where('id', $id)->first();
        } elseif (Auth::user()->hasRole('Administrador')) {
            $roles = Role::where('name', '!=', 'Programador')->get();
            $user = User::where('id', $id)->first();
        } else {
            $roles = [];
            $user = User::where('id', $id)->first();
        }

        if (empty($user->id)) {
            abort(403, 'Acesso não autorizado');
        }
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        if (!Auth::user()->hasAnyPermission(['Editar Usuários', 'Editar Usuário'])) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();

        if (Auth::user()->hasPermissionTo('Editar Usuários')) {
            $user = User::where('id', $id)->first();
        }

        if (empty($user->id)) {
            abort(403, 'Acesso não autorizado');
        }

        if (!empty($data['password'])) {
            $data['password'] = bcrypt($request->password);
        } else {
            $data['password'] = $user->password;
        }

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $name = Str::slug(mb_substr($data['name'], 0, 10)) . time();
            $imagePath = storage_path() . '/app/public/users/' . $user->photo;

            if (File::isFile($imagePath)) {
                unlink($imagePath);
            }

            $extenstion = $request->photo->extension();
            $nameFile = "{$name}.{$extenstion}";

            $data['photo'] = $nameFile;

            $upload = $request->photo->storeAs('users', $nameFile);

            if (!$upload)
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', 'Falha ao fazer o upload da imagem');
        }

        if ($user->update($data)) {
            if (!empty($request->role)) {
                $user->syncRoles($request->role);
            }
            return redirect()
                ->route('admin.users.index')
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
        if (!Auth::user()->hasPermissionTo('Excluir Usuários')) {
            abort(403, 'Acesso não autorizado');
        }

        $user = User::where('id', $id)->first();

        if (empty($user->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $imagePath = storage_path() . '/app/public/users/' . $user->photo;
        if ($user->delete()) {
            if (File::isFile($imagePath)) {
                unlink($imagePath);
                $user->photo = null;
                $user->update();
            }

            return redirect()
                ->route('admin.users.index')
                ->with('success', 'Exclusão realizada!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir!');
        }
    }
}
