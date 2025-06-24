<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AudioAnalysisController extends Controller
{
    public function analyze(Request $request)
    {
        $request->validate([
            'audio' => 'required|file|mimes:aac,mp3,wav,m4a',
            'expectedText' => 'required|string'
        ]);

        $file = $request->file('audio');
        $path = $file->store('audio_uploads');

        // Analyse fictive – à remplacer par un vrai système (ex : Python, API IA, etc.)
        $score = rand(50, 100); // Score fictif
        $level = $score >= 90 ? 5 : ($score >= 75 ? 4 : 3);
        $feedback = "Analyse réussie. Le texte est bien prononcé.";

        return response()->json([
            'level' => $level,
            'score' => $score,
            'feedbackMessage' => $feedback,
        ]);
    }
}
