<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\DestroyCategoriaRequest;
use App\Models\Categoria;
use Mockery;
use App\Http\Controllers\CategoriaController;

class CategoriaControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_create_returns_json_response_with_created_categoria()
    {
        // Mock do request
        $request = Mockery::mock(StoreCategoriaRequest::class);
        $request->shouldReceive('validated')->once()->andReturn([
            'nome' => 'Shounen',
            'slug' => 'shounen',
            'description' => ''
        ]);

        // Mock parcial da instância da model
        $categoriaMock = Mockery::mock(Categoria::class)->makePartial();
        $categoriaMock->id = 1;
        $categoriaMock->nome = 'Shounen';
        $categoriaMock->slug = 'shounen';
        $categoriaMock->description = '';
        $categoriaMock->created_at = now();
        $categoriaMock->updated_at = now();

        // Mock do método create na instância
        $categoriaMock->shouldReceive('create')
            ->once()
            ->with([
                'nome' => 'Shounen',
                'slug' => 'shounen',
                'description' => ''
            ])
            ->andReturn($categoriaMock);

        // Executa o controller passando o mock da model
        $controller = new CategoriaController();
        $response = $controller->create($request, $categoriaMock);

        // Asserts
        $this->assertInstanceOf(\Illuminate\Http\JsonResponse::class, $response);
        $this->assertEquals(201, $response->status());

        $data = $response->getData();
        $this->assertEquals('Shounen', $data->nome);
        $this->assertEquals('shounen', $data->slug);
        $this->assertEquals('', $data->description);
        $this->assertEquals(1, $data->id);
    }

    public function test_delete_returns_json_with_destroy_result()
    {
                $categoria = Categoria::factory()->create();

        $response = $this->deleteJson("/categorias/{$categoria->id}");

        $response->assertStatus(200)->assertJson(1);

        $this->assertDatabaseMissing('categorias', ['id' => $categoria->id]);
    }
}
