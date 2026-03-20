<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageService
{
    protected ImageManager $imageManager;
    protected string $disk;
    protected string $folder;

    public function __construct()
    {
        $this->imageManager = new ImageManager(new Driver());
        $this->disk = config('filesystems.default', 'public');
        $this->folder = 'animes';
    }

    /**
     * Processa e salva uma imagem
     *
     * @param UploadedFile $file
     * @param array $options Opções: ['width' => int, 'height' => int, 'quality' => int]
     * @return string Caminho relativo da imagem salva
     */
    public function uploadImage(UploadedFile $file, array $options = []): string
    {
        // Configurações padrão
        $width = $options['width'] ?? 800;
        $height = $options['height'] ?? null; // null mantém proporção
        $quality = $options['quality'] ?? 80;

        // Gerar nome único para o arquivo
        $filename = $this->generateUniqueFilename($file);

        // Processar imagem
        $image = $this->imageManager->read($file->getRealPath());

        // Redimensionar mantendo proporção
        if ($height) {
            $image->cover($width, $height);
        } else {
            $image->scale(width: $width);
        }

        // Converter para formato otimizado
        $encodedImage = $image->toJpeg($quality);

        // Salvar no storage
        $path = "{$this->folder}/{$filename}";
        Storage::disk($this->disk)->put($path, $encodedImage);
        return $path;
    }

    /**
     * Gera um nome único para o arquivo
     */
    protected function generateUniqueFilename(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $timestamp = now()->format('YmdHis');
        $random = Str::random(8);

        return "{$timestamp}_{$random}.{$extension}";
    }

    /**
     * Deleta uma imagem do storage
     */
    public function deleteImage(?string $path): bool
    {
        if (!$path) {
            return false;
        }

        if (Storage::disk($this->disk)->exists($path)) {
            return Storage::disk($this->disk)->delete($path);
        }

        return false;
    }

    /**
     * Retorna a URL pública da imagem
     */
    public function getImageUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        return Storage::disk($this->disk)->url($path);
    }

    /**
     * Processa múltiplas variações de uma imagem (thumbnail, médio, grande)
     */
    public function uploadImageWithVariations(UploadedFile $file): array
    {
        $variations = [
            'thumbnail' => ['width' => 150, 'height' => 150],
            'medium' => ['width' => 400],
            'large' => ['width' => 1200],
        ];

        $paths = [];

        foreach ($variations as $size => $options) {
            $paths[$size] = $this->uploadImage($file, $options);
        }

        return $paths;
    }

    /**
     * Valida se o arquivo é uma imagem válida
     */
    public function validateImage(UploadedFile $file): bool
    {
        $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        return in_array($file->getMimeType(), $allowedMimes) && $file->getSize() <= $maxSize;
    }
}
