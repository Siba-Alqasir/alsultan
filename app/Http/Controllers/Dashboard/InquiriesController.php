<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Inquiry;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class InquiriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:inquiries-list|inquiries-delete', ['only' => ['index','show']]);
        $this->middleware('permission:inquiries-delete', ['only' => ['destroy']]);

    }
    public function index(Request $request)
    {
        $type = $request->type ?? 'form';
        $Inquiries = Inquiry::where('type', $type)->latest()->get();
        $name = $type === 'contact' ? 'Contact Inquiries' : ($type === 'inquiry' ? 'Form Inquiries' : 'Tailor Made Design Inquiries');
        $breadcrumbs = [
            ['link' => "admin/inquiries?type=".$type, 'name' => $name], ['name' => "Browse"]
        ];
        return view('admin.content.inquiries.index', ['breadcrumbs' => $breadcrumbs, 'inquiries' => $Inquiries, 'type' => $type]);
    }

    public function show($id)
    {
        $contact = Inquiry::where('id',$id)->first();
        $name = $contact->type === 'contact' ? 'Contact Inquiries' : 'Form Inquiries';
        $breadcrumbs = [
            ['link' => "admin/inquiries?type=".$contact->type, 'name' => $name], ['name' => "View"]
        ];
        return view('admin.content.inquiries.show', ['breadcrumbs' => $breadcrumbs, 'contact' => $contact]);
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $item = Inquiry::findOrFail($id);
            $item->delete();
            DB::commit();
            return response()->json(['status' => '200','message'=>'Item deleted successfully']);
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json(['status' => '400','message'=> $exception->getMessage()]);
        }
    }
}
