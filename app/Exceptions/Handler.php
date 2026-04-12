<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception)
    {
        // Se for uma requisição que espera JSON (API), use o tratamento customizado
        if ($request->expectsJson()) {
            $className = get_class($exception);
            $handlers = ApiExceptions::$handlers;
            if (array_key_exists($className, $handlers)) {
                $method = $handlers[$className];
                // Alguns handlers não usam $request, outros sim
                if (method_exists(ApiExceptions::class, $method)) {
                    $reflection = new \ReflectionMethod(ApiExceptions::class, $method);
                    $params = $reflection->getParameters();
                    if (count($params) === 2) {
                        return ApiExceptions::$method($exception, $request);
                    } else {
                        return ApiExceptions::$method($exception);
                    }
                }
            }
            // Resposta padrão para exceções não tratadas
            return response()->json([
                'status' => 500,
                'type' => class_basename($exception),
                'error' => $exception->getMessage(),
            ], 500);
        }
        return parent::render($request, $exception);
    }

    /**
     * Override unauthenticated to return JSON for API requests.
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return ApiExceptions::handleAuthenticationException($exception, $request);
        }
        return parent::unauthenticated($request, $exception);
    }
}
