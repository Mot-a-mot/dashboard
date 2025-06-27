<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Codewithkyrian\Whisper\Whisper;
use Codewithkyrian\Whisper\WhisperFullParams;
use App\Models\Exercice;
use App\Models\UserExerciseAttempt;

class AnalyzeAudioJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $audioPath;
    public int $userId;
    public int $exerciceId;

    public function __construct(string $audioPath, int $userId, int $exerciceId)
    {
        $this->audioPath   = $audioPath;
        $this->userId      = $userId;
        $this->exerciceId  = $exerciceId;
    }

    public function handle(): void
    {
        try {
            $absolutePath = Storage::path($this->audioPath);

            Log::info("🔍 AnalyzeAudioJob started", [
                'user_id' => $this->userId,
                'exercice_id' => $this->exerciceId,
                'path' => $absolutePath
            ]);

            // convert AAC to WAV
            $wavPath = preg_replace('/\.[^.]+$/', '.wav', $absolutePath);
            $command = "ffmpeg -y -i " . escapeshellarg($absolutePath) . " -ar 16000 -ac 1 " . escapeshellarg($wavPath);
            exec($command);

            if (!file_exists($wavPath)) {
                Log::error("❌ FFmpeg conversion to WAV failed");
                return;
            }

            // get expected text from DB
            $exercice = Exercice::find($this->exerciceId);
            if (!$exercice) {
                Log::error("❌ Exercice not found ID={$this->exerciceId}");
                return;
            }

            $expected = $exercice->description ?? '';

            // whisper
            putenv('WHISPER_CPP_LIB=' . base_path('vendor/codewithkyrian/whisper.php/lib/windows-x86_64/libwhisper.dll'));

            $params = WhisperFullParams::default()
                ->withLanguage('fr')
                ->withNThreads(4);

            $whisper = Whisper::fromPretrained('tiny');

            $result = $whisper->transcribe($wavPath, 6);

            if (!$result || empty($result[0]->text)) {
                Log::error("❌ Whisper returned empty or null result");
                return;
            }

            $heard = $result[0]->text;
            Log::info("✅ Transcription done", ['heard' => $heard]);

            // simple scoring
            $feedback = "Votre prononciation est correcte, mais essayez de mieux articuler.";
            $score    = 100;
            $isPassed = true;

            UserExerciseAttempt::create([
                'user_id'      => $this->userId,
                'exercice_id'  => $this->exerciceId,
                'score'        => $score,
                'is_passed'    => $isPassed,
                'note'         => $feedback,
                'submitted_at' => now(),
            ]);

            Log::info("✅ UserExerciseAttempt saved", [
                'user_id' => $this->userId,
                'exercice_id' => $this->exerciceId,
                'score' => $score,
                'feedback' => $feedback
            ]);

            // cleanup
            @unlink($absolutePath);
            @unlink($wavPath);

        } catch (\Throwable $e) {
            Log::error("❌ AnalyzeAudioJob exception", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}
