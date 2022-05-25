<?php

namespace App\Http\Controllers\Aplication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\Settings\Genre;
use App\Models\Syndic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function edit()
    {
        if (!Auth::user()->hasRole('Usuário')) {
            abort(403, 'Acesso não autorizado');
        }

        if (!Auth::user()->hasPermissionTo('Editar Perfil na Aplicação')) {
            abort(403, 'Acesso não autorizado');
        }

        $user = User::where('id', Auth::user()->id)->first();
        $genres = Genre::all();
        return view('application.users.edit', compact('user', 'genres'));
    }

    public function update(UserRequest $request)
    {
        if (!Auth::user()->hasRole('Usuário')) {
            abort(403, 'Acesso não autorizado');
        }

        if (!Auth::user()->hasPermissionTo('Editar Perfil na Aplicação')) {
            abort(403, 'Acesso não autorizado');
        }

        $data = $request->all();

        $user = User::where('id', Auth::user()->id)->first();
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

        if (!empty($data['password'])) {
            $data['password'] = bcrypt($request->password);
        }

        $syndics = Syndic::where('user_id', Auth::user()->id)->get();
        $first_access = [];

        if ($user->update($data)) {
            if ($syndics->count() > 0) {
                foreach ($syndics as $item) {
                    if ($item->first_access == true) {
                        $item->first_access = false;
                        $item->save();
                    }
                }
            }
            return redirect()
                ->route('app.user.edit')
                ->with('success', 'Atualização realizada!');
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Erro ao atualizar!');
        }
    }
}
