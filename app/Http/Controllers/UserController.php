<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\District;
use App\Models\Division;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class UserController extends Controller implements HasMiddleware
{


    public static function middleware() : array
    {
        return [
             new Middleware('permission:view users', only: ['index']),
             new Middleware('permission:create users', only: ['create']),
            new Middleware('permission:update users', only: ['edit']),
             new Middleware('permission:delete users', only: ['destroy']),
        ];
    }


    /**
     * 
     * 
     * Display a listing of the resource.
     */
  public function index()
{
    $users = User::with(['roles', 'districts.division'])->orderBy('id', 'DESC')->get();
    return view('user.index', compact('users'));
}


    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     $roles = Role::orderBy('id', 'DESC')->get();
    //     return view('user.create', compact('roles'));
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'required|unique:users|min:3|max:255',
    //         'email' => 'required|email|unique:users',
    //         'password' => 'required|same:confirm_password',
    //         'confirm_password' => 'required',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),

    //     ]);



    //     $user->syncRoles($request->role);

    //     return redirect()->route('users.index')->with('success', 'User created successfully.');
    // }


public function create()
{
    $roles = Role::orderBy('id', 'DESC')->get();
    $divisions = Division::orderBy('name')->get();
    return view('user.create', compact('roles', 'divisions'));
}

public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|unique:users|min:3|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|same:confirm_password',
        'confirm_password' => 'required',
        'district_id' => 'required|array|min:1',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    // dd($request->district_id);


    $user->syncRoles($request->role);
    //  dd($user->districts()->sync($request->district_id));
 $user->districts()->sync($request->district_id);


    return redirect()->route('users.index')->with('success', 'User created successfully.');
}



public function districtsByDivision($division_id)
{
    $districts = District::where('division_id', $division_id)->get();
    $html = '';

    foreach($districts as $district) {
        $html .= '<div class="flex items-center space-x-2">';
        $html .= '<input type="checkbox" name="district_id[]" id="district-'.$district->id.'" value="'.$district->id.'">';
        $html .= '<label for="district-'.$district->id.'">'.$district->name.'</label>';
        $html .= '</div>';
    }

    return $html;
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       //
    }

    /**
     * Show the form for editing the specified resource.
     */
   // Edit
public function edit(string $id)
{
    $user = User::findOrFail($id);
    $roles = Role::orderBy('id', 'DESC')->get();
    $divisions = Division::orderBy('name')->get();

    $hasRoles = $user->roles->pluck('id');
    $hasDistricts = $user->districts->pluck('id')->toArray();

    // selected division (if user has districts)
    $selectedDivisionId = $user->districts->first() ? $user->districts->first()->division_id : null;

    return view('user.edit', compact('user', 'roles', 'divisions', 'hasRoles', 'hasDistricts', 'selectedDivisionId'));
}


// Update
public function update(Request $request, string $id)
{
    $user = User::findOrFail($id);

    $validator = Validator::make($request->all(), [
        'name' => 'required|unique:users,name,'.$id.',id',
        'email' => 'required|email|unique:users,email,'.$id.',id',
        'password' => 'nullable|same:confirm_password',
        'confirm_password' => 'nullable',
        'district_id' => 'required|array|min:1',
    ]);

    if ($validator->fails()) {
        return redirect()->route('users.edit', $id)->withInput()->withErrors($validator);
    }

    $user->name = $request->name;
    $user->email = $request->email;

    // Password update only if filled
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    // Roles sync
    $user->syncRoles($request->role);

    // Districts sync
    $user->districts()->sync($request->district_id);

    return redirect()->route('users.index')->with('success', 'User updated successfully');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
