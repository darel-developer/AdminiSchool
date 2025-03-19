<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Planning;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PlanningsImport;

class PlanningController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'planningFile' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        Excel::import(new PlanningsImport, $request->file('planningFile'));

        return redirect()->back()->with('success', 'Planning téléversé avec succès!');
    }
}