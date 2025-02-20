<?php

namespace App\Http\Controllers\Auth;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;

class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:roles-list|roles-create|roles-edit|roles-delete', ['only' => ['index','show']]);
        $this->middleware('permission:roles-create', ['only' => ['create','store']]);
        $this->middleware('permission:roles-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:roles-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $breadcrumbs = [
            ['link' => "admin/roles", 'name' => "Roles"], ['name' => "Browse"]
        ];
        $roles = Role::orderBy('id','DESC')->get();
        return view('admin.auth.roles.index',compact('roles','breadcrumbs'));
    }

    public function create()
    {
        $breadcrumbs = [
            ['link' => "admin/roles", 'name' => "Roles"], ['name' => "Create"]
        ];
        $permission = Permission::get()->toArray();
        return view('admin.auth.roles.create',compact('permission','breadcrumbs'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index')
            ->with('success','Role created successfully');
    }

    public function show($id)
    {
        $breadcrumbs = [
            ['link' => "admin/roles", 'name' => "Roles"], ['name' => "View"]
        ];
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get()->toArray();

        return view('admin.auth.roles.show',compact('role','rolePermissions','breadcrumbs'));
    }

    public function edit($id)
    {
        $breadcrumbs = [
            ['link' => "admin/roles", 'name' => "Roles"], ['name' => "Edit"]
        ];
        $role = Role::find($id);
        $permission = Permission::get()->toArray();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();

        return view('admin.auth.roles.edit',compact('role','permission','rolePermissions','breadcrumbs'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index')
            ->with('success','Role updated successfully');
    }

    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('roles.index')
            ->with('success','Role deleted successfully');
    }
}
