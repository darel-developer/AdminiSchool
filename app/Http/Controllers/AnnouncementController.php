<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\Tuteur;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;

class AnnouncementController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        $announcement = Announcement::create([
            'title' => $request->title,
            'message' => $request->message,
        ]);

        // Envoyer une notification à tous les parents
        $parents = Tuteur::all();
        foreach ($parents as $parent) {
            Notification::create([
                'tuteur_id' => $parent->id,
                'title' => $announcement->title,
                'message' => $announcement->message,
            ]);
        }

        Log::info("Annonce publiée et notifications envoyées à tous les parents.");

        return redirect()->back()->with('success', 'Annonce publiée et notifications envoyées à tous les parents !');
    }
}
