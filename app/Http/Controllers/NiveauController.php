<?php

namespace App\Http\Controllers;

use App\Models\Niveau;
use Illuminate\Http\Request;

class NiveauController extends Controller
{
    // Display all niveaux
    public function index()
    {
        $niveaux = Niveau::orderBy('order')->get();
        return view('niveaux.index', compact('niveaux'));
    }

    // Show form to create a new niveau
    public function create()
    {
        return view('niveaux.create');
    }

    // Store a new niveau
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:10',
            'order' => 'required|integer|unique:niveaux,order',
        ]);

        Niveau::create($request->all());

        return redirect()->route('niveaux.index')->with('success', 'Niveau ajouté avec succès.');
    }

    // Show a specific niveau
    public function show(Niveau $niveau)
    {
        return view('niveaux.show', compact('niveau'));
    }

    // Show form to edit an existing niveau
    public function edit(Niveau $niveau)
    {
        return view('niveaux.edit', compact('niveau'));
    }

    // Update the niveau
    public function update(Request $request, Niveau $niveau)
    {
        $request->validate([
            'name' => 'required|string|max:10',
            'order' => 'required|integer|unique:niveaux,order,' . $niveau->id,
        ]);

        $niveau->update($request->all());

        return redirect()->route('niveaux.index')->with('success', 'Niveau mis à jour avec succès.');
    }

    // Delete the niveau
    public function destroy(Niveau $niveau)
    {
        $niveau->delete();

        return redirect()->route('niveaux.index')->with('success', 'Niveau supprimé avec succès.');
    }
}
