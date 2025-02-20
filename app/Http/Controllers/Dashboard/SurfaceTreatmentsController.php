<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SurfaceTreatment;
use Illuminate\Support\Facades\DB;

class SurfaceTreatmentsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:treatments-list|treatments-create|treatments-edit|treatments-delete', ['only' => ['index','show']]);
        $this->middleware('permission:treatments-create', ['only' => ['create','store']]);
        $this->middleware('permission:treatments-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:treatments-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $treatments = SurfaceTreatment::all();
        $breadcrumbs = [
            ['link' => "admin/treatments", 'name' => "Surface Treatments"], ['name' => "Browse"]
        ];
        return view('admin.content.treatments.index', ['breadcrumbs' => $breadcrumbs, 'treatments' => $treatments]);
    }

    public function create(Request $request)
    {
        $breadcrumbs = [
            ['link' => "admin/treatments", 'name' => "Surface Treatments"], ['name' => "Create"]
        ];
        return view('admin.content.treatments.create', ['breadcrumbs' => $breadcrumbs]);
    }

    public function edit($id)
    {
        $breadcrumbs = [
            ['link' => "admin/treatments", 'name' => "Surface Treatments"], ['name' => "Edit"]
        ];
        $treatment = SurfaceTreatment::find($id);
        return view('admin.content.treatments.edit', ['breadcrumbs' => $breadcrumbs,  'treatment' => $treatment]);
    }

    public function translate(Request $request, $lang, $item)
    {
        if($request->has('ordering')){
            $item->ordering = $request->ordering;
        }
        $item->setTranslation('title', $lang, $request->title)
            ->setTranslation('description', $lang, $request->description)
            ->setTranslation('features_desc', $lang, $request->features_desc)
            ->save();
        if ($request->has('image')) {
            $item->clearMediaCollection('images');
            $item->addMediaFromRequest('image')->toMediaCollection('images');
        }
        if ($request->has('mobile_image')) {
            $item->clearMediaCollection('mobile_images');
            $item->addMediaFromRequest('mobile_image')->toMediaCollection('mobile_images');
        }
        return $item;
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $lang = $request->lang;
            if ($lang === 'en') {
                $treatment = new SurfaceTreatment();
                $this->translate($request, $request->lang, $treatment);
                DB::commit();
            } else {
                return back()->with('error', 'You should fill the english section first');
            }
            return redirect('admin/treatments')->with('success', 'Surface Treatment added successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }

    public function update(Request $request,$id)
    {
        try {
            DB::beginTransaction();
            $treatment = SurfaceTreatment::find($id);
            $this->translate($request, $request->lang, $treatment);
            DB::commit();
            return redirect('admin/treatments')->with('success', 'Surface Treatment updated successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $item = SurfaceTreatment::findOrFail($id);
            $item->clearMediaCollection('images');
            $item->clearMediaCollection('mobile_image');
            $item->delete();
            DB::commit();
            return response()->json(['status' => '200','message'=>'Item deleted successfully']);
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json(['status' => '400','message'=> $exception->getMessage()]);
        }
    }
}
