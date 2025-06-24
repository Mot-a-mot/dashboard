<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Niveau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserApiController extends Controller
{
    // Get all users (with pagination and optional search)
    public function index(Request $request)
    {
        $query = User::with('currentNiveau');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $users = $query->paginate(10);

        return response()->json([
            'success' => true,
            'users' => $users
        ]);
    }

    // Store new user
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'current_niveau_id' => 'nullable|exists:niveaux,id',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'current_niveau_id' => $validated['current_niveau_id'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Utilisateur créé avec succès',
            'user' => $user
        ], 201);
    }

    // Show single user
    public function show($id)
    {
        $user = User::with('currentNiveau')->findOrFail($id);

        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }

    // Update user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'current_niveau_id' => 'nullable|exists:niveaux,id',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'current_niveau_id' => $validated['current_niveau_id'] ?? null,
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Utilisateur mis à jour avec succès',
            'user' => $user
        ]);
    }

    // Delete user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Utilisateur supprimé avec succès'
        ]);
    }

    // Get current user's level (authenticated)
    public function getUserLevel(Request $request)
    {
        $user = $request->user()->load('currentNiveau');

        if (!$user->currentNiveau) {
            return response()->json([
                'success' => false,
                'message' => 'Aucun niveau assigné à cet utilisateur.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'niveau' => $user->currentNiveau
        ]);
    }
}
