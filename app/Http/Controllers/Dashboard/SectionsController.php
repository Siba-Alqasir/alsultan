<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SectionsController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Section $section
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($slug)
    {
        $section = Section::where('key', 'like', '%' . $slug . '%')->first();
        // if($section->key === 'about_page_mission' || $section->key === 'about_page_vision'){
        //     $removedInputs = $section->removed_inputs;
        //     $removedInputs['image'] = 0;
        //     $section->removed_inputs = $removedInputs;
        //     $section->save();
        // }
        if($section->key === 'home_page_visualizer'){
            $removedInputs = $section->removed_inputs;
            $removedInputs['image'] = 0;
            $removedInputs['highlight'] = 0;
            $removedInputs['video'] = 1;
            $section->removed_inputs = $removedInputs;

            $requiredInputs = $section->is_required;
            $requiredInputs['image'] = 1;
            $requiredInputs['highlight'] = 1;
            $requiredInputs['video'] = 0;
            $section->is_required = $requiredInputs;
            $section->save();
        }
        $breadcrumbs = [
            ['link' => "#", 'name' => 'Edit Section'], ['name' => __("locale.$section->key")]
        ];
        return view('admin.content.sections.edit', ['breadcrumbs' => $breadcrumbs,  'section' => $section]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Section $section
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $key)
    {
        
        $data = $request->all();
        $section = Section::where('key', $key)->first();
        if ($request->has('image')) {
            $section->clearMediaCollection('images');
            $section->addMediaFromRequest('image')->toMediaCollection('images');
        }
        if ($request->has('mobile_image')) {
            $section->clearMediaCollection('mobile_images');
            $section->addMediaFromRequest('mobile_image')->toMediaCollection('mobile_images');
        }
        if ($request->has('second_image')) {
            $section->clearMediaCollection('second_image');
            $section->addMediaFromRequest('second_image')->toMediaCollection('second_image');
        }
        if ($request->has('mobile_second_image')) {
            $section->clearMediaCollection('mobile_second_image');
            $section->addMediaFromRequest('mobile_second_image')->toMediaCollection('mobile_second_image');
        }
        try {
            DB::beginTransaction();
            $section->update($data);
            DB::commit();
            return redirect()->back()->with('success', 'Section updated successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }

    }
}
