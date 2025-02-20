<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServicesController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:services-list|services-create|services-edit|services-delete', ['only' => ['index','show']]);
        $this->middleware('permission:services-create', ['only' => ['create','store']]);
        $this->middleware('permission:services-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:services-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $services = Service::all();
        $breadcrumbs = [
            ['link' => "admin/services", 'name' => "Services"], ['name' => "Browse"]
        ];
        return view('admin.content.services.index', ['breadcrumbs' => $breadcrumbs, 'services' => $services]);
    }

    public function create(Request $request)
    {

        $breadcrumbs = [
            ['link' => "admin/services", 'name' => "Services"], ['name' => "Create"]
        ];
        return view('admin.content.services.create', ['breadcrumbs' => $breadcrumbs]);
    }

    public function edit($id)
    {

        $breadcrumbs = [
            ['link' => "admin/services", 'name' => "Services"], ['name' => "Edit"]
        ];
        $service = Service::find($id);
        return view('admin.content.services.edit', ['breadcrumbs' => $breadcrumbs,  'service' => $service]);
    }

    public function translate(Request $request, $lang, $item)
    {
        if($request->has('ordering')){
            $item->ordering = $request->ordering;
        }
        $item->setTranslation('title', $lang, $request->title)
            ->setTranslation('description', $lang, $request->description)
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
                $service = new Service();
                $this->translate($request, $request->lang, $service);
                DB::commit();
            } else {
                return back()->with('error', 'You should fill the english section first');
            }
            return redirect('admin/services')->with('success', 'Service added successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }

    public function update(Request $request,$id)
    {
        try {
            DB::beginTransaction();
            $service = Service::find($id);
            $this->translate($request, $request->lang, $service);
            DB::commit();
            return redirect('admin/services')->with('success', 'Service updated successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $item = Service::findOrFail($id);
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
