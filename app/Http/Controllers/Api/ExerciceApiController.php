<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exercice;
use App\Models\Niveau;
use Illuminate\Http\Request;

class ExerciceApiController extends Controller
{
    // GET /api/exercices
    public function index()
    {
        $exercices = Exercice::with('niveau')->latest()->get();
        return response()->json($exercices);
    }

    // GET /api/exercices/{id}
    public function show($id)
    {
        $exercice = Exercice::with('niveau')->find($id);

        if (!$exercice) {
            return response()->json(['message' => 'Exercice non trouvé.'], 404);
        }

        return response()->json($exercice);
    }

    // GET /api/exercices/by-niveau?niveau_id=1
    public function byNiveau(Request $request)
    {
        $niveauId = $request->query('niveau_id');

        $niveau = Niveau::find($niveauId);

        if (!$niveau) {
            return response()->json(['message' => 'Niveau non trouvé.'], 404);
        }

        $exercices = Exercice::where('niveau_id', $niveauId)
            ->where('is_active', true)
            ->latest()
            ->get();

        return response()->json([
            'niveau' => $niveau,
            'exercices' => $exercices
        ]);
    }

    // POST /api/exercices
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'niveau_id' => 'required|exists:niveaux,id',
            'is_active' => 'required|boolean',
        ]);

        $exercice = Exercice::create($validated);

        return response()->json([
            'message' => 'Exercice créé avec succès.',
            'exercice' => $exercice
        ], 201);
    }

    // PUT /api/exercices/{id}
    public function update(Request $request, $id)
    {
        $exercice = Exercice::find($id);

        if (!$exercice) {
            return response()->json(['message' => 'Exercice non trouvé.'], 404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'niveau_id' => 'required|exists:niveaux,id',
            'is_active' => 'required|boolean',
        ]);

        $exercice->update($validated);

        return response()->json([
            'message' => 'Exercice mis à jour avec succès.',
            'exercice' => $exercice
        ]);
    }

    // DELETE /api/exercices/{id}
    public function destroy($id)
    {
        $exercice = Exercice::find($id);

        if (!$exercice) {
            return response()->json(['message' => 'Exercice non trouvé.'], 404);
        }

        $exercice->delete();

        return response()->json(['message' => 'Exercice supprimé avec succès.']);
    }
}
