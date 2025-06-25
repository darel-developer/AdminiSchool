<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;

class SchoolController extends Controller
{
    public function ajouter_school_traitement(Request $request)
    {
        $request->validate([
            'schoolName' => 'required',
            'username' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $school = new School();
        $school->name = $request->schoolName;
        $school->email = $request->username;
        $school->password = bcrypt($request->password);
        $school->type = 'school';
        $school->save();

        return redirect('login')->with('success', 'School ajouté avec succès');
    }

    public function index()
    {
        $classes = \App\Models\Classe::all();
        return view('school', compact('classes'));
    }
}