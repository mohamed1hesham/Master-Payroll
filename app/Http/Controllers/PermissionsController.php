<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;


class PermissionsController extends Controller
{
        public function index(){
            $permissions = Permission::get();
            return view('role-permissions.permission.index',[
                'permissions'=>$permissions
            ]);
        }


        public function create(){
            return view('role-permissions.permission.create');

        }


        public function store(Request $request){
            $request->validate([
                'name' => 'required|string|unique:permissions,name',
            ]);
        
            try {
            Permission::create([
                'name' => $request->name
            ]);
        } catch (\Exception $e) {
        
        }
        return redirect('permissions')->withErrors('status', 'Permission created successfully.');

        }


        public function edit(Permission $permission){
            return view('role-permissions.permission.edit',[
                'permission'=>$permission

            ]);
        }




        // public function update(Request $request,Permission $permission ){
        //     $request->validate([
        //         'name' => 'required|string|unique:permissions,name',
        //     ]);
        
        //     try {
        //     $permission->update([
        //         'name' => $request->name
        //     ]);
        // } catch (\Exception $e) {
        
        // }
        // return redirect()->back()->withErrors('status', 'Permission update successfully.');

        // }

        
        
        public function update(Request $request, Permission $permission){
            $request->validate([
                'name' => 'required|string|unique:permissions,name,' . $permission->id,
            ]);
        
            $permission->update([
                'name' => $request->name,
            ]);
        
            return redirect('permissions')->with('status', 'Permission updated successfully.');
        }
        

        
        public function destroy($permissionId){
            $permission = Permission::find($permissionId); 
            if ($permission) { 
                $permission->delete();
                return redirect('permissions')->with('status', 'Permission deleted successfully.'); 
            } else {
                return redirect()->back()->withErrors('Permission not found.'); 
            }
        }
    }
