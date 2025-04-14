<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $studentCount = Student::count();
        $convocationCount = Student::sum('convocations');
        $absenceCount = Student::sum('absences');

        return view('dashboard', [
            'studentCount' => $studentCount,
            'convocationCount' => $convocationCount,
            'absenceCount' => $absenceCount,
        ]);
    }
}