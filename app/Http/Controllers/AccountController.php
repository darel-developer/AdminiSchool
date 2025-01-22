<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tuteur; 
use App\Models\School; 
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'accountType' => 'required|in:parent,school',
            'firstName' => 'required_if:accountType,parent|string|max:255',
            'secondName' => 'required_if:accountType,parent|string|max:255',
            'childName' => 'required_if:accountType,parent|string|max:255',
            'schoolName' => 'required|string|max:255',
            'username' => 'required|string|email|unique:tuteurs,username',  // Correction ici
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        
        if ($request->accountType === 'parent') {
            $tuteur = new Tuteur();
            $tuteur->firstName = $request->firstName;
            $tuteur->lastName = $request->lastName;
            $tuteur->childName = $request->childName;
            $tuteur->schoolName = $request->schoolName;
            $tuteur->username = $request->username;
            $tuteur->password = Hash::make($request->password);
            $tuteur->save();
            
            return back()->with('status', 'Parent account created successfully!');
        } elseif ($request->accountType === 'school') {
            $school = new School();
            $school->schoolName = $request->schoolName;
            $school->username = $request->username;
            $school->password = Hash::make($request->password);
            $school->save();
    
            // Retourner la vue avec un message et les écoles
            return back()->with('status', 'School account created successfully!')->with('schools', $schools);
        }
    
        // Toujours retourner la vue avec les écoles si aucune condition n'est remplie
        return view('register', ['schools' => $schools]);
    }
    
    
}
