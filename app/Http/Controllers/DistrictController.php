<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;       


class DistrictController extends Controller implements HasMiddleware
{
     public static function middleware(): array
    {
        return [
            new Middleware('permission:view districts', only: ['index']),
            new Middleware('permission:create districts', only: ['create']),
            new Middleware('permission:update districts', only: ['edit']),
            new Middleware('permission:delete districts', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $districts = District::with('division')->orderBy('id', 'DESC')->get();
        return view('backend.district.index', compact('districts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $divisions = Division::orderBy('id', 'DESC')->get();
        return view('backend.district.create', compact('divisions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:divisions|min:3|max:255',
            'division_id' => 'required',
        ]);

        if ($validator->passes()) {
            District::create([
                'name' => $request->name,
                'division_id' => $request->division_id
            ]);

            return redirect()->route('districts.index')->with('success', 'District created successfully');
        } else {
            return redirect()->route('districts.create')->withInput()->withErrors($validator);
        }
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
    public function edit(string $id)
    {
        $district = District::findOrFail($id);
        $divisions = Division::orderBy('id', 'DESC')->get();
        return view('backend.district.edit', compact('district', 'divisions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:255',
            'division_id' => 'required',
        ]);

        if ($validator->passes()) {
            $disctrict = District::findOrFail($id);
            $disctrict->name = $request->name;
            $disctrict->division_id = $request->division_id;
            $disctrict->save();
            return redirect()->route('districts.index')->with('success', 'District updated successfully');
        } else {
            return redirect()->route('districts.edit', $id)->withInput()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $disctrict = District::findOrFail($id);
        $disctrict->delete();
        return redirect()->route('districts.index')->with('success', 'District deleted successfully');
    }
}
