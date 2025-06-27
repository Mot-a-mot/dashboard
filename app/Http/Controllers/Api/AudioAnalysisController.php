<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exercice;
use App\Models\Niveau;
use App\Models\Transcription;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Codewithkyrian\Whisper\Whisper;
use Codewithkyrian\Whisper\WhisperFullParams;
use App\Jobs\TranscribeAudioJob;

class AudioAnalysisController extends Controller
{
    public function testLevel(Request $request)
    {
        // try {
            $request->validate([
                'audio' => 'required',
            ]);

            $file = $request->file('audio');
            $path = $file->store('audio_uploads'); // Chemin stocké dans storage/app/…
            $absolutePath = Storage::path($path);

            // ✅ Convert AAC to WAV using FFmpeg           <-- gardé comme repère ; exécuté dans le Job
            // WHISPER transcription                       <-- gardé comme repère ; exécuté dans le Job
            // GPT feedback                                <-- gardé comme repère ; exécuté dans le Job
            // Calcul du score (basé sur similarité de texte)
            // Déduction du niveau
            // Mise à jour du niveau de l'utilisateur

            // ⏩ On délègue désormais tout ce bloc lourd au Job asynchrone
            TranscribeAudioJob::dispatch($path, Auth::id());

            return response()->json([
                'message' => 'Votre audio est en cours de traitement.',
            ]);

        // } catch (\Throwable $e) {
        //     return response()->json([
        //         'error' => 'Erreur lors de l’analyse audio.',
        //         'message' => $e->getMessage(),
        //     ], 500);
        // }
    }

    public function getResultatTranscription()
    {
        $user = Auth::user();

        $data = Transcription::where('user_id', $user->id)->first();

        if (!$data) {
            return response()->json(['message' => 'Aucun résultat'], 404);
        }

        return response()->json([
            'done' => $data->done,
            'transcript' => $data->transcript,
            'score' => $data->score,
            'level' => $data->level,
            'feedbackMessage' => $data->feedback,
        ]);
    }

    protected function askChatGPT(string $heard, string $expected): string
    {
        $response = Http::withToken(config('services.openai.key'))
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4',
                'messages' => [
                    ['role' => 'system', 'content' => 'Tu es un correcteur de prononciation en français.'],
                    ['role' => 'user', 'content' => "Texte attendu : « $expected ».\nTexte prononcé : « $heard ».\nDonne un retour constructif en une phrase."],
                ],
                'temperature' => 0.5,
                'max_tokens' => 60,
            ]);

        if (!$response->ok()) {
            throw new \Exception('Erreur GPT-API');
        }

        return trim($response->json('choices.0.message.content'));
    }
}
