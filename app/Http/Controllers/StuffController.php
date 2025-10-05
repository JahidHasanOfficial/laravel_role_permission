<?php

namespace App\Http\Controllers;

use App\Models\Stuff;
use App\Models\Employee;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StuffController extends Controller
{
    //  public function index()
    // {
    //     $query = Stuff::with('district', 'creator');

    //     if (!Auth::user()->hasRole('superadmin')) {
    //         $query->where('created_by', Auth::id());
    //     }

    //     $datas = $query->latest()->paginate(config('pagination.per_page'));;

    //     return view('backend.stuff.index', compact('datas'));
    // }


    public function index()
{
    try {
        // Eager load district & creator
        $query = Stuff::with('district', 'creator');

        // Non-superadmin users only see their own records
        if (!Auth::user()->hasRole('superadmin')) {
            $query->where('created_by', Auth::id());
        }

        // Pagination
        $datas = $query->latest()->paginate(config('pagination.per_page'));

        return view('backend.stuff.index', compact('datas'));

    } catch (\Exception $e) {
        // Error handling
        return back()->with('error', 'Something went wrong: ' . $e->getMessage());
    }
}



    public function create()
    {
        return view('backend.stuff.create');
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name'  => 'required|string|max:255',
    //         'email' => 'nullable|email|unique:trainers,email',
    //         'phone' => 'nullable|string|max:20',
    //         'image' => 'nullable|image|max:2048',
    //     ]);

    //     $data = new Trainer();
    //     $data->name  = $request->name;
    //     $data->email = $request->email;
    //     $data->phone = $request->phone;
    //     $data->image = $request->image;

    //     if ($request->hasFile('image')) {
    //         $trainer->image = ImageHelper::upload($request->file('image'), 'trainers');
    //     } else {
    //         $trainer->image = null;
    //     }

    //     $trainer->district_id = Auth::user()->districts->first()->id ?? null;
    //     $trainer->created_by = Auth::id();
    //     $trainer->save();

    //     return redirect()->route('trainers.index')->with('success', 'Trainer created successfully.');
    // }






public function store(Request $request)
{
    $request->validate([
        'name'    => 'required|string|max:255',
        'email'   => 'nullable|email|unique:stuffs,email',
        'phone'   => 'nullable|string|max:20',
        'image'   => 'nullable|image|max:2048',
        'address' => 'nullable|string|max:255',
    ]);

    DB::beginTransaction(); // Transaction শুরু

    try {
        // ইমেজ আপলোড (যদি থাকে)
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = ImageHelper::upload($request->file('image'), 'stuffs');
        }

        // district_id এবং created_by auto assign
        $districtId = Auth::user()->districts->first()->id ?? null;
        $createdBy  = Auth::id();

        // 1️⃣ stuffs table
        $stuff = new Stuff();
        $stuff->name        = $request->name;
        $stuff->email       = $request->email;
        $stuff->phone       = $request->phone;
        $stuff->image       = $imagePath;
        $stuff->district_id = $districtId;
        $stuff->created_by  = $createdBy;
        $stuff->save();

        // 2️⃣ employees table
        $employee = new Employee();
        $employee->name        = $request->name;
        $employee->email       = $request->email;
        $employee->phone       = $request->phone;
        $employee->image       = $imagePath;
        $employee->address     = $request->address;
        $employee->district_id = $districtId;
        $employee->created_by  = $createdBy;
        $employee->save();

        DB::commit(); // সব ঠিক থাকলে save

        return redirect()->route('stuff.index')->with('success', 'Stuff and Employee created successfully.');

    } catch (\Exception $e) {
        DB::rollBack(); // কোনো সমস্যা হলে সব revert
        return back()->with('error', 'Something went wrong: ' . $e->getMessage());
    }
}




    // public function edit(Stuff $trainer)
    // {
    //     return view('backend.stuff.edit', compact('trainer'));
    // }



    // public function update(Request $request, Trainer $trainer)
    // {
    //     $request->validate([
    //         'name'  => 'required|string|max:255',
    //         'email' => 'nullable|email|unique:trainers,email,' . $trainer->id,
    //         'phone' => 'nullable|string|max:20',
    //         'image' => 'nullable|image|max:2048',
    //     ]);

    //     $trainer->name  = $request->name;
    //     $trainer->email = $request->email;
    //     $trainer->phone = $request->phone;

    //     if ($request->hasFile('image')) {
    //         $trainer->image = ImageHelper::update($request->file('image'), $trainer->image, 'trainers');
    //     }

    //     $trainer->save();

    //     return redirect()->route('trainers.index')->with('success', 'Trainer updated successfully.');
    // }


    // public function destroy(Trainer $trainer)
    // {
    //     // Delete associated image
    //     ImageHelper::delete($trainer->image);

    //     $trainer->delete();

    //     return redirect()->route('trainers.index')->with('success', 'Trainer deleted successfully.');
    // }
}
