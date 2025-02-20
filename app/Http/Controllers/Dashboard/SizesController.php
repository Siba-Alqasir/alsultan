<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\CategoryEnum;
use App\Models\Size;
use Illuminate\Support\Facades\DB;

class SizesController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:sizes-list|sizes-create|sizes-edit|sizes-delete', ['only' => ['index','show']]);
        $this->middleware('permission:sizes-create', ['only' => ['create','store']]);
        $this->middleware('permission:sizes-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:sizes-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $sizes = Size::all();
        $breadcrumbs = [
            ['link' => "admin/sizes", 'name' => "Sizes"], ['name' => "Browse"]
        ];
        return view('admin.content.sizes.index', ['breadcrumbs' => $breadcrumbs, 'sizes' => $sizes]);
    }

    public function create(Request $request)
    {
        $breadcrumbs = [
            ['link' => "admin/sizes", 'name' => "Sizes"], ['name' => "Create"]
        ];
        return view('admin.content.sizes.create', ['breadcrumbs' => $breadcrumbs]);
    }

    public function edit($id)
    {
        $breadcrumbs = [
            ['link' => "admin/sizes", 'name' => "Sizes"], ['name' => "Edit"]
        ];
        $size = Size::find($id);
        return view('admin.content.sizes.edit', ['breadcrumbs' => $breadcrumbs,  'size' => $size]);
    }

    public function translate(Request $request, $lang, $item)
    {
        $item->category_id = CategoryEnum::InterlockingTiles->value;
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
                $size = new Size();
                $this->translate($request, $request->lang, $size);
                DB::commit();
            } else {
                return back()->with('error', 'You should fill the english section first');
            }
            return redirect('admin/sizes')->with('success', 'Size added successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }

    public function update(Request $request,$id)
    {
        try {
            DB::beginTransaction();
            $size = Size::find($id);
            $this->translate($request, $request->lang, $size);
            DB::commit();
            return redirect('admin/sizes')->with('success', 'Size updated successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $item = Size::findOrFail($id);
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
