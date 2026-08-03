<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
        {
        $query = Student::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('year_level', 'like', "%{$search}%");
        }

        $students = $query->latest()->paginate(10);

        return view('students.index', compact('students'));
        }

    // 2. Show form to create a new student
    public function create()
        {
        return view('students.create');
        }

    // 3. Save a new student to the database
    public function store(Request $request)
        {
        $validated = $request->validate([
            'first_name'  => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name'   => 'required|string|max:255',
            'year_level'  => 'required|string|max:100',
        ]);

        Student::create($validated);

        return redirect()->route('students.index')->with('success', 'Student added successfully.');
        }

    // 4. Show form to edit an existing student
    public function edit(Student $student)
        {
        return view('students.edit', compact('student'));
        }

    // 5. Update student details in the database
    public function update(Request $request, Student $student)
        {
        $validated = $request->validate([
            'first_name'  => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name'   => 'required|string|max:255',
            'year_level'  => 'required|string|max:100',
        ]);

        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
        }

    // 6. Delete a student from the database
    public function destroy(Student $student)
        {
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
        }
}

