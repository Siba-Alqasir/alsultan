<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductBySizeAttribute;
use App\Models\ProductBySize;
use Illuminate\Support\Facades\DB;

class ProductsBySizeController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:products-list|products-create|products-edit|products-delete', ['only' => ['index','show']]);
        $this->middleware('permission:products-create', ['only' => ['create','store']]);
        $this->middleware('permission:products-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:products-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $products = ProductBySize::all();
        $breadcrumbs = [
            ['link' => "admin/products-by-size", 'name' => "Products By Size"], ['name' => "Browse"]
        ];
        return view('admin.content.products.by-size.index', ['breadcrumbs' => $breadcrumbs, 'products' => $products]);
    }

    public function create(Request $request)
    {
        $breadcrumbs = [
            ['link' => "admin/products-by-size", 'name' => "Products By Size"], ['name' => "Create"]
        ];
        return view('admin.content.products.by-size.create', ['breadcrumbs' => $breadcrumbs]);
    }

    public function edit($id)
    {
        $product = ProductBySize::find($id);
        $breadcrumbs = [
            ['link' => "admin/products-by-size", 'name' => "Products By Size"], ['name' => "Edit"]
        ];
       
        return view('admin.content.products.by-size.edit', ['breadcrumbs' => $breadcrumbs,  'product' => $product]);
    }

    public function translate(Request $request, $lang, $item)
    {
        $item->setTranslation('description', $lang, $request->description)
            ->save();

        if ($request->has('image')) {
            $item->clearMediaCollection('image');
            $item->addMediaFromRequest('image')->toMediaCollection('image');
        }

        if ($request->has('finishes')){
            ProductBySizeAttribute::where('product_by_size_id', $item->id)->where('attribute_type', 'finish')->delete();
            $finishes = $request->finishes;
            foreach($finishes as $finish){
                ProductBySizeAttribute::create([
                    'product_by_size_id' => $item->id,
                    'attribute_id' => $finish,
                    'attribute_type' => 'finish',
                ]);
            }
        }
        if ($request->has('colors')){
            ProductBySizeAttribute::where('product_by_size_id', $item->id)->where('attribute_type', 'color')->delete();
            $colors = $request->colors;
            foreach($colors as $color){
                ProductBySizeAttribute::create([
                    'product_by_size_id' => $item->id,
                    'attribute_id' => $color,
                    'attribute_type' => 'color',
                ]);
            }
        }
        
        return $item;
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $lang = $request->lang;
            if ($lang === 'en') {
                $product = new ProductBySize();
                $this->translate($request, $request->lang, $product);
                DB::commit();
            } else {
                return back()->with('error', 'You should fill the english section first');
            }
            return redirect('admin/products-by-size')->with('success', 'Product added successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }

    public function update(Request $request,$id)
    {
        try {
            DB::beginTransaction();
            $product = ProductBySize::find($id);
            $this->translate($request, $request->lang, $product);
            DB::commit();
            return redirect('admin/products-by-size')->with('success', 'Product updated successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $item = ProductBySize::findOrFail($id);
            $item->clearMediaCollection('image');
            $item->delete();
            DB::commit();
            return response()->json(['status' => '200','message'=>'Item deleted successfully']);
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json(['status' => '400','message'=> $exception->getMessage()]);
        }
    }
}
