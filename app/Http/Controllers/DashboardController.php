<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Niveau;
use App\Models\Exercice;
use App\Models\UserExerciseAttempt;


class DashboardController extends Controller
{
    public function show()
    {
        $totalUsers = User::count();

        $usersInGroupA = User::whereHas('currentNiveau', function ($query) {
            $query->whereIn('name', ['A1', 'A2']);
        })->count();

        $usersInGroupB = User::whereHas('currentNiveau', function ($query) {
            $query->whereIn('name', ['B1', 'B2']);
        })->count();

        $usersInGroupC = User::whereHas('currentNiveau', function ($query) {
            $query->whereIn('name', ['C1', 'C2']);
        })->count();
        $totalExercises = Exercice::count();

        $successfulAttempts = UserExerciseAttempt::where('is_successful', true)->count();
        $failedAttempts = UserExerciseAttempt::where('is_successful', false)->count();
        $totalAttempts = $successfulAttempts + $failedAttempts;
         $successRate = $totalAttempts > 0 ? round(($successfulAttempts / $totalAttempts) * 100, 2) : 0;
        $failureRate = $totalAttempts > 0 ? round(($failedAttempts / $totalAttempts) * 100, 2) : 0;
            $niveaux = Niveau::withCount(['users'])->get();

        // Add stats for each niveau
        $niveaux = $niveaux->map(function ($niveau) {
            $totalAttempts = UserExerciseAttempt::whereHas('user', function ($q) use ($niveau) {
                $q->where('current_niveau_id', $niveau->id);
            })->count();

            $successfulAttempts = UserExerciseAttempt::whereHas('user', function ($q) use ($niveau) {
                $q->where('current_niveau_id', $niveau->id);
            })->where('is_successful', true)->count();

            $successRate = $totalAttempts > 0 ? round(($successfulAttempts / $totalAttempts) * 100) : 0;

            $niveau->total_attempts = $totalAttempts;
            $niveau->success_rate = $successRate;

            return $niveau;
        });
        return view('dashboard', compact(
            'totalUsers',
            'usersInGroupA',
            'usersInGroupB',
            'usersInGroupC',
            'totalExercises',
            'successfulAttempts',
            'failedAttempts',
            'successRate',
            'failureRate',
            'niveaux'
        ));
    }
}
