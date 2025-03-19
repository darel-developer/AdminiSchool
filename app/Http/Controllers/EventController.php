<?php




namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;



class EventController extends Controller
{
    public function create()
    {
        return view('createevent');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'event_date' => 'required|date',
            'event_time' => 'required|date_format:H:i',
            'class' => 'required|string|max:255',
        ]);

        Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'event_date' => $request->event_date,
            'event_time' => $request->event_time,
            'class' => $request->class,
        ]);

        return redirect()->back()->with('success', 'Événement créé avec succès!');
    }
}