<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Statistic;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:statistics-list|statistics-create|statistics-edit|statistics-delete', ['only' => ['index','show']]);
        $this->middleware('permission:statistics-create', ['only' => ['create','store']]);
        $this->middleware('permission:statistics-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:statistics-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statistics = Statistic::all();

        $breadcrumbs = [
            ['link' => "/admin/statistics", 'name' => "Statistics"], ['name' => "Browse"]
        ];
        return view('admin.content.statistics.index', ['breadcrumbs' => $breadcrumbs, 'statistics' => $statistics]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [
            ['link' => "admin/statistics", 'name' => "Statistics"], ['name' => "Create"]
        ];
        return view('admin.content.statistics.create', ['breadcrumbs' => $breadcrumbs]);
    }

    public function translate(Request $request, $lang, $item)
    {
        if($lang == 'en')
            $item->value = $request->value;
        $item->setTranslation('title', $lang, $request->title)
            ->setTranslation('metrics', $lang, $request->metrics)
            ->save();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            if ($request->lang == 'en') {
                $statistic = new Statistic();
                self::translate($request, $request->lang, $statistic);
                DB::commit();
            } else {
                return back()->with('error', 'You Should add the english section first');
            }
            return redirect('admin/statistics')->with('success', 'Statistic added successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return $exception;
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Statistic  $statistic
     * @return \Illuminate\Http\Response
     */
    public function show(Statistic $statistic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Statistic  $statistic
     * @return \Illuminate\Http\Response
     */
    public function edit($statistic)
    {
        $breadcrumbs = [
            ['link' => "/admin/statistics", 'name' => "Statistics"], ['name' => "Edit"]
        ];
        $statistic = Statistic::find($statistic);
        return view('admin.content.statistics.edit', ['breadcrumbs' => $breadcrumbs,'statistic' => $statistic]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Statistic  $statistic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $statistic)
    {
        try {
            DB::beginTransaction();
            $statistic = Statistic::find($statistic);
            self::translate($request, $request->lang, $statistic);
            DB::commit();
            return redirect('admin/statistics')->with('success', 'Statistic updated successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Statistic  $statistic
     * @return \Illuminate\Http\Response
     */
    public function destroy($statistic)
    {
        try {
            DB::beginTransaction();
            $statistic = Statistic::findOrFail($statistic);
            $statistic->delete();
            DB::commit();
           return response()->json(['status' => '200','message'=>'Item deleted successfully']);
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }
}
