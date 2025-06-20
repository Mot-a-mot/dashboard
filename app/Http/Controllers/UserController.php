<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Niveau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // List all users
    public function index(Request $request)
    {
        $query = User::with('currentNiveau');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $users = $query->paginate(10);
        return view('users.index', compact('users'))->with('search', $request->search);
    }

    // Show form to create a new user
    public function create()
    {
        $niveaux = Niveau::orderBy('order')->get();
        return view('users.create', compact('niveaux'));
    }

    // Store new user
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'current_niveau_id' => 'nullable|exists:niveaux,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'current_niveau_id' => $request->current_niveau_id,
        ]);

        return redirect()->route('users.index')->with('success', 'Utilisateur ajouté avec succès.');
    }

    // Show form to edit a user
    public function edit(User $user)
    {
        $niveaux = Niveau::orderBy('order')->get();
        return view('users.edit', compact('user', 'niveaux'));
    }

    // Update user
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'current_niveau_id' => 'nullable|exists:niveaux,id',
        ]);

        $data = $request->only('name', 'email', 'current_niveau_id');
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    // Delete user
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé.');
    }
}
