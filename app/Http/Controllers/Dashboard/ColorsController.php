<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\CategoryEnum;
use App\Models\Color;
use Illuminate\Support\Facades\DB;

class ColorsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:colors-list|colors-create|colors-edit|colors-delete', ['only' => ['index','show']]);
        $this->middleware('permission:colors-create', ['only' => ['create','store']]);
        $this->middleware('permission:colors-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:colors-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $colors = Color::all();
        $breadcrumbs = [
            ['link' => "admin/colors", 'name' => "Colors"], ['name' => "Browse"]
        ];
        return view('admin.content.colors.index', ['breadcrumbs' => $breadcrumbs, 'colors' => $colors]);
    }

    public function create(Request $request)
    {

        $breadcrumbs = [
            ['link' => "admin/colors", 'name' => "Colors"], ['name' => "Create"]
        ];
        return view('admin.content.colors.create', ['breadcrumbs' => $breadcrumbs]);
    }

    public function edit($id)
    {

        $breadcrumbs = [
            ['link' => "admin/colors", 'name' => "Colors"], ['name' => "Edit"]
        ];
        $color = Color::find($id);
        return view('admin.content.colors.edit', ['breadcrumbs' => $breadcrumbs,  'color' => $color]);
    }

    public function translate(Request $request, $lang, $item)
    {
        $item->category_id = CategoryEnum::InterlockingTiles->value;
        $item->setTranslation('title', $lang, $request->title)
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
                $color = new Color();
                $this->translate($request, $request->lang, $color);
                DB::commit();
            } else {
                return back()->with('error', 'You should fill the english section first');
            }
            return redirect('admin/colors')->with('success', 'Color added successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }

    public function update(Request $request,$id)
    {
        try {
            DB::beginTransaction();
            $color = Color::find($id);
            $this->translate($request, $request->lang, $color);
            DB::commit();
            return redirect('admin/colors')->with('success', 'Color updated successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $item = Color::findOrFail($id);
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
