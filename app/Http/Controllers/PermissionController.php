<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class PermissionController extends Controller implements HasMiddleware
{

        public static function middleware() : array
    {
        return [
             new Middleware('permission:view permissions', only: ['index']),
            new Middleware('permission:create permissions', only: ['create']),
            new Middleware('permission:update permissions', only: ['edit']),
            new Middleware('permission:delete permissions', only: ['destroy']),
        ];
    }
    public function index() {
        $permissions = Permission::all();
        return view('permission.index', compact('permissions'));
    }

    public function create() {
        return view('permission.create');
    }




      public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions|min:3|max:255',
        ]);

        if ($validator->passes()) {
           Permission::create([
               'name' => $request->name
           ]);

           return redirect()->route('permissions.index')->with('success', 'Permission created successfully');
        } else {
            return redirect()->route('permissions.create')->withInput()->withErrors($validator);
        }
        
    }

        public function edit($id) {
        $permission = Permission::findOrFail($id);

        return view('permission.edit', compact('permission'));
    }

    public function update($id , Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:permissions|min:3|max:255',
        ]);

        if ($validator->passes()) {
            $permission = Permission::findOrFail($id);
            $permission->name = $request->name;
            $permission->save();
            return redirect()->route('permissions.index')->with('success', 'Permission updated successfully');
        } else {
            return redirect()->route('permissions.edit', $id)->withInput()->withErrors($validator);
        }
        
    }



      public function destroy($id) {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully');
        
    }

}
