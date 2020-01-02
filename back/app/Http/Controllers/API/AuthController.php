<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Validator;
use App\Notifications\SignupActivate;

/**
 *  @OA\Info(
 *      description="Back End sistema control ingreso y egreso personal",
 *      version="1.0.0",
 *      title="Profesto",
 *  )
 */

/**
 *  @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *         type="http",
 *        scheme="bearer",
 *       bearerFormat="JWT"
 *  ),
 */

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/auth/register",
     *      tags={"AuthController"},
     *      summary="Registro de usuario",
     *      operationId="login",
     * 
     *  @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *  ),    
     *  @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *  ),    
     *  @OA\Response(
     *      response=201,
     *      description="Usuario creado",
     *      @OA\MediaType(
     *          mediaType="application/json",
     *      )
     *  ),
     *  @OA\Response(
     *      response=400,
     *      description="Solicitud no válida"
     *  ),
     *  @OA\Response(
     *      response=404,
     *      description="No encontrado"
     *  ),
     *  @OA\Response(
     *      response=422,
     *      description="Error validación"
     *  )
     *)
     */

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'name' => '',
            'activation_token' => md5($request->email)
        ]);        
        
        $user->notify(new SignupActivate($user));
        return response()->json([
            'Usuario creado con exito'
        ], 201);
    }

    public function registerActivate($token)
    {
        $user = User::where('activation_token', $token)->first();
        if (!$user) {
            return response()->json(['message' => 'El token de activación es invalida'], 404);
        }
        $user->active = true;
        $user->activation_token = '';
        $user->save();
        return $user;
    }
}
