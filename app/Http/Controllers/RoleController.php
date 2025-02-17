<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(){
        $roles = Role::get();
        return view('role-permissions\roles\index',[
            'roles'=>$roles
        ]);
    }

    public function create(){
        return view('role-permissions\roles\create');

    }


    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|unique:roles,name',
        ]);
        
    // dd($request->all());
        try {
        Role::create([
            'name' => $request->name
        ]);
    } catch (\Exception $e) {
    
    }
    return redirect()->back()->withErrors('status', 'role created successfully.');

    }


    public function edit(Role $role){
        return view('role-permissions.roles.edit',[
            'role'=>$role

        ]);
    }

    
    
    public function update(Request $request, Role $role){
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
        ]);
    
        $role->update([
            'name' => $request->name,
        ]);
    
        return redirect('roles')->with('status', 'role updated successfully.');
    }
    

    
    public function destroy($roleId){
        $role = Role::find($roleId); 
        if ($role) { 
            $role->delete();
            return redirect('roles')->with('status', 'role deleted successfully.'); 
        } else {
            return redirect('roles')->withErrors('role not found.'); 
        }
    }



    public function addPermissionToRole($roleId){
        $permissions = Permission::get();
        $role = Role::findOrFail($roleId);
        $rolePermissions = DB::table('role_has_permissions')
        ->where('role_has_permissions.role_id',$role->id)
        ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')->all();
        return view('role-permissions.roles.add-permissions',[
            'role'=>$role,
            'permissions'=> $permissions,
            'rolePermissions'=>$rolePermissions,
        ]);
    }


    public function givePermissionToRole(Request $request,$roleId){
        $request->validate([
            'permissions.*'=> 'required'
        ]);
    
        $role = Role::findOrFail($roleId);
    // dd($role);
        $role->syncPermissions($request->permissions);   
        // dd($request->all());

        return redirect()->back()->with('status','permission add to role'); 

    }


}
