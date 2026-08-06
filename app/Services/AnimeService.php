<?php

namespace App\Services;

use App\Repositories\Contracts\AnimeRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;

class AnimeService
{
    protected ImageService $imageService;
    protected AnimeRepositoryInterface $animeRepository;

    public function __construct(ImageService $imageService, AnimeRepositoryInterface $animeRepository)
    {
        $this->imageService = $imageService;
        $this->animeRepository = $animeRepository;
    }

    public function listarTodos($porPagina = null)
    {
        $ttl = 3600; // tempo que vai ser guardado no cache, em segundos (1 hora)
        if ($porPagina) {
            $page = request()?->get('page', 1) ?? 1;
            $key = "animes:page:{$page}:per:{$porPagina}";
            return Cache::tags(['animes'])->remember($key, $ttl, fn() => $this->animeRepository->paginate($porPagina));
        }

        $key = 'animes:all';
        return Cache::tags(['animes'])->remember($key, $ttl, fn() => $this->animeRepository->all());
    }

    public function buscarPorId($id)
    {
        $ttl = 3600;
        $key = "anime:{$id}";
        return Cache::tags(['animes'])->remember($key, $ttl, fn() => $this->animeRepository->find($id));
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

        $anime = $this->animeRepository->create($dados);
        // Invalida cache
        Cache::tags(['animes'])->flush();

        //event(new \App\Events\AnimeCriado($anime));
        return $anime;
    }

    public function atualizar($anime, array $dados)
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

        $updated = $this->animeRepository->update($anime, $dados);
        // Invalidate caches
        Cache::tags(['animes'])->flush();
        return $updated;
    }

    public function deletar($anime)
    {
        // Deletar imagem associada
        if ($anime->url_imagem) {
            $this->imageService->deleteImage($anime->url_imagem);
        }

        $deleted = $this->animeRepository->delete($anime);
        // Invalidate caches
        Cache::tags(['animes'])->flush();
        return $deleted;
    }
}
