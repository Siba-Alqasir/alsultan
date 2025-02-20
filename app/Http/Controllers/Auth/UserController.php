<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:users-list|users-create|users-edit|users-delete', ['only' => ['index','show']]);
        $this->middleware('permission:users-create', ['only' => ['create','store']]);
        $this->middleware('permission:users-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:users-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data = User::all();
        $breadcrumbs = [
            ['link' => "admin/users", 'name' => "Users"], ['name' => "Browse"]
        ];
        return view('admin.auth.users.index',compact('data','breadcrumbs'));
    }

    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        $breadcrumbs = [
            ['link' => "admin/users", 'name' => "Users"], ['name' => "Create"]
        ];
        return view('admin.auth.users.create',compact('roles','breadcrumbs'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success','User created successfully');
    }

    public function show($id)
    {
        $user = User::find($id);
        $breadcrumbs = [
            ['link' => "admin/users", 'name' => "Users"], ['name' => "View"]
        ];
        return view('admin.auth.users.show',compact('user','breadcrumbs'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        $breadcrumbs = [
            ['link' => "admin/users", 'name' => "Users"], ['name' => "Edit"]
        ];
        return view('admin.auth.users.edit',compact('user','roles','userRole','breadcrumbs'));
    }

    public function update(Request $request, $id)
    {


        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success','User updated successfully');
    }

    public function updateProfile(Request $request, $id)
    {
        if(Auth::id() === (int) $id)
            $request->merge(['roles' => Auth::user()->roles()->pluck('name')->toArray()]);

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $user->assignRole($request->input('roles'));
        if(Auth::id() === (int) $id)
            return redirect()->route('profile')
                ->with('success','Profile  updated successfully');
        else
            return redirect()->route('users.index')
                ->with('success','User updated successfully');
    }


    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
            ->with('success','User deleted successfully');
    }
    public function profile()
    {
        $user = User::find(Auth::id());
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();
        $breadcrumbs = [
            ['link' => "#", 'name' => "Admin"], ['name' => "Profile"]
        ];
        return view('admin.auth.users.profile',compact('user','roles','userRole','breadcrumbs'));
    }
}
