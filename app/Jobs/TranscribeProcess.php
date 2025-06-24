<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Codewithkyrian\Whisper\Whisper;
use Codewithkyrian\Whisper\WhisperFullParams;
use Codewithkyrian\Whisper\AudioLoader;

class TranscribeProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 120;

    private string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function handle(): void
    {
        putenv('WHISPER_CPP_LIB=' . base_path('vendor/codewithkyrian/whisper.php/lib/windows-x86_64/libwhisper.dll'));

        $params = WhisperFullParams::default()
            ->withNThreads(4)
            ->withLanguage('fr');

        $whisper = Whisper::fromPretrained(
            'tiny.en',
            baseDir: config('services.whisper.models_directory'),
            params: $params
        );

        $audio = AudioLoader::readAudio($this->filePath);
        $segments = $whisper->transcribe($audio);
        $this->saveFile($segments);
    }


    private function saveFile(array $segments): void
    {
        $text = '';
        foreach ($segments as $segment) {
            $text .= $segment->text . ' ';
        }

        Storage::put('transcriptions/' . basename($this->filePath) . '.txt', trim($text));
    }
}
