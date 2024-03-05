<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(){
        $roles = Role::get();
        return view('role-permissions.role.index',[
            'roles'=>$roles
        ]);
    }


    public function create(){
        return view('role-permissions.role.create');

    }


    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|unique:roles,name',
        ]);
    
        try {
        Role::create([
            'name' => $request->name
        ]);
    } catch (\Exception $e) {
    
    }
    return redirect()->back()->withErrors('status', 'role created successfully.');

    }


    public function edit(Role $role){
        return view('role-permissions.role.edit',[
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
        return view('role-permissions.role.add-permissions',[
            'role'=>$role,
            'permissions'=> $permissions,
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
