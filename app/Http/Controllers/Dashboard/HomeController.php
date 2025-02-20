<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    public function home()
    {
        $breadcrumbs = [
            ['link' => "home", 'name' => "Home Page"]
        ];
        $today = Carbon::now();
        $oneMonthAgo = Carbon::today()->subMonth();
        $inquires =  Inquiry::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->whereBetween('created_at', [$oneMonthAgo, $today->endOfDay()])->groupBy(DB::raw('DATE(created_at)'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date', 'asc')
            ->get();
        return view('admin.content.dashboard.index',compact('breadcrumbs','inquires'));
    }
}
