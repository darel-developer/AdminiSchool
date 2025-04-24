<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FichierController extends Controller
{

    public function index()
    {
        $documents = Document::all();
        return view('documentschool', compact('documents'));
    }

    
    public function uploadDocument(Request $request)
    {
        $request->validate([
            'documentfile' => 'required|mimes:pdf|max:2048',
        ]);

        $file = $request->file('documentfile');
        $filePath = $file->store('documents', 'public');

        Document::create([
            'tuteur_id' => Auth::guard('tuteur')->id(),
            'file_path' => $filePath,
        ]);

        return back()->with('success', 'Document téléversé avec succès.');
    }

    public function viewDocument($id)
    {
        $document = Document::findOrFail($id);
        return response()->file(storage_path('app/public/' . $document->file_path));
    }

    public function downloadDocument($id)
    {
        $document = Document::findOrFail($id);
        return response()->download(storage_path('app/public/' . $document->file_path));
    }
}