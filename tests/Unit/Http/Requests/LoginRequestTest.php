<?php

namespace Tests\Unit\Http\Requests;

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
//use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class LoginRequestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }
    /**
     * @test
     *
     * Testa se um usuário consegue fazer login com sucesso usando credenciais corretas.
     *
     * O teste cria um usuário e, em seguida, simula uma requisição de login
     * com o email e a senha corretos. Ele espera uma resposta bem-sucedida (HTTP 200)
     * com uma estrutura JSON contendo a mensagem de sucesso, os dados do usuário e um token.
     *
     * @return void
     */
    public function usuario_pode_fazer_login_com_credenciais_corretas()
    {
        $password = 'senha1234';
        $user = User::factory()->create(['password' => Hash::make($password)]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['message', 'user', 'token']);
    }

    /**
     * @test
     *
     * Testa se o login falha quando uma senha incorreta é fornecida.
     *
     * O teste cria um usuário e simula uma requisição de login com a senha errada.
     * Ele espera que o servidor retorne uma resposta de erro de autenticação (HTTP 401)
     * e uma mensagem de "Dados invalidos" na resposta JSON.
     *
     * @return void
     */
    public function login_falha_com_senha_incorreta()
    {
        $user = User::factory()->create(['password' => Hash::make('senha1234')]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'senha_errada',
        ]);

        $response->assertStatus(401)
         ->assertJsonFragment([
             'message' => 'Dados invalidos' // Apenas o objeto
         ]);
    }

    /**
     * @test
     *
     * Testa se o login falha quando dados inválidos são fornecidos.
     *
     * O teste envia um email em formato inválido e uma senha curta,
     * esperando uma resposta de erro de validação (HTTP 422)
     * para os campos 'email' e 'password'.
     *
     * @return void
     */
    public function login_falha_com_dados_invalidos()
    {
        $response = $this->postJson('/api/login', [
            'email' => 'email-invalido',
            'password' => 'curta',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email', 'password']);
    }
}
