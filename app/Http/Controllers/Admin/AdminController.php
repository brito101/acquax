<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Block;
use App\Models\Complex;
use App\Models\Guest;
use App\Models\Meter;
use App\Models\Reading;
use App\Models\Resident;
use App\Models\Schedule;
use App\Models\Syndic;
use App\Models\User;
use App\Models\Views\Apartment as ViewsApartment;
use App\Models\Views\Resident as ViewsResident;
use App\Models\Views\User as ViewsUser;
use App\Models\Views\Visit;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function index()
    {
        if (Auth::user()->hasRole('Usuário')) {
            return redirect()->route('app.home');
        }

        $administrators = ViewsUser::where('type', 'Administrador')->count();
        $complexes = Complex::all('id')->count();
        $blocks = Block::all('id')->count();
        $apartments = ViewsApartment::all('id')->count();
        $meters = Meter::all('id')->count();
        $residents = ViewsResident::all('id')->count();
        $syndics = Syndic::all('id')->count();
        $readings = Reading::all('id')->count();

        /** Schedule */
        if (Auth::user()->hasRole('Programador|Administrador')) {
            $schedules = Schedule::whereDate('start', '<=', date('Y-m-d'))
                ->whereDate('end', '>=', date('Y-m-d'))
                ->get();
        } else {
            $guests = Guest::where('user_id', Auth::user()->id)->pluck('schedule_id');
            $schedules = Schedule::whereDate('start', '<=', date('Y-m-d'))
                ->whereDate('end', '>=', date('Y-m-d'))
                ->where('user_id', Auth::user()->id)
                ->orWhereIn('id', $guests)
                ->get();
        }

        /** Statistics */
        $statistics = $this->accessStatistics();
        $onlineUsers = $statistics['onlineUsers'];
        $percent = $statistics['percent'];
        $access = $statistics['access'];
        $chart = $statistics['chart'];
        $topPages = $statistics['topPages'];

        return view('admin.home.index', compact(
            'administrators',
            'complexes',
            'blocks',
            'apartments',
            'meters',
            'residents',
            'syndics',
            'readings',
            'onlineUsers',
            'percent',
            'access',
            'chart',
            'topPages',
            'schedules'
        ));
    }

    public function chart()
    {
        /** Statistics */
        $statistics = $this->accessStatistics();
        $onlineUsers = $statistics['onlineUsers'];
        $percent = $statistics['percent'];
        $access = $statistics['access'];
        $chart = $statistics['chart'];

        return response()->json([
            'onlineUsers' => $onlineUsers,
            'access' => $access,
            'percent' => $percent,
            'chart' => $chart
        ]);
    }

    private function accessStatistics()
    {
        $onlineUsers = User::online()->count();

        $access = Visit::where('created_at', '>=', date("Y-m-d"))
            ->where('url', '!=', route('admin.home.chart'))
            ->get();
        $accessYesterday = Visit::where('created_at', '>=', date("Y-m-d", strtotime('-1 day')))
            ->where('created_at', '<', date("Y-m-d"))
            ->where('url', '!=', route('admin.home.chart'))
            ->count();

        $totalDaily = $access->count();

        $percent = 0;
        if ($accessYesterday > 0) {
            $percent = number_format((($totalDaily - $accessYesterday) / $totalDaily * 100), 2, ",", ".");
        }

        /** Visitor Chart */
        $data = $access->groupBy(function ($reg) {
            return date('H', strtotime($reg->created_at));
        });

        $dataList = [];
        foreach ($data as $key => $value) {
            $dataList[$key . 'H'] = count($value);
        }

        $chart = new \stdClass();
        $chart->labels = (array_keys($dataList));
        $chart->dataset = (array_values($dataList));

        /** Top Pages */
        $pages = Visit::where('url', 'like', "%app%")
            ->where('url', 'not like', "%columns%")
            ->where('method', 'GET')
            ->get();
        $topPages = $pages->groupBy(function ($reg) {
            $array = explode("/", $reg->url);
            $name = "app";
            $foundIndex = array_search($name, $array);
            $page = array_slice($array,  $foundIndex + 1, 1);
            return $page;
        });

        $pageList = [];
        foreach ($topPages as $key => $value) {
            $pageList[ucfirst($key)] = count($value);
        }

        $pages = new \stdClass();
        $pages->labels = (array_keys($pageList));
        $pages->dataset = (array_values($pageList));

        return array(
            'onlineUsers' => $onlineUsers,
            'access' => $totalDaily,
            'percent' => $percent,
            'chart' => $chart,
            'topPages' => $pages,
        );
    }
}
