<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\CategoryEnum;
use App\Models\Finish;
use Illuminate\Support\Facades\DB;

class FinishesController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:finishes-list|finishes-create|finishes-edit|finishes-delete', ['only' => ['index','show']]);
        $this->middleware('permission:finishes-create', ['only' => ['create','store']]);
        $this->middleware('permission:finishes-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:finishes-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $finishes = Finish::where('category_id', CategoryEnum::InterlockingTiles->value)->get();
        $breadcrumbs = [
            ['link' => "admin/finishes", 'name' => "Finishes"], ['name' => "Browse"]
        ];
        return view('admin.content.finishes.index', ['breadcrumbs' => $breadcrumbs, 'finishes' => $finishes]);
    }

    public function create(Request $request)
    {

        $breadcrumbs = [
            ['link' => "admin/finishes", 'name' => "Finishes"], ['name' => "Create"]
        ];
        return view('admin.content.finishes.create', ['breadcrumbs' => $breadcrumbs]);
    }

    public function edit($id)
    {

        $breadcrumbs = [
            ['link' => "admin/finishes", 'name' => "Finishes"], ['name' => "Edit"]
        ];
        $finish = Finish::find($id);
        return view('admin.content.finishes.edit', ['breadcrumbs' => $breadcrumbs,  'finish' => $finish]);
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
                $finish = new Finish();
                $this->translate($request, $request->lang, $finish);
                DB::commit();
            } else {
                return back()->with('error', 'You should fill the english section first');
            }
            return redirect('admin/finishes')->with('success', 'Finish added successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }

    public function update(Request $request,$id)
    {
        try {
            DB::beginTransaction();
            $finish = Finish::find($id);
            $this->translate($request, $request->lang, $finish);
            DB::commit();
            return redirect('admin/finishes')->with('success', 'Finish updated successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $item = Finishe::findOrFail($id);
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
