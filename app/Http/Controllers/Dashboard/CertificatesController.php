<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Certificate;
use Illuminate\Support\Facades\DB;

class CertificatesController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:certificates-list|certificates-create|certificates-edit|certificates-delete', ['only' => ['index','show']]);
        $this->middleware('permission:certificates-create', ['only' => ['create','store']]);
        $this->middleware('permission:certificates-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:certificates-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $certificates = Certificate::all();

        $breadcrumbs = [
            ['link' => "/admin/certificates", 'name' => "Certificates"], ['name' => "Browse"]
        ];
        return view('admin.content.certificates.index', ['breadcrumbs' => $breadcrumbs, 'certificates' => $certificates]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [
            ['link' => "admin/certificates", 'name' => "Certificates"], ['name' => "Create"]
        ];
        return view('admin.content.certificates.create', ['breadcrumbs' => $breadcrumbs]);
    }

    public function translate(Request $request, $lang, $item)
    {
        
        $item->setTranslation('title', $lang, $request->title)
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
                $certificate = new Certificate();
                self::translate($request, $request->lang, $certificate);
                DB::commit();
            } else {
                return back()->with('error', 'You Should add the english section first');
            }
            return redirect('admin/certificates')->with('success', 'Certificate added successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return $exception;
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function show(Certificate $certificate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function edit($certificate)
    {
        $breadcrumbs = [
            ['link' => "/admin/certificates", 'name' => "Certificates"], ['name' => "Edit"]
        ];
        $certificate = Certificate::find($certificate);
        return view('admin.content.certificates.edit', ['breadcrumbs' => $breadcrumbs,'certificate' => $certificate]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$certificate)
    {
        try {
            DB::beginTransaction();
            $certificate = Certificate::find($certificate);
            self::translate($request, $request->lang, $certificate);
            DB::commit();
            return redirect('admin/certificates')->with('success', 'Certificate updated successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function destroy($certificate)
    {
        try {
            DB::beginTransaction();
            $certificate = Certificate::findOrFail($certificate);
            $certificate->clearMediaCollection('logo');
            $certificate->delete();
            DB::commit();
           return response()->json(['status' => '200','message'=>'Item deleted successfully']);
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }
}
