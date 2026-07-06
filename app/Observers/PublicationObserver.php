<?php

namespace App\Observers;

use App\Models\Publication;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PublicationObserver
{
    /**
     * Handle the Publication "saved" event.
     */
    public function saved(Publication $publication): void
    {
        if ($publication->isDirty('photos')) {
            $newPhotos = $publication->photos ?? [];
            $originalPhotos = $publication->getOriginal('photos') ?? [];

            // Identificar fotos nuevas comparando los arrays
            // Nota: Filament puede reordenar, asÃ­ que esto es aproximado. 
            // Lo ideal es verificar si la imagen ya fue procesada, pero eso requiere metadatos.
            // Asumiremos que las nuevas rutas son nuevas subidas.
            $addedPhotos = array_diff($newPhotos, $originalPhotos);

            foreach ($addedPhotos as $photoPath) {
                $this->applyWatermark($photoPath); // Re-activado y ajustado tamaño
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

            // Solo procesar imÃ¡genes soportadas
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

            // Calcular el ancho visible de la imagen (crop 3:4) para mantener tamaño uniforme
            $visibleWidth = min($imgWidth, $imgHeight * 0.75);
            $newWatermarkWidth = $visibleWidth * 0.55;
            $aspectRatio = $watermarkHeight / $watermarkWidth;
            $newWatermarkHeight = $newWatermarkWidth * $aspectRatio;

            $resizedWatermark = imagecreatetruecolor((int)$newWatermarkWidth, (int)$newWatermarkHeight);
            
            // Mantener transparencia en la marca de agua redimensionada
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

            // Truco para aplicar opacidad (30%) a un PNG con canal alfa en GD
            $opacity = 30;
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
            Log::error('Error applying watermark: ' . $e->getMessage());
        }
    }
}

