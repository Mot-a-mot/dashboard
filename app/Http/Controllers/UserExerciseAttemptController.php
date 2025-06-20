<?php

namespace App\Http\Controllers;

use App\Models\UserExerciseAttempt;
use App\Models\User;
use App\Models\Exercice;
use Illuminate\Http\Request;

class UserExerciseAttemptController extends Controller
{
    // ✅ List all attempts
    public function index()
    {
        $attempts = UserExerciseAttempt::with(['user', 'exercice'])->get();
        return view('userExerciseAttempts.index', compact('attempts'));
    }

    // ✅ Show a single attempt
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'exercice_id' => 'required|exists:exercices,id',
            'score' => 'required|numeric',
            'is_passed' => 'required|boolean',
            'note' => 'nullable|string',
            'submitted_at' => 'required|date',
        ]);

        UserExerciseAttempt::create($validated);

        return redirect()->route('userExerciseAttempts.index')->with('success', 'Tentative enregistrée avec succès.');
    }

    // ✅ Show one attempt (optional)
    public function show($id)
    {
        $attempt = UserExerciseAttempt::with(['user', 'exercice'])->findOrFail($id);
        return view('user-exercise-attempts.show', compact('attempt'));
    }

    // ✅ Show edit form
    public function edit($id)
    {
        $attempt = UserExerciseAttempt::findOrFail($id);
        $users = User::all();
        $exercices = Exercice::all();
        return view('user-exercise-attempts.edit', compact('attempt', 'users', 'exercices'));
    }

    // ✅ Update existing attempt
    public function update(Request $request, $id)
    {
        $attempt = UserExerciseAttempt::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'exercice_id' => 'required|exists:exercices,id',
            'score' => 'required|numeric',
            'is_passed' => 'required|boolean',
            'note' => 'nullable|string',
            'submitted_at' => 'required|date',
        ]);

        $attempt->update($validated);

        return redirect()->route('userExerciseAttempts.index')->with('success', 'Tentative mise à jour avec succès.');
    }

    // ✅ Delete attempt
    public function destroy($id)
    {
        $attempt = UserExerciseAttempt::findOrFail($id);
        $attempt->delete();

        return redirect()->route('userExerciseAttempts.index')->with('success', 'Tentative supprimée avec succès.');
    }
    public function create()
    {
        return view('userExerciseAttempts.create', [
            'users' => User::all(),
            'exercices' => Exercice::all(),
        ]);
    }
    // ✅ Create a new attempt
}
