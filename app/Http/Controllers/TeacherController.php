<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Teacher::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }

        $teachers = $query->latest()->paginate(10);

        return view('teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:teachers,email',
            'subject' => 'required|string|max:255',
            'phone'   => 'nullable|string|max:20',
        ]);

        Teacher::create($validated);

        return redirect()->route('teachers.index')->with('success', 'Teacher added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Teacher $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Teacher $teacher)
    {
        return view('teachers.edit', compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:teachers,email,' . $teacher->id,
            'subject' => 'required|string|max:255',
            'phone'   => 'nullable|string|max:20',
        ]);

        $teacher->update($validated);

        return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Teacher $teacher)
    {
        $teacher->delete();

        return redirect()->route('teachers.index')->with('success', 'Teacher deleted successfully.');
    }

}
