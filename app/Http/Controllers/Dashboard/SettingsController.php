<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:settings-list|settings-create|settings-edit|settings-delete', ['only' => ['index','show']]);
        $this->middleware('permission:settings-create', ['only' => ['create','store']]);
        $this->middleware('permission:settings-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:settings-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $settings = Setting::all();
        $breadcrumbs = [
            ['link' => "admin/settings", 'name' => "Settings"], ['name' => "Browse"]
        ];
        return view('admin.content.settings.index', ['breadcrumbs' => $breadcrumbs, 'settings' => $settings]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function translate(Request $request, $lang, $item)
    {
        $item->setTranslation('value', $lang, $request->value)->save();
        if ($request->has('brochure')) {
            $item->clearMediaCollection('brochure');
            $item->addMediaFromRequest('brochure')->toMediaCollection('brochure');
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $breadcrumbs = [
            ['link' => "admin/settings", 'name' => "Settings"], ['name' => "Edit"]
        ];
        $settings = Setting::find($id);
        return view('admin.content.settings.edit', ['breadcrumbs' => $breadcrumbs,  'settings' => $settings]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $settings = Setting::find($request->settings_id);
            $this->translate($request, $request->lang, $settings);
            DB::commit();
            return back()->with('success', 'Settings updated successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $settings = Setting::findOrFail($id);
            $settings->delete();
            DB::commit();
            return response()->json(['status' => '200', 'message' => 'Item deleted successfully']);
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json(['status' => '400', 'message' => $exception->getMessage()]);
        }
    }
}
