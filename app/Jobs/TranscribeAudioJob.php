<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Codewithkyrian\Whisper\Whisper;
use Codewithkyrian\Whisper\WhisperFullParams;
use App\Models\Niveau;
use App\Models\User;
use App\Models\Transcription;

class TranscribeAudioJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $aacPath;
    public int $userId;

    public function __construct(string $aacPath, int $userId)
    {
        $this->aacPath = $aacPath;
        $this->userId  = $userId;
    }

    public function handle(): void
    {
        $absolutePath = Storage::path($this->aacPath);

        // ✅ Convert AAC to WAV using FFmpeg
        $wavPath  = preg_replace('/\.[^.]+$/', '.wav', $absolutePath);
        $command  = "ffmpeg -y -i " . escapeshellarg($absolutePath) . " -ar 16000 -ac 1 " . escapeshellarg($wavPath);
        exec($command);

        if (!file_exists($wavPath)) {
            return; // abort silently or log
        }

        // WHISPER transcription
        putenv('WHISPER_CPP_LIB=' . base_path('vendor/codewithkyrian/whisper.php/lib/windows-x86_64/libwhisper.dll'));
        $params   = WhisperFullParams::default()->withLanguage('fr')->withNThreads(4);
        $whisper  = Whisper::fromPretrained('tiny');
        $result   = $whisper->transcribe($wavPath, 6);
        $heard    = $result[0]->text ?? '';

        // GPT feedback
        $feedback = "Votre prononciation est correcte, mais essayez de mieux articuler les mots 'cheval' et 'herbe'.";

        // Calcul du score (basé sur similarité de texte) – exemple simulé
        $score = 100;
        $niveau = Niveau::where('name', 'A1')->first();

        // Mise à jour du niveau de l'utilisateur
        $user = User::find($this->userId);
        if ($user && $niveau) {
            $user->current_niveau_id = $niveau->id;
            $user->save();
        }

        // 📝 Enregistrement du résultat dans la table `transcriptions`
        try {
            \Log::info("Création transcription pour l'utilisateur ID = {$this->userId}");

          Transcription::create([
                'user_id'    => $this->userId,
                'transcript' => $heard,
                'feedback'   => $feedback,
                'level'      => $niveau?->name,
                'score'      => $score,
                'done'       => true,
            ]);

            \Log::info("✅ Transcription enregistrée avec succès.");
        } catch (\Throwable $e) {
            \Log::error("❌ Échec de la création de la transcription : " . $e->getMessage());
        }

        // Nettoyage
        @unlink($absolutePath);
        @unlink($wavPath);
    }
}
