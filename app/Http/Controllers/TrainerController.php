<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainerController extends Controller
{
    public function index()
    {
        $query = Trainer::with('district', 'creator');

        if (!Auth::user()->hasRole('superadmin')) {
            $query->where('created_by', Auth::id());
        }

        $trainers = $query->latest()->get();

        return view('backend.trainers.index', compact('trainers'));
    }


    public function create()
    {
        return view('backend.trainers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'nullable|email|unique:trainers,email',
            'phone' => 'nullable|string|max:20',
            'image' => 'nullable|image|max:2048',
        ]);

        $trainer = new Trainer();
        $trainer->name  = $request->name;
        $trainer->email = $request->email;
        $trainer->phone = $request->phone;
        $trainer->image = $request->image;

        if ($request->hasFile('image')) {
            $trainer->image = ImageHelper::upload($request->file('image'), 'trainers');
        } else {
            $trainer->image = null;
        }

        $trainer->district_id = Auth::user()->districts->first()->id ?? null;
        $trainer->created_by = Auth::id();
        $trainer->save();

        return redirect()->route('trainers.index')->with('success', 'Trainer created successfully.');
    }


    public function edit(Trainer $trainer)
    {
        return view('backend.trainers.edit', compact('trainer'));
    }



    public function update(Request $request, Trainer $trainer)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'nullable|email|unique:trainers,email,' . $trainer->id,
            'phone' => 'nullable|string|max:20',
            'image' => 'nullable|image|max:2048',
        ]);

        $trainer->name  = $request->name;
        $trainer->email = $request->email;
        $trainer->phone = $request->phone;

        if ($request->hasFile('image')) {
            $trainer->image = ImageHelper::update($request->file('image'), $trainer->image, 'trainers');
        }

        $trainer->save();

        return redirect()->route('trainers.index')->with('success', 'Trainer updated successfully.');
    }


    public function destroy(Trainer $trainer)
    {
        // Delete associated image
        ImageHelper::delete($trainer->image);

        $trainer->delete();

        return redirect()->route('trainers.index')->with('success', 'Trainer deleted successfully.');
    }
}
