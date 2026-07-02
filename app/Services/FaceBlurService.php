<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class FaceBlurService
{
    /**
     * Detect and blur faces in an image.
     *
     * @param string $photoPath Relative path to storage disk
     * @param string $disk Storage disk name
     * @return bool
     */
    public static function blur(string $photoPath, string $disk = 'public'): bool
    {
        try {
            $storageDisk = Storage::disk($disk);
            if (!$storageDisk->exists($photoPath)) {
                Log::warning("FaceBlurService: File does not exist: {$photoPath}");
                return false;
            }

            $fullPath = $storageDisk->path($photoPath);
            $extension = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));

            // Process only supported images
            if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])) {
                return false;
            }

            $scriptPath = app_path('Services/face_blur.py');

            // Invoke Python script using Symfony Process
            $process = new Process(['python', $scriptPath, $fullPath]);
            $process->run();

            if (!$process->isSuccessful()) {
                Log::error("FaceBlurService python script error: " . $process->getErrorOutput());
                return false;
            }

            $output = trim($process->getOutput());
            Log::info("FaceBlurService output for {$photoPath}: {$output}");
            
            return str_contains($output, 'Success:');
        } catch (\Exception $e) {
            Log::error("FaceBlurService exception: " . $e->getMessage());
            return false;
        }
    }
}
