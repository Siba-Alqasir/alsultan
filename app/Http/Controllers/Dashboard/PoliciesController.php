<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\QualityPolicy;
use Illuminate\Support\Facades\DB;

class PoliciesController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:policies-list|policies-create|policies-edit|policies-delete', ['only' => ['index','show']]);
        $this->middleware('permission:policies-create', ['only' => ['create','store']]);
        $this->middleware('permission:policies-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:policies-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $policies = QualityPolicy::all();

        $breadcrumbs = [
            ['link' => "/admin/policies", 'name' => "Policies"], ['name' => "Browse"]
        ];
        return view('admin.content.policies.index', ['breadcrumbs' => $breadcrumbs, 'policies' => $policies]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [
            ['link' => "admin/policies", 'name' => "Policies"], ['name' => "Create"]
        ];
        return view('admin.content.policies.create', ['breadcrumbs' => $breadcrumbs]);
    }

    public function translate(Request $request, $lang, $item)
    {
        
        $item->setTranslation('description', $lang, $request->description)
            ->save();

        if ($request->has('logo')) {
            $item->clearMediaCollection('logo');
            $item->addMediaFromRequest('logo')->toMediaCollection('logo');
        }
        
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
                $policy = new QualityPolicy();
                self::translate($request, $request->lang, $policy);
                DB::commit();
            } else {
                return back()->with('error', 'You Should add the english section first');
            }
            return redirect('admin/policies')->with('success', 'Policy added successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return $exception;
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Policy  $policy
     * @return \Illuminate\Http\Response
     */
    public function show(Policy $policy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Policy  $policy
     * @return \Illuminate\Http\Response
     */
    public function edit($policy)
    {
        $breadcrumbs = [
            ['link' => "/admin/policies", 'name' => "Policies"], ['name' => "Edit"]
        ];
        $policy = QualityPolicy::find($policy);
        return view('admin.content.policies.edit', ['breadcrumbs' => $breadcrumbs,'policy' => $policy]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Policy  $policy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$policy)
    {
        try {
            DB::beginTransaction();
            $policy = QualityPolicy::find($policy);
            self::translate($request, $request->lang, $policy);
            DB::commit();
            return redirect('admin/policies')->with('success', 'Policy updated successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Policy  $policy
     * @return \Illuminate\Http\Response
     */
    public function destroy($policy)
    {
        try {
            DB::beginTransaction();
            $policy = QualityPolicy::findOrFail($policy);
            $policy->clearMediaCollection('logo');
            $policy->delete();
            DB::commit();
           return response()->json(['status' => '200','message'=>'Item deleted successfully']);
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }
}
