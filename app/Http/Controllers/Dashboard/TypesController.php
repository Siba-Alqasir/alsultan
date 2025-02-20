<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Type;
use Illuminate\Support\Facades\DB;

class TypesController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:types-list|types-create|types-edit|types-delete', ['only' => ['index','show']]);
        $this->middleware('permission:types-create', ['only' => ['create','store']]);
        $this->middleware('permission:types-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:types-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $types = Type::all();
        $breadcrumbs = [
            ['link' => "admin/types", 'name' => "Types"], ['name' => "Browse"]
        ];
        return view('admin.content.types.index', ['breadcrumbs' => $breadcrumbs, 'types' => $types]);
    }

    public function create(Request $request)
    {

        $breadcrumbs = [
            ['link' => "admin/types", 'name' => "Types"], ['name' => "Create"]
        ];
        return view('admin.content.types.create', ['breadcrumbs' => $breadcrumbs]);
    }

    public function edit($id)
    {

        $breadcrumbs = [
            ['link' => "admin/types", 'name' => "Types"], ['name' => "Edit"]
        ];
        $type = Type::find($id);
        return view('admin.content.types.edit', ['breadcrumbs' => $breadcrumbs,  'type' => $type]);
    }

    public function translate(Request $request, $lang, $item)
    {
        $item->setTranslation('title', $lang, $request->title)
            ->setTranslation('description', $lang, $request->description)
            ->save();
        if ($request->has('image')) {
            $item->clearMediaCollection('images');
            $item->addMediaFromRequest('image')->toMediaCollection('images');
        }
        return $item;
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $lang = $request->lang;
            if ($lang === 'en') {
                $type = new Type();
                $this->translate($request, $request->lang, $type);
                DB::commit();
            } else {
                return back()->with('error', 'You should fill the english section first');
            }
            return redirect('admin/types')->with('success', 'Type added successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }

    public function update(Request $request,$id)
    {
        try {
            DB::beginTransaction();
            $type = Type::find($id);
            $this->translate($request, $request->lang, $type);
            DB::commit();
            return redirect('admin/types')->with('success', 'Type updated successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $item = Type::findOrFail($id);
            $item->clearMediaCollection('images');
            $item->delete();
            DB::commit();
            return response()->json(['status' => '200','message'=>'Item deleted successfully']);
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json(['status' => '400','message'=> $exception->getMessage()]);
        }
    }
}
