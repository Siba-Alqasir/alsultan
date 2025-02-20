<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Slider;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SlidersController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:sliders-list|sliders-create|sliders-edit|sliders-delete', ['only' => ['index','show']]);
        $this->middleware('permission:sliders-create', ['only' => ['create','store']]);
        $this->middleware('permission:sliders-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:sliders-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::all();

        $breadcrumbs = [
            ['link' => "/admin/sliders", 'name' => "Sliders"], ['name' => "Browse"]
        ];
        return view('admin.content.sliders.index', ['breadcrumbs' => $breadcrumbs, 'sliders' => $sliders]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [
            ['link' => "admin/sliders", 'name' => "Sliders"], ['name' => "Create"]
        ];
        return view('admin.content.sliders.create', ['breadcrumbs' => $breadcrumbs]);
    }

    public function translate(Request $request, $lang, $item)
    {
        if($lang == 'en') $item->is_active = $request->has('is_active') ? 1 : 0;
        $item->setTranslation('title', $lang, $request->title)->
        setTranslation('sub_title', $lang, $request->sub_title)->
        setTranslation('btn_title', $lang, $request->btn_title)->
        setTranslation('btn_link', $lang, $request->btn_link)->
        setTranslation('description', $lang, $request->description)
        ->save();
        if ($request->has('cover')) {
            $file = $request->file('cover');
            $mimeType = $file->getMimeType();
            if (str_starts_with($mimeType, 'image/')) {
                $item->clearMediaCollection('images');
                $item->clearMediaCollection('videos');
                $item->addMediaFromRequest('cover')->toMediaCollection('images');
                $item->is_video = 0;
                $item->save();
            } elseif (str_starts_with($mimeType, 'video/')) {
                $item->clearMediaCollection('images');
                $item->clearMediaCollection('videos');
                $item->addMediaFromRequest('cover')->toMediaCollection('videos');
                $item->is_video = 1;
                $item->save();
            }
        }
        if ($request->has('mobile_cover')) {
            $file = $request->file('mobile_cover');
            $mimeType = $file->getMimeType();
            if (str_starts_with($mimeType, 'image/')) {
                $item->clearMediaCollection('mobile_images');
                $item->clearMediaCollection('mobile_videos');
                $item->addMediaFromRequest('mobile_cover')->toMediaCollection('mobile_images');
            } elseif (str_starts_with($mimeType, 'video/')) {
                $item->clearMediaCollection('mobile_images');
                $item->clearMediaCollection('mobile_videos');
                $item->addMediaFromRequest('mobile_cover')->toMediaCollection('mobile_videos');
            }
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
        $request->validate([
            'cover' => 'required|file|max:5120',
            'mobile_cover' => 'required|file|max:5120',
        ],[
            'cover.max' => 'The cover may not be greater than 5MB.',
            'mobile_cover.max' => 'The mobile cover may not be greater than 5MB.',
        ]);
        try {
            DB::beginTransaction();
            if ($request->lang == 'en') {
                $slider = new Slider();
                self::translate($request, $request->lang, $slider);
                DB::commit();
            } else {
                return back()->with('error', 'You Should add the english section first');
            }
            return redirect('admin/sliders')->with('success', 'Slider added successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return $exception;
            return back()->with('error', $exception->getMessage());
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit($slider)
    {
        $breadcrumbs = [
            ['link' => "/admin/sliders", 'name' => "Sliders"], ['name' => "Edit"]
        ];
        $slider = Slider::find($slider);
        return view('admin.content.sliders.edit', ['breadcrumbs' => $breadcrumbs,'slider' => $slider]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slider)
    {
        try {
            DB::beginTransaction();
            $slider = Slider::find($slider);
            self::translate($request, $request->lang, $slider);
            DB::commit();
            return redirect('admin/sliders')->with('success', 'Slider updated successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy($slider)
    {
        try {
            DB::beginTransaction();
            $slider = Slider::findOrFail($slider);
            $slider->clearMediaCollection('videos');
            $slider->clearMediaCollection('mobile_videos');
            $slider->clearMediaCollection('images');
            $slider->clearMediaCollection('mobile_images');
            $slider->delete();
            DB::commit();
           return response()->json(['status' => '200','message'=>'Item deleted successfully']);
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }
}
