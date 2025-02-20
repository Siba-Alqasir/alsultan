<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Alaaeta\Translation\Facades\Translation;
use Illuminate\Support\Facades\DB;

class TranslationController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:translations-list|translations-create|translations-edit|translations-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:translations-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:translations-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:translations-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $breadcrumbs = [
            ['link' => "admin/translation", 'name' => "Translations"], ['name' => "Browse"]
        ];
        $searchKey = $request->search_key ?? '';
        $locale = $request->lang_name ?? 'en';
        request()->pageNumber = 100;
        request()->key = $searchKey;
        request()->lang_name = $locale;
        $data = Translation::getTranslations();
        return view('admin.content.translation.index', compact( 'breadcrumbs','data','searchKey','locale'));
    }

    public function edit($id)
    {
        $breadcrumbs = [
            ['link' => "/admin/translation", 'name' => "Translations"], ['name' => "Edit"]
        ];
        $translation = DB::table('translations')->where('id', $id)->first();
        return view('admin.content.translation.edit', ['breadcrumbs' => $breadcrumbs, 'translation' => $translation]);
    }

    public function store(Request $request)
    {
        $lang_name = $request->has('lang_name') && $request->lang_name != null ? $request->lang_name : 'en';
        Translation::updateOrCreateTranslation([
            'language_code' => $lang_name,
            'key' => $request->key
        ], [
            'value' => $request->value
        ]);
        return back()->with('success', 'Changed successfully');
    }
}
