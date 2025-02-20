<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\News;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:news-list|news-create|news-edit|news-delete', ['only' => ['index','show']]);
        $this->middleware('permission:news-create', ['only' => ['create','store']]);
        $this->middleware('permission:news-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:news-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('lang')){
            $news = News::whereNotNull('title->'.$request->lang)->get();
            $locale = $request->lang;
        }else {
            $news = News::whereNotNull('title->en')->get();
            $locale = 'en';
        }
        $breadcrumbs = [
            ['link' => "/admin/news", 'name' => "News & Blogs"], ['name' => "Browse"]
        ];
        return view('admin.content.news.index', ['breadcrumbs' => $breadcrumbs, 'news' => $news, 'locale' => $locale]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [
            ['link' => "admin/news", 'name' => "News & Blogs"], ['name' => "Create"]
        ];
        return view('admin.content.news.create', ['breadcrumbs' => $breadcrumbs]);
    }

    public function translate(Request $request, $lang, $item)
    {
        if($request->date)
            $item->date = $request->date;
        $item->setTranslation('title', $lang, $request->title)
        ->setTranslation('description', $lang, $request->description)
        ->setTranslation('author', $lang, $request->author)
        ->setTranslation('meta_title', $lang, $request->meta_title)
        ->setTranslation('meta_description', $lang, $request->meta_description)
        ->setTranslation('meta_keyword', $lang, $request->meta_keyword)
        ->save();
        
        if($request->slug) {
            $item->slug = $request->slug;
            $item->save();
        }
        if ($request->has('cover')) {
            $item->clearMediaCollection('cover');
            $item->addMediaFromRequest('cover')->toMediaCollection('cover');
        }
        if ($request->has('list_image')) {
            $item->clearMediaCollection('list_image');
            $item->addMediaFromRequest('list_image')->toMediaCollection('list_image');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            // if ($request->lang == 'en') {
                $news = new News();
                self::translate($request, $request->lang, $news);
                DB::commit();
            // } else {
            //     return back()->with('error', 'You Should add the english section first');
            // }
            return redirect('admin/news')->with('success', 'News added successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return $exception;
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit($news)
    {
        $breadcrumbs = [
            ['link' => "/admin/news", 'name' => "News & Blogs"], ['name' => "Edit"]
        ];
        $news = News::find($news);
        return view('admin.content.news.edit', ['breadcrumbs' => $breadcrumbs,'news' => $news]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$news)
    {
        try {
            DB::beginTransaction();
            $news = News::find($news);
            self::translate($request, $request->lang, $news);
            DB::commit();
            return redirect('admin/news')->with('success', 'News updated successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy($news)
    {
        try {
            DB::beginTransaction();
            $news = News::findOrFail($news);
            $news->clearMediaCollection('cover');
            $news->clearMediaCollection('list_image');
            $news->delete();
            DB::commit();
           return response()->json(['status' => '200','message'=>'Item deleted successfully']);
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }
}
