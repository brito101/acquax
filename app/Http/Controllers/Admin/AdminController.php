<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Shetabit\Visitor\Models\Visit;

class AdminController extends Controller
{
    public function index()
    {
        $administrators = User::role('Administrador')->get()->count();

        /** Statistcs */
        $statistics = $this->accessStatistcs();
        $onlineUsers = $statistics['onlineUsers'];
        $percent = $statistics['percent'];
        $access = $statistics['access'];
        $chart = $statistics['chart'];

        return view('admin.home.index', compact(
            'administrators',
            'onlineUsers',
            'percent',
            'access',
            'chart',
        ));
    }

    public function chart()
    {
        /** Statistcs */
        $statistics = $this->accessStatistcs();
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

    private function accessStatistcs()
    {
        $onlineUsers = User::online()->get()->count();

        $access = Visit::where('created_at', '>=', date("Y-m-d"))
            ->where('url', '!=', route('admin.home.chart'))
            ->get();
        $accessYesterday = Visit::where('created_at', '>=', Carbon::now()->subDays(1))
            ->where('created_at', '<', Carbon::now())
            ->where('url', '!=', route('admin.home.chart'))
            ->get();

        $percent = 0;
        if ($accessYesterday->count() > 0) {
            $percent = number_format((($access->count() - $accessYesterday->count()) / $access->count() * 100), 2, ",", ".");
        }

        /**Visitor Chart */
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

        return array(
            'onlineUsers' => $onlineUsers,
            'access' => $access->count(),
            'percent' => $percent,
            'chart' => $chart
        );
    }
}
