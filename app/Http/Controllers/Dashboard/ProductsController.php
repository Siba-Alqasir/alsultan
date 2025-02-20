<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\CategoryEnum;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductsController extends Controller
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
        if($request->category){
            $category = Category::find($request->category);
            $products = Product::where('category_id', $request->category)->get();
            $breadcrumbs = [
                ['link' => "admin/products", 'name' => $category->title." Products"], ['name' => "Browse"]
            ];
            return view('admin.content.products.index', ['breadcrumbs' => $breadcrumbs, 'products' => $products, 'category' => $category]);
        }else
        return back();
    }

    public function create(Request $request)
    {
        if($request->category){
            $category = Category::find($request->category);
            $breadcrumbs = [
                ['link' => "admin/products?category=".$request->category, 'name' => $category->title." Products"], ['name' => "Create"]
            ];
            return view('admin.content.products.create', ['breadcrumbs' => $breadcrumbs, 'category' => $category]);
        }else
        return back();
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $category = Category::find($product->category_id);
        $breadcrumbs = [
            ['link' => "admin/products?category=".$product->category_id, 'name' => $category->title." Products"], ['name' => "Edit"]
        ];
       
        return view('admin.content.products.edit', ['breadcrumbs' => $breadcrumbs,  'product' => $product]);
    }

    public function translate(Request $request, $lang, $item)
    {
        $item->category_id = $request->category_id;
        if($request->category_id == CategoryEnum::InterlockingTiles->value){
            $item->setTranslation('title', $lang, $request->title)
                ->setTranslation('slug', $lang, $request->slug)
                ->setTranslation('description', $lang, $request->description)
                ->setTranslation('meta_title', $lang, $request->meta_title)
                ->setTranslation('meta_description', $lang, $request->meta_description)
                ->save();
        }
        else if($request->category_id == CategoryEnum::Kerbstone->value){
            $item->size = $request->size;
            $item->weight = $request->weight;
            $item->save();
        }
        else if($request->category_id == CategoryEnum::CableCover->value){
            $item->size = $request->size;
            $item->serial_number = $request->serial_number;
            $item->setTranslation('description', $lang, $request->description)
                ->save();
        }
        else{
            $item->setTranslation('description', $lang, $request->description)
            ->save();
        }
        if ($request->has('image')) {
            $item->clearMediaCollection('image');
            $item->addMediaFromRequest('image')->toMediaCollection('image');
        }
        if ($request->has('data_sheet')) {
            $item->clearMediaCollection('data_sheet');
            $item->addMediaFromRequest('data_sheet')->toMediaCollection('data_sheet');
        }
        if ($request->has('catalogue')) {
            $item->clearMediaCollection('catalogue');
            $item->addMediaFromRequest('catalogue')->toMediaCollection('catalogue');
        }
        if ($request->has('guide')) {
            $item->clearMediaCollection('guide');
            $item->addMediaFromRequest('guide')->toMediaCollection('guide');
        }
        if ($request->has('gallery')) {
            $images = $request->file('gallery');
            foreach ($images as $index => $image) {
                if ($image) {
                    $item->addMedia($image)->toMediaCollection('gallery');
                }
            }
        }
        if ($request->has('finish')){
            ProductAttribute::where('product_id', $item->id)->where('attribute_type', 'finish')->delete();
            ProductAttribute::create([
                'product_id' => $item->id,
                'attribute_id' => $request->finish,
                'attribute_type' => 'finish',
            ]);
        }
        if ($request->has('finishes')){
            ProductAttribute::where('product_id', $item->id)->where('attribute_type', 'finish')->delete();
            $finishes = $request->finishes;
            foreach($finishes as $finish){
                ProductAttribute::create([
                    'product_id' => $item->id,
                    'attribute_id' => $finish,
                    'attribute_type' => 'finish',
                ]);
            }
        }
        if ($request->has('colors')){
            ProductAttribute::where('product_id', $item->id)->where('attribute_type', 'color')->delete();
            $colors = $request->colors;
            foreach($colors as $color){
                ProductAttribute::create([
                    'product_id' => $item->id,
                    'attribute_id' => $color,
                    'attribute_type' => 'color',
                ]);
            }
        }
        if ($request->has('sizes')){
            ProductAttribute::where('product_id', $item->id)->where('attribute_type', 'size')->delete();
            $sizes = $request->sizes;
            foreach($sizes as $size){
                ProductAttribute::create([
                    'product_id' => $item->id,
                    'attribute_id' => $size,
                    'attribute_type' => 'size',
                ]);
            }
        }
        if ($request->has('patterns')){
            ProductAttribute::where('product_id', $item->id)->where('attribute_type', 'pattern')->delete();
            $patterns = $request->patterns;
            foreach($patterns as $pattern){
                ProductAttribute::create([
                    'product_id' => $item->id,
                    'attribute_id' => $pattern,
                    'attribute_type' => 'pattern',
                ]);
            }
        }
        if ($request->has('type')){
            ProductAttribute::where('product_id', $item->id)->where('attribute_type', 'type')->delete();
            ProductAttribute::create([
                'product_id' => $item->id,
                'attribute_id' => $request->type,
                'attribute_type' => 'type',
            ]);
        }
        
        return $item;
    }

    public function store(Request $request)
    {
        $request->validate([
            'catalogue' => 'sometimes|file|max:20480',
            'data_sheet' => 'sometimes|file|max:20480',
            'guide' => 'sometimes|file|max:20480',
        ],[
            'catalogue.max' => 'The catalogue may not be greater than 20MB.',
            'catalogue.file' => 'The catalogue not valid',
            'data_sheet.max' => 'The data sheet may not be greater than 20MB.',
            'data_sheet.file' => 'The data sheet not valid',
            'guide.max' => 'The guide may not be greater than 20MB.',
            'guide.file' => 'The guide not valid'
        ]);
        try {
            DB::beginTransaction();
            $lang = $request->lang;
            if ($lang === 'en') {
                $product = new Product();
                $this->translate($request, $request->lang, $product);
                DB::commit();
            } else {
                return back()->with('error', 'You should fill the english section first');
            }
            return redirect('admin/products?category='.$request->category_id)->with('success', 'Product added successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'catalogue' => 'sometimes|file|max:20480',
            'data_sheet' => 'sometimes|file|max:20480',
            'guide' => 'sometimes|file|max:20480',
        ],[
            'catalogue.max' => 'The catalogue may not be greater than 20MB.',
            'catalogue.file' => 'The catalogue not valid',
            'data_sheet.max' => 'The data sheet may not be greater than 20MB.',
            'data_sheet.file' => 'The data sheet not valid',
            'guide.max' => 'The guide may not be greater than 20MB.',
            'guide.file' => 'The guide not valid'
        ]);
        try {
            DB::beginTransaction();
            $product = Product::find($id);
            $this->translate($request, $request->lang, $product);
            DB::commit();
            return redirect('admin/products?category='.$request->category_id)->with('success', 'Product updated successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }

    public function deleteImage(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $media = Media::findOrFail($id);
            $media->delete();
            DB::commit();
            return response()->json(['code' => 200,
                'message' => 'Image deleted successfully']
            );
        } catch (\Exception $exception) {
            return $exception;
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $item = Product::findOrFail($id);
            $item->clearMediaCollection('gallery');
            $item->delete();
            DB::commit();
            return response()->json(['status' => '200','message'=>'Item deleted successfully']);
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json(['status' => '400','message'=> $exception->getMessage()]);
        }
    }
}
