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
                'permission'=>$permissions
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
        return redirect()->back()->withErrors('status', 'Permission created successfully.');

        }




        public function edit(){

        }

        
        public function update(){

        }

        
        public function destroy(){

        }
    }
