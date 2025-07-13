<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Grades; // Ajoutez cette ligne

class SyncController extends Controller
{
    public function sync(Request $request)
    {
        $request->validate([
            'actions' => 'required|array',
            'actions.*.type' => 'required|string',
            'actions.*.data' => 'required|array'
        ]);

        $results = [];

        foreach ($request->input('actions') as $action) {
            try {
                switch ($action['type']) {
                    case 'create_note':
                        $note = Grades::create($action['data']);
                        $results[] = [
                            'id' => $action['id'] ?? null,
                            'status' => 'success',
                            'server_id' => $note->id
                        ];
                        break;
                    
                    // Ajoutez d'autres cas ici
                    
                    default:
                        throw new \Exception("Action type not supported");
                }
            } catch (\Exception $e) {
                $results[] = [
                    'id' => $action['id'] ?? null,
                    'status' => 'error',
                    'message' => $e->getMessage()
                ];
            }
        }

        return response()->json(compact('results'));
    }
}