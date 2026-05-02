<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 * @OA\Info(title="", version="0.1")
 */
class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}
    /**
    * @OA\Post(
    *     path="/register",
    *     summary="Registrar novo usuário",
    *     description="Exemplo de requisição curl: curl -X POST http://127.0.0.1:8000/api/register -H Content-Type:application/json -d {name:Rodrigo,email:rodrigo@rodrigo.com.br,password:senha123,password_confirmation:senha123}",
    *     tags={"Autenticação"},
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             required={"email", "password", "password_confirmation"},
    *             @OA\Property(property="name", type="string", example="Rodrigo"),
    *             @OA\Property(property="email", type="string", format="email", example="rodrigo@email.com"),
    *             @OA\Property(property="password", type="string", format="password", example="12345678"),
    *             @OA\Property(property="password_confirmation", type="string", format="password", example="12345678")
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="Registro realizado com sucesso",
    *         @OA\JsonContent(
    *             @OA\Property(property="message", type="string", example="Successfully registered"),
    *             @OA\Property(property="user", type="object"),
    *             @OA\Property(property="token", type="string", example="token123abc")
    *         )
    *     ),
    *     @OA\Response(
    *         response=422,
    *         description="Erro de validação"
    *     )
    * )
    */
    public function register(Request $request)
    {
        $resultado = $this->authService->registrar($request->all());

        return response()->json([
            'message' => 'Successfully registered',
            'user'    => $resultado['user'],
            'token'   => $resultado['token'],
        ]);
    }
    /**
     * @OA\Post(
     *     path="/login",
    *     summary="Login do usuário",
    *     description="Exemplo de requisição curl: curl -X POST http://127.0.0.1:8000/api/login -H Content-Type:application/json -d {email:usuario@exemplo.com,password:12345678}",
    *     tags={"Autenticação"},
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             required={"email", "password"},
    *             @OA\Property(property="email", type="string", format="email", example="usuario@exemplo.com"),
    *             @OA\Property(property="password", type="string", format="password", example="12345678")
    *         )
    *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login realizado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Successfully logged in"),
     *             @OA\Property(property="user", type="object"),
     *             @OA\Property(property="token", type="string", example="token123abc")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Dados inválidos",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Dados inválidos")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação"
     *     )
     * )
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Dados invalidos'
            ], 401);
        }

        return response()->json([
            'message' => 'Successfully logged in',
            'user' => $user,
            'token' => $user->createToken('auth_token')->plainTextToken
        ]);
    }

}
