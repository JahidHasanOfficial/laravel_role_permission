<?php

namespace App\Http\Controllers;

use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class DivisionController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view posts', only: ['index']),
            new Middleware('permission:create posts', only: ['create']),
            new Middleware('permission:update posts', only: ['edit']),
            new Middleware('permission:delete posts', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $divisions = Division::orderBy('id', 'DESC')->get();
        return view('backend.division.index', compact('divisions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.division.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:divisions|min:3|max:255',
        ]);

        if ($validator->passes()) {
            Division::create([
                'name' => $request->name
            ]);

            return redirect()->route('divisions.index')->with('success', 'Division created successfully');
        } else {
            return redirect()->route('divisions.create')->withInput()->withErrors($validator);
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
        $division = Division::findOrFail($id);
        return view('backend.division.edit', compact('division'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:255',
        ]);

        if ($validator->passes()) {
            $division = Division::findOrFail($id);
            $division->name = $request->name;
            $division->save();
            return redirect()->route('divisions.index')->with('success', 'Division updated successfully');
        } else {
            return redirect()->route('divisions.edit', $id)->withInput()->withErrors($validator);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $division = Division::findOrFail($id);
        $division->delete();
        return redirect()->route('divisions.index')->with('success', 'Division deleted successfully');
    }
}
