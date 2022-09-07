<?php

namespace App\Http\Controllers\Aplication;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use App\Models\AdvertisingComplex;
use App\Models\Apartment;
use App\Models\Block;
use App\Models\Complex;
use App\Models\Notification;
use App\Models\Post;
use App\Models\Resident;
use App\Models\Syndic;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;


class AppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::user()->hasAnyRole('Usuário')) {
            abort(403, 'Acesso não autorizado');
        }

        $residences = Resident::where('user_id', Auth::user()->id)->get();
        $syndics = Syndic::where('user_id', Auth::user()->id)->get();
        if ($syndics->count() > 0) {
            if (!$syndics->pluck('first_access')->contains('Não')) {
                return redirect()
                    ->route('app.user.edit')
                    ->with('warning', 'Por favor, atualize seus dados pessoais.');
            }
            $complexes = Complex::whereIn('id', $syndics->pluck('complex_id'))->get();
        } else {
            $complexes = null;
        }

        $blocks = Apartment::whereIn('id', $residences->pluck('apartment_id'))->pluck('block_id');
        $complexList = Block::whereIn('id', $blocks)->pluck('complex_id');
        $advertisingComplex = AdvertisingComplex::whereIn('complex_id', $complexList)->pluck('advertisement_id');

        $advertisement = Advertisement::where('status', 'Ativo')->whereIn('id', $advertisingComplex)->inRandomOrder()->first();
        if ($advertisement) {
            $advertisement->views += 1;
            $advertisement->update();
        }

        $notifications = Notification::whereIn('apartment_id', $residences->pluck('apartment_id'))->where('read', false)->get();

        $posts = Post::where('status', 'Publicado')
            ->orderBy('created_at', 'desc')->limit(3)->get();

        return view('application.home.index', compact('residences', 'complexes', 'advertisement', 'notifications', 'posts'));
    }

    public function notificationRead(Notification $notification)
    {
        if ($notification) {
            $notification->read = !$notification->read;
            $notification->update();
            return \response()->json($notification->read);
        }
    }
}
