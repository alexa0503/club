<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Validator;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:管理员','permission:权限管理']);
    }
    public function index()
    {
        $admins = \App\Admin::paginate(20);
        foreach ($admins as $admin) {
            $admin->role_names = implode(',', $admin->getRoleNames()->toArray());
            $permission_names = [];
            foreach ($admin->getAllPermissions() as $permission) {
                $permission_names[] = $permission->name;
            }
            $admin->permission_names = implode(',', $permission_names);
        }
        //dd($admins);
        return view('admin.permission.index', ['items' => $admins]);
    }
    public function create()
    {
        $dealers = \App\Dealer::all();
        return view('admin.permission.create', [
            'dealers' => $dealers,
            'permissions' => Permission::all(),
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:admins|max:255',
            'email' => 'required|email|unique:admins',
            'password' => 'required',
            'role' => 'required',
            'permission' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 403);
        }
        $admin = new \App\Admin;
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->password = bcrypt($request->password);
        $admin->save();

        foreach ($request->role as $role) {
            $_role = Role::where('name', $role)->where('guard_name', 'admin')->select('id')->first();
            if( null == $_role){
                Role::create(['guard_name' => 'admin', 'name' => $role]);
            }
        }
        $admin->syncRoles($request->role);
        $admin->syncPermissions($request->permission);
        return response()->json(['ret' => 0, 'url' => route('permission.index')]);

    }
    public function edit($id)
    {
        $dealers = \App\Dealer::all();
        $admin = \App\Admin::find($id);

        $permission_names = [];
        foreach ($admin->getAllPermissions() as $permission) {
            $permission_names[] = $permission->name;
        }
        return view('admin.permission.edit',[
            'admin' => $admin,
            'dealers' => $dealers,
            'permissions' => Permission::all(),
            'role_names' => $admin->getRoleNames()->toArray(),
            'permission_names' => $permission_names,
        ]);
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:admins,name,'.$id.'|max:255',
            'email' => 'required|email|unique:admins,email,'.$id,
            'role' => 'required',
            'permission' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 403);
        }
        $admin = \App\Admin::find($id);
        $admin->name = $request->name;
        $admin->email = $request->email;
        if( $request->_password != null ){
            $admin->password = bcrypt($request->_password);
        }
        $admin->save();
        $admin->syncRoles($request->role);
        $admin->syncPermissions($request->permission);
        return response()->json(['ret' => 0, 'url' => route('permission.index')]);

    }
    public function destroy($id)
    {
        $admin = \App\Admin::find($id);
        $admin->delete();
        return ['ret'=>0];
    }
}
