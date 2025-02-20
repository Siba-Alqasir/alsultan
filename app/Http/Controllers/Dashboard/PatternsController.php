<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\CategoryEnum;
use App\Models\Pattern;
use Illuminate\Support\Facades\DB;

class PatternsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:patterns-list|patterns-create|patterns-edit|patterns-delete', ['only' => ['index','show']]);
        $this->middleware('permission:patterns-create', ['only' => ['create','store']]);
        $this->middleware('permission:patterns-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:patterns-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $patterns = Pattern::all();
        $breadcrumbs = [
            ['link' => "admin/patterns", 'name' => "Patterns"], ['name' => "Browse"]
        ];
        return view('admin.content.patterns.index', ['breadcrumbs' => $breadcrumbs, 'patterns' => $patterns]);
    }

    public function create(Request $request)
    {

        $breadcrumbs = [
            ['link' => "admin/patterns", 'name' => "Patterns"], ['name' => "Create"]
        ];
        return view('admin.content.patterns.create', ['breadcrumbs' => $breadcrumbs]);
    }

    public function edit($id)
    {

        $breadcrumbs = [
            ['link' => "admin/patterns", 'name' => "Patterns"], ['name' => "Edit"]
        ];
        $pattern = Pattern::find($id);
        return view('admin.content.patterns.edit', ['breadcrumbs' => $breadcrumbs,  'pattern' => $pattern]);
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
                $pattern = new Pattern();
                $this->translate($request, $request->lang, $pattern);
                DB::commit();
            } else {
                return back()->with('error', 'You should fill the english section first');
            }
            return redirect('admin/patterns')->with('success', 'Pattern added successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }

    public function update(Request $request,$id)
    {
        try {
            DB::beginTransaction();
            $pattern = Pattern::find($id);
            $this->translate($request, $request->lang, $pattern);
            DB::commit();
            return redirect('admin/patterns')->with('success', 'Pattern updated successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $item = Pattern::findOrFail($id);
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
