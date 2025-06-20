<?php

namespace App\Http\Controllers;

use App\Models\Exercice;
use App\Models\Niveau;
use Illuminate\Http\Request;

class ExerciceController extends Controller
{
    // List all exercises
    public function index()
    {
        $exercices = Exercice::with('niveau')->latest()->get();
        return view('exercices.index', compact('exercices'));
    }

    // Show form to create a new exercise
    public function create()
    {
        $niveaux = Niveau::orderBy('order')->get();
        return view('exercices.create', compact('niveaux'));
    }

    // Store a new exercise
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'niveau_id' => 'required|exists:niveaux,id',
            'is_active' => 'required|boolean',
        ]);

        Exercice::create($request->all());

        return redirect()->route('exercices.index')->with('success', 'Exercice ajouté avec succès.');
    }

    // Display a specific exercise
    public function show(Exercice $exercice)
    {
        return view('exercices.show', compact('exercice'));
    }
    public function byNiveau(Request $request)
    {
        $niveauId = $request->query('niveau_id');

        $niveau = Niveau::findOrFail($niveauId);
        $exercices = Exercice::where('niveau_id', $niveauId)->latest()->get();
        $niveaux = Niveau::orderBy('order')->get(); // ✅ Add this line

        return view('exercices.index', compact('exercices', 'niveau', 'niveaux'));
    }


    // Show form to edit an existing exercise
    public function edit(Exercice $exercice)
    {
        $niveaux = Niveau::orderBy('order')->get();
        return view('exercices.edit', compact('exercice', 'niveaux'));
    }

    // Update an existing exercise
    public function update(Request $request, Exercice $exercice)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'niveau_id' => 'required|exists:niveaux,id',
            'is_active' => 'required|boolean',
        ]);

        $exercice->update($request->all());

        return redirect()->route('exercices.index')->with('success', 'Exercice mis à jour avec succès.');
    }

    // Delete an exercise
    public function destroy(Exercice $exercice)
    {
        $exercice->delete();

        return redirect()->route('exercices.index')->with('success', 'Exercice supprimé avec succès.');
    }
}
