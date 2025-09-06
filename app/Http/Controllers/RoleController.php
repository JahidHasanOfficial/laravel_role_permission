<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index(){
        $roles = Role::orderBy('id', 'DESC')->get();
        return view('role.index', compact('roles'));
    }

    public function create(){
        $permissions = Permission::orderBy('id', 'DESC')->get();
        return view('role.create', compact('permissions'));
    }

      public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions|min:3|max:255',
        ]);

        if ($validator->passes()) {
         $role =  Role::create([
               'name' => $request->name
           ]);

           if( !empty($request->permission) ) {
               foreach($request->permission as $name) {
                  $role->givePermissionTo($name);
               }
           }

           return redirect()->route('roles.index')->with('success', 'Role created successfully');
        } else {
            return redirect()->route('roles.create')->withInput()->withErrors($validator);
        }
        
    }

    public function edit($id) {
        $role = Role::findOrFail($id);
        $hasPermissions = $role->permissions->pluck('name');
        $permissions = Permission::orderBy('id', 'DESC')->get();
        return view('role.edit', compact('role', 'hasPermissions', 'permissions'));
    }


     public function update($id , Request $request) {

        $role = Role::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,'.$id.',id',
        ]);

        if ($validator->passes()) {
            $role->name = $request->name;
            $role->save();

            if( !empty($request->permission) ) {
                $role->syncPermissions($request->permission);
            } else {
                $role->syncPermissions([]);
            }
            return redirect()->route('roles.index')->with('success', 'Role updated successfully');
        } else {
            return redirect()->route('roles.edit', $id)->withInput()->withErrors($validator);
        }
        
    }

    public function destroy($id) {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully');
        
    }

}
