<?php

namespace App\Http\Controllers\Aplication;

use App\Http\Controllers\Controller;
use App\Mail\Support;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SupportControler extends Controller
{
    public function index()
    {
        if (!Auth::user()->hasPermissionTo('Enviar Suporte')) {
            abort(403, 'Acesso não autorizado');
        }
        return view('application.support.index');
    }

    public function sendMail(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('Enviar Suporte')) {
            abort(403, 'Acesso não autorizado');
        }

        $data = [
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'type' => $request->type,
            'message' => $request->message
        ];

        Mail::send(new Support($data));

        return redirect()
            ->route('app.home')
            ->with('success', 'Sua mensagem foi enviada! Retornaremos seu contato em breve.');
    }
}
