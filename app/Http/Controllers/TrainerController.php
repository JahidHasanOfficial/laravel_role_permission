<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainerController extends Controller
{
  public function index()
{
    $query = Trainer::with('district', 'creator');

    if (!Auth::user()->hasRole('superadmin')) {
        // Non-Super Admin শুধু তাদের নিজস্ব trainer দেখবে
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
    ]);

    $trainer = new Trainer();
    $trainer->name  = $request->name;
    $trainer->email = $request->email;
    $trainer->phone = $request->phone;

    // user er district auto nibe
    $trainer->district_id = Auth::user()->districts->first()->id ?? null;

    // কে create করছে সেটাও save হবে
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
        ]);

        $trainer->update($request->only(['name', 'email', 'phone']));

        return redirect()->route('trainers.index')->with('success', 'Trainer updated successfully.');
    }

    public function destroy(Trainer $trainer)
    {
        $trainer->delete();

        return redirect()->route('trainers.index')->with('success', 'Trainer deleted successfully.');
    }
}
