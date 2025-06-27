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
use Codewithkyrian\Whisper\WhisperFullParams;
use App\Jobs\TranscribeProcess;
use App\Jobs\AnalyzeAudioJob;
use App\Models\UserExerciseAttempt;






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

        $user = $request->user(); // Authenticated user

        $exercices = Exercice::where('niveau_id', $niveauId)
            ->where('is_active', true)
            ->latest()
            ->get()
            ->map(function ($exercice) use ($user) {
                // find the latest attempt for this user/exercice
                $attempt = $exercice->userExerciseAttempts()
                            ->where('user_id', $user->id)
                            ->orderByDesc('submitted_at')
                            ->first();

                return [
                    'id' => $exercice->id,
                    'title' => $exercice->title,
                    'description' => $exercice->description,
                    'niveau_id' => $exercice->niveau_id,
                    'is_active' => $exercice->is_active,
                    'created_at' => $exercice->created_at,
                    'updated_at' => $exercice->updated_at,
                    'is_passed' => $attempt?->is_passed ?? false, // status
                ];
            });

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
            'audio' => 'required',
            'exercice_id' => 'required|exists:exercices,id',
        ]);

        $file = $request->file('audio');
        $path = $file->store('audio_uploads');

        $userId     = Auth::id();
        $exerciceId = $request->exercice_id;
         // Simple score logic (you can improve this)
            // similar_text(strtolower($heard), strtolower($expected), $percent);
            // $score = round($percent, 2);
            // $level = $score >= 85 ? 'B2' : ($score >= 60 ? 'A2' : 'A1');
            // $isPassed = $score >= 60;
        AnalyzeAudioJob::dispatch($path, $userId, $exerciceId);

        return response()->json([
            'message' => 'Votre audio est en cours de traitement.',
        ]);
    }

    public function getResultatAnalyse(Request $request)
    {
        $request->validate([
            'exercice_id' => 'required|exists:exercices,id',
        ]);

        $user = Auth::user();

        // on récupère le dernier attempt de CE user sur CE exercice
        $attempt = UserExerciseAttempt::where('user_id', $user->id)
            ->where('exercice_id', $request->exercice_id)
            ->orderByDesc('submitted_at')
            ->first();

        if (!$attempt) {
            return response()->json([
                'message' => 'Aucun résultat trouvé'
            ], 404);
        }

        return response()->json($attempt);
    }

    // public function analyze(Request $request)
    // {
    //     try {
    //         $request->validate([
    //             'audio' => 'required',
    //             'exercice_id' => 'required|exists:exercices,id',
    //         ]);

    //         $file = $request->file('audio');
    //         $path = $file->store('audio_uploads');
    //         $absolutePath = Storage::path($path);

    //         // Load expected text from Exercice
    //         $exercice = Exercice::findOrFail($request->exercice_id);
    //         $expected = $exercice->content;

    //         // Load Whisper
    //         putenv('WHISPER_CPP_LIB=' . base_path('vendor/codewithkyrian/whisper.php/lib/windows-x86_64/libwhisper.dll')); // Windows
    //         $params = \Codewithkyrian\Whisper\WhisperFullParams::default()
    //             ->withLanguage('fr')
    //             ->withNThreads(4);

    //         $whisper = \Codewithkyrian\Whisper\Whisper::fromPretrained('tiny');
    //         $result = $whisper->transcribe($absolutePath, 6);
    //         $heard = $result[0]->text;

    //         // Ask ChatGPT for feedback
    //         // $feedback = $this->askChatGPT($heard, $expected);
    //         $feedback = "Votre prononciation est correcte, mais essayez de mieux articuler les mots 'cheval' et 'herbe'.";
    //         // Simple score logic (you can improve this)
    //         // similar_text(strtolower($heard), strtolower($expected), $percent);
    //         // $score = round($percent, 2);
    //         // $level = $score >= 85 ? 'B2' : ($score >= 60 ? 'A2' : 'A1');
    //         // $isPassed = $score >= 60;
    //         $score = 100; // Simuler un score parfait pour le test
    //         $level = 'A1'; // Simuler un niveau pour le test
    //         $isPassed = true; // Simuler un passage pour le test
    //         // Save attempt
    //         $attempt = UserExerciseAttempt::create([
    //             'user_id' => Auth::id(),
    //             'exercice_id' => $exercice->id,
    //             'score' => $score,
    //             'is_passed' => $isPassed,
    //             'note' => $feedback,
    //             'submitted_at' => now(),
    //         ]);

    //         return response()->json([
    //             'transcript' => $heard,
    //             'level' => $level,
    //             'score' => $score,
    //             'feedbackMessage' => $feedback,
    //         ]);

    //     } catch (\Throwable $e) {
    //         return response()->json([
    //             'error' => 'Une erreur est survenue pendant l\'analyse audio.',
    //             'message' => $e->getMessage(),
    //         ], 500);
    //     }
    // }

    
    
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
