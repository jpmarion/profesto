<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ModelNotFoundException && $request->wantsJson()) {
            return response()->json(['error' => 'Registro no encontrado'], 404);
        }
        if ($exception instanceof MethodNotAllowedException) {
            return response()->json(['error' => 'Método no permitido'], 405);
        }
        if ($exception instanceof UnauthorizedException) {
            return response()->json(['error' => 'Token no proporcionado'], 401);
        }
        if ($exception instanceof JWTException) {
            return response()->json(['error' => $exception], 500);
        }
        if ($exception instanceof TokenExpiredException) {
            return response()->json(['error' => 'Token expirado'], $exception->getStatusCode());
        } else if ($exception instanceof TokenInvalidException) {
            return response()->json(['error' => 'Token invalido'], $exception->getStatusCode());
        }
        return parent::render($request, $exception);
    }
}
