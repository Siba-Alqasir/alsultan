<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CompaniesController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:companies-list|companies-create|companies-edit|companies-delete', ['only' => ['index','show']]);
        $this->middleware('permission:companies-create', ['only' => ['create','store']]);
        $this->middleware('permission:companies-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:companies-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::all();

        $breadcrumbs = [
            ['link' => "/admin/companies", 'name' => "Sister Companies"], ['name' => "Browse"]
        ];
        return view('admin.content.companies.index', ['breadcrumbs' => $breadcrumbs, 'companies' => $companies]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [
            ['link' => "admin/companies", 'name' => "Sister Companies"], ['name' => "Create"]
        ];
        return view('admin.content.companies.create', ['breadcrumbs' => $breadcrumbs]);
    }

    public function translate(Request $request, $lang, $item)
    {
        $item->url = $request->url;
        $item->setTranslation('name', $lang, $request->name)
            ->setTranslation('description', $lang, $request->description)
            ->save();

        if ($request->has('logo')) {
            $item->clearMediaCollection('logo');
            $item->addMediaFromRequest('logo')->toMediaCollection('logo');
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
            if ($request->lang == 'en') {
                $company = new Company();
                self::translate($request, $request->lang, $company);
                DB::commit();
            } else {
                return back()->with('error', 'You Should add the english section first');
            }
            return redirect('admin/companies')->with('success', 'Company added successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return $exception;
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit($company)
    {
        $breadcrumbs = [
            ['link' => "/admin/companies", 'name' => "Sister Companies"], ['name' => "Edit"]
        ];
        $company = Company::find($company);
        return view('admin.content.companies.edit', ['breadcrumbs' => $breadcrumbs,'company' => $company]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$company)
    {
        try {
            DB::beginTransaction();
            $company = Company::find($company);
            self::translate($request, $request->lang, $company);
            DB::commit();
            return redirect('admin/companies')->with('success', 'Company updated successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy($company)
    {
        try {
            DB::beginTransaction();
            $company = Company::findOrFail($company);
            $company->clearMediaCollection('logo');
            $company->delete();
            DB::commit();
           return response()->json(['status' => '200','message'=>'Item deleted successfully']);
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }
}
