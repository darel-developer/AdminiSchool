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
        $documents = Document::all(); // Récupération de tous les documents
        return view('documentschool', compact('documents')); // Transmission à la vue
    }

    
    public function uploadDocument(Request $request)
    {
        $request->validate([
            'documentfile' => 'required|mimes:pdf|max:2048',
            'type' => 'required|string|max:255',
        ]);

    $type = $request->input('type');
    if ($type === 'autre') {
        $type = $request->input('custom_type'); 
    }

    // Store the uploaded file and get its path
    $filePath = $request->file('documentfile')->store('documents', 'public');

    Document::create([
        'tuteur_id' => Auth::guard('tuteur')->id(),
        'file_path' => $filePath,
        'type' => $type,
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