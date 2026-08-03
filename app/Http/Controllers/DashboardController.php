<?php

namespace App\Http\Controllers;

use App\Models\Info;

class DashboardController extends Controller
{
    public function index()
    {
        // Total count of students
        $totalStudents = Info::where('choice', 'student')->count();

        // Total count of teachers
        $totalTeachers = Info::where('choice', 'teacher')->count();

        // Enrollments summary count (total overall registered records in Info table)
        $totalEnrollments = Info::count();

        // Recent student registrations / enrollments summary list
        $recentEnrollments = Info::latest()->take(5)->get();

        return view('pages.dashboard', compact(
            'totalStudents', 
            'totalTeachers', 
            'totalEnrollments', 
            'recentEnrollments'
        ));
    }
}