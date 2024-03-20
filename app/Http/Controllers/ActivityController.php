<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController
{
    public function index()
    {
        $activity = Activity::latest()->get();
        return view('activity', compact('activity'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'add' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        Activity::create($validatedData);

        return redirect()->route('activity.index')
            ->with('success', 'Activity added successfully.');
    }

    public function delete($id)
    {
        $activity = Activity::findOrFail($id);
        $activity->delete();
        return redirect()->back()->with('success', 'Activity deleted successfully');
    }
}