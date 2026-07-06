<?php

namespace App\Observers;

use App\Models\Story;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class StoryObserver
{
    /**
     * Handle the Story "saved" event.
     */
    public function saved(Story $story): void
    {
        if ($story->isDirty('media_path')) {
            $paths = $story->media_path ?? [];
            // Manejar si es string (aunque el modelo hace cast a array, a veces viene raw)
            if (is_string($paths)) {
                $paths = [$paths];
            }

            $originalPaths = $story->getOriginal('media_path') ?? [];
            if (is_string($originalPaths)) {
                $originalPaths = [$originalPaths];
            }

            // Identificar nuevos archivos
            $addedPaths = array_diff($paths, $originalPaths);

            foreach ($addedPaths as $path) {
                $this->applyWatermark($path); // Re-activado y ajustado tamaño
            }
        }
    }

    protected function applyWatermark($path)
    {
        try {
            $disk = Storage::disk('public'); // Asumir disco public
            if (!$disk->exists($path)) {
                return;
            }

            $fullPath = $disk->path($path);
            $extension = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));

            // Solo procesar imÃ¡genes soportadas (NO videos)
            if (!in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])) {
                return;
            }

            // Cargar imagen
            $img = null;
            switch ($extension) {
                case 'jpg':
                case 'jpeg':
                    $img = @imagecreatefromjpeg($fullPath);
                    break;
                case 'png':
                    $img = @imagecreatefrompng($fullPath);
                    break;
                case 'webp':
                    $img = @imagecreatefromwebp($fullPath);
                    break;
            }

            if (!$img) {
                return;
            }

            // Cargar marca de agua
            $watermarkPath = public_path('images/CITASESCORT-logotipo_final.png');
            if (!file_exists($watermarkPath)) {
                imagedestroy($img);
                return;
            }
            
            $watermark = @imagecreatefrompng($watermarkPath);
            if (!$watermark) {
                imagedestroy($img);
                return;
            }

            // Obtener dimensiones
            $imgWidth = imagesx($img);
            $imgHeight = imagesy($img);
            $watermarkWidth = imagesx($watermark);
            $watermarkHeight = imagesy($watermark);

            // Redimensionar marca de agua al 90% del ancho de la imagen para que sea más grande
            $newWatermarkWidth = $imgWidth * 0.90;
            $aspectRatio = $watermarkHeight / $watermarkWidth;
            $newWatermarkHeight = $newWatermarkWidth * $aspectRatio;

            $resizedWatermark = imagecreatetruecolor((int)$newWatermarkWidth, (int)$newWatermarkHeight);
            
            // Mantener transparencia
            imagealphablending($resizedWatermark, false);
            imagesavealpha($resizedWatermark, true);
            
            imagecopyresampled(
                $resizedWatermark, 
                $watermark, 
                0, 0, 0, 0, 
                (int)$newWatermarkWidth, (int)$newWatermarkHeight, 
                $watermarkWidth, $watermarkHeight
            );

            // PosiciÃ³n centrada
            $destX = ($imgWidth - $newWatermarkWidth) / 2;
            $destY = ($imgHeight - $newWatermarkHeight) / 2;

            // Truco para aplicar opacidad (25%) a un PNG con canal alfa en GD
            $opacity = 25;
            $cut = imagecreatetruecolor((int)$newWatermarkWidth, (int)$newWatermarkHeight);
            imagecopy($cut, $img, 0, 0, (int)$destX, (int)$destY, (int)$newWatermarkWidth, (int)$newWatermarkHeight);
            imagecopy($cut, $resizedWatermark, 0, 0, 0, 0, (int)$newWatermarkWidth, (int)$newWatermarkHeight);
            imagecopymerge($img, $cut, (int)$destX, (int)$destY, 0, 0, (int)$newWatermarkWidth, (int)$newWatermarkHeight, $opacity);
            imagedestroy($cut);

            // Guardar imagen sobrescribiendo la original
            switch ($extension) {
                case 'jpg':
                case 'jpeg':
                    imagejpeg($img, $fullPath, 90);
                    break;
                case 'png':
                    imagealphablending($img, true);
                    imagesavealpha($img, true);
                    imagepng($img, $fullPath);
                    break;
                case 'webp':
                    imagewebp($img, $fullPath, 90);
                    break;
            }

            // Liberar memoria
            imagedestroy($img);
            imagedestroy($watermark);
            imagedestroy($resizedWatermark);

        } catch (\Exception $e) {
            Log::error('Error applying watermark to Story image: ' . $e->getMessage());
        }
    }
}

