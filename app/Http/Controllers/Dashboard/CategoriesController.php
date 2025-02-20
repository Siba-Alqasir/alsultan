<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:categories-list|categories-create|categories-edit|categories-delete', ['only' => ['index','show']]);
        $this->middleware('permission:categories-create', ['only' => ['create','store']]);
        $this->middleware('permission:categories-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:categories-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $categories = Category::all();
        $breadcrumbs = [
            ['link' => "admin/categories", 'name' => "Categories"], ['name' => "Browse"]
        ];
        return view('admin.content.categories.index', ['breadcrumbs' => $breadcrumbs, 'categories' => $categories]);
    }

    public function create()
    {
        return redirect('admin/categories');
        $breadcrumbs = [
            ['link' => "admin/categories", 'name' => "Categories"], ['name' => "Create"]
        ];
        return view('admin.content.categories.create', ['breadcrumbs' => $breadcrumbs]);
    }

    public function edit($id)
    {
        $breadcrumbs = [
            ['link' => "admin/categories", 'name' => "Categories"], ['name' => "Edit"]
        ];
        $category = Category::find($id);
        return view('admin.content.categories.edit', ['breadcrumbs' => $breadcrumbs,  'category' => $category]);
    }

    public function translate(Request $request, $lang, $item)
    {
        $item->setTranslation('title', $lang, $request->title)
            ->setTranslation('description', $lang, $request->description)
            ->setTranslation('meta_title', $lang, $request->meta_title)
            ->setTranslation('meta_description', $lang, $request->meta_description)
            ->save();

        if ($request->has('image')) {
            $item->clearMediaCollection('images');
            $item->addMediaFromRequest('image')->toMediaCollection('images');
        }
        if ($request->has('mobile_image')) {
            $item->clearMediaCollection('mobile_images');
            $item->addMediaFromRequest('mobile_image')->toMediaCollection('mobile_images');
        }
        if ($request->has('cover')) {
            $item->clearMediaCollection('cover');
            $item->addMediaFromRequest('cover')->toMediaCollection('cover');
        }
        if ($request->has('catalogue')) {
            $item->clearMediaCollection('catalogue');
            $item->addMediaFromRequest('catalogue')->toMediaCollection('catalogue');
        }
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            if ($request->lang === 'en') {
                $category = new Category();
                $this->translate($request, $request->lang, $category);
                DB::commit();
            } else {
                return back()->with('error', 'You Should add the english section first');
            }
            return redirect('admin/categories')->with('success', 'Category added successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'catalogue' => 'sometimes|file|max:20480'
        ],[
            'catalogue.max' => 'The catalogue may not be greater than 20MB.',
            'catalogue.file' => 'The catalogue not valid'
        ]);
        try {
            DB::beginTransaction();
            $category = Category::find($id);
            $this->translate($request, $request->lang, $category);
            DB::commit();
            return redirect('admin/categories')->with('success', 'Category updated successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $item = Category::findOrFail($id);
            $item->clearMediaCollection('images');
            $item->clearMediaCollection('mobile_images');
            $item->delete();
            DB::commit();
            return response()->json(['status' => '200','message'=>'Item deleted successfully']);
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json(['status' => '400','message'=> $exception->getMessage()]);
        }
    }

}
