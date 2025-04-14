<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class ConvocationController extends Controller
{
    public function details()
    {
        $convocations = Student::where('convocations', '>', 0)->get();
        return view('convocations.details', ['convocations' => $convocations]);
    }
}