<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    public function details()
    {
        $absences = Student::where('absences', '>', 0)->get();
        return view('absences.details', ['absences' => $absences]);
    }
}