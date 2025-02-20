<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SurfaceTreatment;
use App\Models\TreatmentFeature;
use Illuminate\Support\Facades\DB;

class TreatmentFeaturesController extends Controller
{
    public function index(Request $request)
    {
        if($request->id){
            $features = TreatmentFeature::where('treatment_id', $request->id)->get();
            $breadcrumbs = [
                ['link' => "admin/treatments", 'name' => "Surface Treatments"], ['name' => "Browse"]
            ];
            return view('admin.content.treatments.features.index', ['breadcrumbs' => $breadcrumbs, 'features' => $features, 'treatment_id' => $request->id]);
        }
    }

    public function create(Request $request)
    {
        if($request->id){
            $breadcrumbs = [
                ['link' => "admin/treatment-features?id=".$request->id, 'name' => "Treatment Features"], ['name' => "Create"]
            ];
            return view('admin.content.treatments.features.create', ['breadcrumbs' => $breadcrumbs, 'treatment_id' => $request->id]);
        }
    }

    public function edit(Request $request, $id)
    {
        $feature = TreatmentFeature::find($id);
        $breadcrumbs = [
            ['link' => "admin/treatment-features?id=".$feature->treatment_id, 'name' => "Treatment Features"], ['name' => "Edit"]
        ];
        return view('admin.content.treatments.features.edit', ['breadcrumbs' => $breadcrumbs,  'feature' => $feature, 'treatment_id' => $request->treatment_id]);
    }

    public function translate(Request $request, $lang, $item)
    {
        $item->treatment_id = $request->treatment_id;
        $item->setTranslation('title', $lang, $request->title)
            ->save();
        if ($request->has('logo')) {
            $item->clearMediaCollection('logo');
            $item->addMediaFromRequest('logo')->toMediaCollection('logo');
        }
        return $item;
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $lang = $request->lang;
            if ($lang === 'en') {
                $feature = new TreatmentFeature();
                $this->translate($request, $request->lang, $feature);
                DB::commit();
            } else {
                return back()->with('error', 'You should fill the english section first');
            }
            return redirect('admin/treatment-features?id='.$request->treatment_id)->with('success', 'Feature added successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }

    public function update(Request $request,$id)
    {
        try {
            DB::beginTransaction();
            $feature = TreatmentFeature::find($id);
            $this->translate($request, $request->lang, $feature);
            DB::commit();
            return redirect('admin/treatment-features?id='.$request->treatment_id)->with('success', 'Feature updated successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $item = TreatmentFeature::findOrFail($id);
            $item->clearMediaCollection('logo');
            $item->delete();
            DB::commit();
            return response()->json(['status' => '200','message'=>'Item deleted successfully']);
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json(['status' => '400','message'=> $exception->getMessage()]);
        }
    }
}
