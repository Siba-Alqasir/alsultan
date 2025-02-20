<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:pages-edit', ['only' => ['edit','update']]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($slug)
    {
        $page = Page::where('key','like', '%'.$slug.'%')->first();
        if($page === null){
            $page = Page::create([
                'key' => $slug.'-page',
                'slug' => $slug.'-page',
                'title' => $slug,
                'sub_title' => $slug,
                'description' => $slug,
                'meta_title' => $slug,
                'meta_description' => $slug,
                'is_required' => [
                    "seo" => 1,
                    "cover" => 1,
                    "title" => 1,
                    "sub_title" => 1,
                    "video" => 0,
                    "description" => 0
                ],
                'removed_inputs' => [
                    "seo" => 0,
                    "cover" => 0,
                    "title" => 0,
                    "sub_title" => 0,
                    "video" => 1,
                    "description" => 1
                ]
            ]);
        }
        // if($page->key === 'search-page'){
        //     $removedInputs = $page->removed_inputs;
        //     $removedInputs['description'] = 1;
        //     $page->removed_inputs = $removedInputs;

        //     $requiredInputs = $page->is_required;
        //     $requiredInputs['description'] = 0;
        //     $page->is_required = $requiredInputs;
        //     $page->save();
        // }
        $breadcrumbs = [
            ['link' => "#", 'name' =>  ucfirst($page->title)], ['name' =>'Main Info']
        ];
        return view('admin.content.pages.edit', ['breadcrumbs' => $breadcrumbs,  'page' => $page])->with('success', 'Page updated successfully');

    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $slug)
    {
        $page = Page::where('key', $slug)->first();
        $data = $request->all();
        try {
            DB::beginTransaction();
            $page->update($data);
            if ($request->has('image')) {
                $page->clearMediaCollection('images');
                $page->addMediaFromRequest('image')->toMediaCollection('images');
            }
            if ($request->has('mobile_image')) {
                $page->clearMediaCollection('mobile_images');
                $page->addMediaFromRequest('mobile_image')->toMediaCollection('mobile_images');
            }
            if ($request->has('logo')) {
                $page->clearMediaCollection('logos');
                $page->addMediaFromRequest('logo')->toMediaCollection('logos');
            }
            if ($request->has('mobile_logo')) {
                $page->clearMediaCollection('mobile_logos');
                $page->addMediaFromRequest('mobile_logo')->toMediaCollection('mobile_logos');
            }
            if ($request->has('video')) {
                $page->clearMediaCollection('videos');
                $page->addMediaFromRequest('video')->toMediaCollection('videos');
            }
            if ($request->has('mobile_video')) {
                $page->clearMediaCollection('mobile_videos');
                $page->addMediaFromRequest('mobile_video')->toMediaCollection('mobile_videos');
            }
            if ($request->has('menu_image')) {
                $page->clearMediaCollection('menu_images');
                $page->addMediaFromRequest('menu_image')->toMediaCollection('menu_images');
            }
            if ($request->has('menu_mobile_image')) {
                $page->clearMediaCollection('menu_mobile_images');
                $page->addMediaFromRequest('menu_mobile_image')->toMediaCollection('menu_mobile_images');
            }
            DB::commit();
            return redirect()->back()->with('success', 'Page updated successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }
}
