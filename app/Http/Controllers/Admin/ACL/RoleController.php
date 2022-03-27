<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->hasPermissionTo('Listar Perfis')) {
            abort(403, 'Acesso não autorizado');
        }
        $roles = Role::all();
        return view('admin.acl.roles.index', [
            'roles' => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('Criar Perfis')) {
            abort(403, 'Acesso não autorizado');
        }
        return view('admin.acl.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Criar Perfis')) {
            abort(403, 'Acesso não autorizado');
        }
        $check = Role::where('name', $request->name)->get();
        if ($check->count() > 0) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Nome do perfil já está em uso!');
        }
        $data = $request->all();
        $role = Role::create($data);
        if ($role->save()) {
            return redirect()
                ->route('admin.role.index')
                ->with('success', 'Perfil cadastrado!');
        } else {
            return redirect()
                ->route('admin.role.index')
                ->withInput()
                ->with('error', 'Falha ao cadastrar perfil!');
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
        if (!Auth::user()->hasPermissionTo('Editar Perfis')) {
            abort(403, 'Acesso não autorizado');
        }
        $role = Role::where('id', $id)->first();
        if (empty($role->id)) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }
        return view('admin.acl.roles.edit', [
            'role' => $role
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!Auth::user()->hasPermissionTo('Editar Perfis')) {
            abort(403, 'Acesso não autorizado');
        }
        $check = Role::where('name', $request->name)->where('id', '!=', $id)->get();
        if ($check->count() > 0) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'O nome deste perfil já está em uso!');
        }
        $data = $request->all();
        $role = Role::where('id', $id)->first();
        if ($role->update($data)) {
            return redirect()
                ->route('admin.role.index')
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
        if (!Auth::user()->hasPermissionTo('Excluir Perfis')) {
            abort(403, 'Acesso não autorizado');
        }
        $role = Role::where('id', $id)->first();

        if ($role->delete()) {
            return redirect()
                ->route('admin.role.index')
                ->with('success', 'Exclusão realizada!');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Erro ao excluir!');
        }
    }

    public function permissions($role)
    {
        if (!Auth::user()->hasPermissionTo('Sincronizar Perfis')) {
            abort(403, 'Acesso não autorizado');
        }
        $role = Role::where('id', $role)->first();
        $permissions = Permission::all();

        foreach ($permissions as $permission) {

            if ($role->hasPermissionTo($permission->name)) {
                $permission->can = true;
            } else {
                $permission->can = false;
            }
        }
        return view('admin.acl.roles.permissions', [
            'role' => $role,
            'permissions' => $permissions
        ]);
    }


    public function permissionsSync(Request $request, $role)
    {
        if (!Auth::user()->hasPermissionTo('Sincronizar Perfis')) {
            abort(403, 'Acesso não autorizado');
        }
        $permissionsRequest = $request->except(['_token', '_method']);
        foreach ($permissionsRequest as $key => $value) {
            $permissions[] = Permission::where('id', $key)->first();
        }
        $role = Role::where('id', $role)->first();
        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        } else {
            $role->syncPermissions(null);
        }
        return redirect()
            ->route('admin.role.permissions', ['role' => $role->id])
            ->with('success', 'Permissão sincronizada');
    }
}
