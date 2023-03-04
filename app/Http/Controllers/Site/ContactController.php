<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Mail\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Meta;


class ContactController extends Controller
{
    public function index()
    {
        Meta::set('title', 'Acqua X do Brasil - Contato');
        Meta::set('description', 'Acqua X do Brasil - Entre em contato conosco.');
        Meta::set('robots', 'index,follow');
        Meta::set('image', asset('img/share.png'));
        Meta::set('canonical', env('APP_URL'));
        return view('site.contact.index');
    }

    public function sendEmail(Request $request)
    {
        $data = [
            "name" => $request->name,
            "email" => $request->email,
            "msg_subject" => $request->msg_subject,
            "phone_number" =>  $request->phone_number,
            "message" => $request->message
        ];

        $contact = new Contact($data);

        Mail::send($contact);

        return response()->json('success');
    }
}
