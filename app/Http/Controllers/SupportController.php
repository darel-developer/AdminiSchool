<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SupportController extends Controller
{
    public function index()
    {
        return view('helpsupport');
    }

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        // Logique pour envoyer le message à l'équipe technique
        // Vous pouvez utiliser Mail::send() pour envoyer un email

        return back()->with('success', 'Votre message a été envoyé avec succès.');
    }
}