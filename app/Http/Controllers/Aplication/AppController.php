<?php

namespace App\Http\Controllers\Aplication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\Apartment;
use App\Models\DealershipReading;
use App\Models\Resident;
use App\Models\Settings\Genre;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->hasAnyRole('Morador', 'Síndico', 'Morador e Síndico')) {
            abort(403, 'Acesso não autorizado');
        }

        $residences = Resident::where('user_id', Auth::user()->id)->get();
        return view('application.home.index', compact('residences'));
    }

    public function residencesReadings()
    {
        if (!Auth::user()->hasAnyRole('Morador', 'Morador e Síndico')) {
            abort(403, 'Acesso não autorizado');
        }
        $residences = Resident::where('user_id', Auth::user()->id)->pluck('apartment_id');
        $apartments = Apartment::whereIn('id', $residences)->get();

        return view('application.apartments.index', compact('apartments'));
    }

    public function residencesReadingsItem($re, $ap)
    {
        if (!Auth::user()->hasAnyRole('Morador', 'Morador e Síndico')) {
            abort(403, 'Acesso não autorizado');
        }

        $apartment = Apartment::where('id', $ap)->first();
        if (empty($apartment->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $reading = DealershipReading::where('id', $re)
            ->where('complex_id', $apartment->block->complex['id'])->first();
        if (empty($reading->id)) {
            abort(403, 'Acesso não autorizado');
        }

        return view('application.apartments.report', compact('reading', 'apartment'));
    }

    public function residencesReadingsItemPdf($re, $ap)
    {
        if (!Auth::user()->hasAnyRole('Morador', 'Morador e Síndico')) {
            abort(403, 'Acesso não autorizado');
        }

        $apartment = Apartment::where('id', $ap)->first();
        if (empty($apartment->id)) {
            abort(403, 'Acesso não autorizado');
        }

        $reading = DealershipReading::where('id', $re)
            ->where('complex_id', $apartment->block->complex['id'])->first();
        if (empty($reading->id)) {
            abort(403, 'Acesso não autorizado');
        }

        return view('application.apartments.pdf', compact('reading', 'apartment'));
    }

    public function userEdit()
    {
        if (!Auth::user()->hasAnyRole('Morador', 'Síndico', 'Morador e Síndico')) {
            abort(403, 'Acesso não autorizado');
        }

        $user = User::where('id', Auth::user()->id)->first();
        $genres = Genre::all();
        return view('application.users.edit', compact('user', 'genres'));
    }

    public function userUpdate(UserRequest $request)
    {
        if (!Auth::user()->hasAnyRole('Morador', 'Síndico', 'Morador e Síndico')) {
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
        if ($user->update($data)) {
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
