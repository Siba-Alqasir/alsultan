<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Facades\DB;

class ClientsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:clients-list|clients-create|clients-edit|clients-delete', ['only' => ['index','show']]);
        $this->middleware('permission:clients-create', ['only' => ['create','store']]);
        $this->middleware('permission:clients-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:clients-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::select('*')->orderBy('type')->get();

        $breadcrumbs = [
            ['link' => "/admin/clients", 'name' => "Clients"], ['name' => "Browse"]
        ];
        return view('admin.content.clients.index', ['breadcrumbs' => $breadcrumbs, 'clients' => $clients]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [
            ['link' => "admin/clients", 'name' => "Clients"], ['name' => "Create"]
        ];
        return view('admin.content.clients.create', ['breadcrumbs' => $breadcrumbs]);
    }

    public function translate(Request $request, $lang, $item)
    {
        if($request->type)
            $item->type = $request->type;
        $item->setTranslation('name', $lang, $request->name)
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
                $client = new Client();
                self::translate($request, $request->lang, $client);
                DB::commit();
            } else {
                return back()->with('error', 'You Should add the english section first');
            }
            return redirect('admin/clients')->with('success', 'Client added successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return $exception;
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit($client)
    {
        $breadcrumbs = [
            ['link' => "/admin/clients", 'name' => "Clients"], ['name' => "Edit"]
        ];
        $client = Client::find($client);
        return view('admin.content.clients.edit', ['breadcrumbs' => $breadcrumbs,'client' => $client]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$client)
    {
        try {
            DB::beginTransaction();
            $client = Client::find($client);
            self::translate($request, $request->lang, $client);
            DB::commit();
            return redirect('admin/clients')->with('success', 'Client updated successfully');
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($client)
    {
        try {
            DB::beginTransaction();
            $client = Client::findOrFail($client);
            $client->clearMediaCollection('logo');
            $client->delete();
            DB::commit();
           return response()->json(['status' => '200','message'=>'Item deleted successfully']);
        } catch (\Exception $exception) {
            DB::rollback();
            return back()->with('error', $exception->getMessage());
        }
    }
}
