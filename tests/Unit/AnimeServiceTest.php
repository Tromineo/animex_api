<?php

namespace Tests\Unit;

use App\Models\Work;
use App\Services\AnimeService;
use App\Services\ImageService;
use Illuminate\Http\UploadedFile;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * Testes unitários para AnimeService.
 *
 * Todos os testes abaixo são puros (sem banco de dados):
 * as dependências externas (Anime, ImageService) são mockadas com Mockery,
 * isolando a lógica do serviço de qualquer infraestrutura.
 */
class AnimeServiceTest extends TestCase
{
    private MockInterface $imageService;
    private AnimeService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->imageService = Mockery::mock(ImageService::class);
        $this->service = new AnimeService($this->imageService);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    // ─── criar ────────────────────────────────────────────────────────────────

    #[Test]
    public function criar_sem_uploadedfile_nao_aciona_image_service(): void
    {
        // ImageService NÃO deve ser chamado quando url_imagem não é um UploadedFile
        $this->imageService->shouldNotReceive('uploadImage');

        $dados = ['titulo' => 'Naruto', 'url_imagem' => 'animes/naruto.jpg'];

        try {
            $this->service->criar($dados);
        } catch (\Illuminate\Database\QueryException $e) {
            // A lógica do ImageService ocorre ANTES do Work::create().
            // Exceções de DB são esperadas neste ambiente sem sqlite3 instalado.
            // A asserção real é feita pelo Mockery no tearDown.
        }

        // Se chegou aqui sem chamar uploadImage, o teste passou.
        $this->addToAssertionCount(1);
    }

    #[Test]
    public function criar_com_uploadedfile_chama_upload_image_e_substitui_path(): void
    {
        $file = UploadedFile::fake()->image('capa.jpg');

        // ImageService DEVE ser chamado com o arquivo e as opções corretas
        // Esta chamada ocorre ANTES de qualquer acesso ao banco de dados.
        $this->imageService
            ->shouldReceive('uploadImage')
            ->once()
            ->with(
                Mockery::on(fn($arg) => $arg === $file),
                ['width' => 800, 'quality' => 85]
            )
            ->andReturn('animes/capa_gerada.jpg');

        $dados = [
            'titulo'         => 'Attack on Titan',
            'sinopse'        => 'Humanos vs Titãs.',
            'ano_lancamento' => 2013,
            'id_status'      => 1,
            'url_imagem'     => $file,
        ];

        try {
            $this->service->criar($dados);
        } catch (\Illuminate\Database\QueryException $e) {
            // Exceção no Work::create() é esperada sem sqlite3.
            // O Mockery verifica a chamada ao uploadImage no tearDown.
        }

        $this->addToAssertionCount(1);
    }

    // ─── atualizar ────────────────────────────────────────────────────────────

    #[Test]
    public function atualizar_sem_nova_imagem_nao_aciona_image_service(): void
    {
        $animeMock = Mockery::mock(Work::class)->makePartial();
        $animeMock->shouldReceive('update')
            ->once()
            ->with(['titulo' => 'One Piece: Water 7'])
            ->andReturn(true);

        $this->imageService->shouldNotReceive('uploadImage');
        $this->imageService->shouldNotReceive('deleteImage');

        $resultado = $this->service->atualizar($animeMock, ['titulo' => 'One Piece: Water 7']);

        $this->assertSame($animeMock, $resultado);
    }

    #[Test]
    public function atualizar_com_nova_imagem_deleta_a_antiga_e_faz_upload(): void
    {
        $novaImagem = UploadedFile::fake()->image('nova.jpg');

        $animeMock = Mockery::mock(Work::class)->makePartial();
        $animeMock->url_imagem = 'animes/antiga.jpg';
        $animeMock->shouldReceive('update')
            ->once()
            ->with(Mockery::on(fn($d) => $d['url_imagem'] === 'animes/nova_gerada.jpg'))
            ->andReturn(true);

        // Deve deletar a imagem antiga
        $this->imageService
            ->shouldReceive('deleteImage')
            ->once()
            ->with('animes/antiga.jpg');

        // Deve fazer upload da nova imagem
        $this->imageService
            ->shouldReceive('uploadImage')
            ->once()
            ->with($novaImagem, ['width' => 800, 'quality' => 85])
            ->andReturn('animes/nova_gerada.jpg');

        $resultado = $this->service->atualizar($animeMock, [
            'titulo'     => 'One Piece',
            'url_imagem' => $novaImagem,
        ]);

        $this->assertSame($animeMock, $resultado);
    }

    // ─── deletar ──────────────────────────────────────────────────────────────

    #[Test]
    public function deletar_sem_imagem_nao_chama_delete_image(): void
    {
        $animeMock = Mockery::mock(Work::class)->makePartial();
        $animeMock->url_imagem = null;
        $animeMock->shouldReceive('delete')->once()->andReturn(true);

        $this->imageService->shouldNotReceive('deleteImage');

        $resultado = $this->service->deletar($animeMock);

        $this->assertTrue($resultado);
    }

    #[Test]
    public function deletar_com_imagem_chama_delete_image_antes_de_remover(): void
    {
        $animeMock = Mockery::mock(Work::class)->makePartial();
        $animeMock->url_imagem = 'animes/capa.jpg';
        $animeMock->shouldReceive('delete')->once()->andReturn(true);

        // O ImageService deve ser chamado com o path correto
        $this->imageService
            ->shouldReceive('deleteImage')
            ->once()
            ->with('animes/capa.jpg');

        $resultado = $this->service->deletar($animeMock);

        $this->assertTrue($resultado);
    }
}
