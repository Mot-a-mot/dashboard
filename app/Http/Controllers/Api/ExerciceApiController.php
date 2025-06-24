<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exercice;
use App\Models\Niveau;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Codewithkyrian\Whisper\Whisper;
use App\Jobs\TranscribeProcess;






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
   public function analyze(Request $request)
    {
        $request->validate([
            // 'audio' => 'required|file|mimetypes:audio/mpeg,audio/wav,audio/x-wav,audio/x-m4a,audio/mp4,audio/aac',
            'exercice_id' => 'required|exists:exercices,id',
        ]);

        $user = Auth::user();
        $file = $request->file('audio');
        $path = $file->store('audio_uploads');

        // 1️⃣ Get expected text from Exercice
        $exercice = Exercice::findOrFail($request->exercice_id);
        $expectedText = $exercice->description;
        TranscribeProcess::dispatch(Storage::path($path));
        // 2️⃣ Convert audio to text via speech-to-text API
        // $audioText = $this->speechToText(Storage::path($path));

        // 3️⃣ Ask ChatGPT for feedback
        // $feedback = $this->askChatGPT($audioText, $expectedText);

        // // 4️⃣ Compute similarity score
        // similar_text(strtolower($audioText), strtolower($expectedText), $percent);
        // $score = round($percent);
        // $level = $score >= 90 ? 5 : ($score >= 75 ? 4 : 3);
        // $isPassed = $score >= 75;

        // // 5️⃣ Save UserExerciseAttempt
        // $attempt = UserExerciseAttempt::create([
        //     'user_id'      => $user->id,
        //     'exercice_id'  => $exercice->id,
        //     'score'        => $score,
        //     'is_passed'    => $isPassed,
        //     'note'         => $feedback,
        //     'submitted_at' => now(),
        // ]);

        // // 6️⃣ Return response
        // return response()->json([
        //     'transcript'      => $audioText,
        //     'score'           => $score,
        //     'level'           => $level,
        //     'feedbackMessage' => $feedback,
        //     'attempt_id'      => $attempt->id,
        // ]);
        return response()->json([
            'message' => 'Analyse en cours. Veuillez vérifier plus tard.',
            // 'audio_text' => $audioText,
            // 'expected_text' => $expectedText,
        ]);
    }
    
    
    protected function speechToText(string $filePath): string
    {
        // Initialize Whisper with binary and model paths from .env
        $whisper = new Whisper(
            binaryPath: env('WHISPER_BINARY_PATH'),
            modelPath: env('WHISPER_MODEL_PATH')
        );

        try {
            // Transcribe the audio file
            $transcription = $whisper->transcribe($filePath, language: 'fr');
            return $transcription ?? '';
        } catch (\Throwable $e) {
            \Log::error('Whisper transcription failed', ['error' => $e->getMessage(), 'file' => $filePath]);
            throw new \Exception('Erreur Whisper: ' . $e->getMessage());
        }
    }

    protected function askChatGPT(string $heard, string $expected): string
    {
        $response = Http::withToken(config('services.openai.key'))
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4',
                'messages' => [
                    ['role' => 'system', 'content' => 'Tu es un correcteur de prononciation en français.'],
                    ['role' => 'user', 'content' => "Texte attendu : « $expected ».\nTexte prononcé : « $heard ». Donne un retour constructif en une phrase."],
                ],
                'temperature' => 0.5,
                'max_tokens' => 60,
            ]);

        if (!$response->ok()) {
            throw new \Exception('Erreur GPT-API');
        }

        return trim($response->json('choices.0.message.content'));
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
