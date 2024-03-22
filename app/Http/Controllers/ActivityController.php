<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController
{
    public function index(Request $request)
    {
        $selectedDate = $request->input('date', now()->format('Y-m-d'));
        $activity = Activity::whereDate('date', $selectedDate)->orderBy('date', 'asc')->get();
        return view('activity', compact('activity', 'selectedDate'));
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

    public function update(Request $request, $id)
    {
    $validatedData = $request->validate([
        'add' => 'required|string|max:255',
        'date' => 'required|date',
    ]);

    $activity = Activity::findOrFail($id);
    $activity->update($validatedData);

    return redirect()->route('activity.index')->with('success', 'Activity updated successfully.');
    }

    public function Completed(Request $request, $id)
    {
        $activity = Activity::findOrFail($id);
        $activity->status = $request->input('completed') === '1';
        $activity->save();

        return redirect()->route('activity.index');
    }

}