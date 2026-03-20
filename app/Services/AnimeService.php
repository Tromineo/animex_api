<?php

namespace App\Services;

use App\Models\Anime;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

class AnimeService
{
    protected ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    public function listarTodos($porPagina = null)
    {
        if ($porPagina) {
            return Anime::paginate($porPagina);
        }
        return Anime::all();
    }

    public function buscarPorId($id)
    {
        return Anime::find($id);
    }

    public function criar(array $dados)
    {
        // Processar upload de imagem se presente
        if (isset($dados['url_imagem']) && $dados['url_imagem'] instanceof UploadedFile) {
            $imagePath = $this->imageService->uploadImage($dados['url_imagem'], [
                'width' => 800,
                'quality' => 85
            ]);
            $dados['url_imagem'] = $imagePath;
        }

        return Anime::create($dados);
    }

    public function atualizar(Anime $anime, array $dados)
    {
        // Processar nova imagem se fornecida
        if (isset($dados['url_imagem']) && $dados['url_imagem'] instanceof UploadedFile) {
            // Deletar imagem antiga
            $this->imageService->deleteImage($anime->url_imagem);

            // Upload da nova imagem
            $imagePath = $this->imageService->uploadImage($dados['url_imagem'], [
                'width' => 800,
                'quality' => 85
            ]);
            $dados['url_imagem'] = $imagePath;
        }

        $anime->update($dados);
        return $anime;
    }

    public function deletar(Anime $anime)
    {
        // Deletar imagem associada
        if ($anime->url_imagem) {
            $this->imageService->deleteImage($anime->url_imagem);
        }

        $anime->delete();
        return true;
    }
}
