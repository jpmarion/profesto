<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Validator;
use App\Notifications\SignupActivate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
 *      type="http",
 *      scheme="bearer",
 *  )
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

    /**
     * @OA\Post(
     *      path="/api/auth/login",
     *      tags={"AuthController"},
     *      summary="Login de usuario",
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
     *  @OA\Parameter(
     *      name="remember_me",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="boolean"
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
     *      response=401,
     *      description="No autorizado"
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
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return  response()->json([
                'message' => 'No autorizado'
            ], 401);
        }
        $user = $request->user();
        $tokenResult = $user->createToken('Administrador');
        $token = $tokenResult->token;

        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeek(1);
        }

        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expired_at' => Carbon::parse($tokenResult->token->expired_at)->toDateTimeString()
        ]);
    }

    /**
     * @OA\Get(
     *      path="/api/auth/logout",
     *      tags={"AuthController"},
     *      summary="Logout de usuario",
     *      operationId="logout",
     *      security={{"bearerAuth":{}}},
     *     
     *      @OA\Response(
     *          response=201,
     *          description="Usuario creado",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Solicitud no válida"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="No autorizado"
     *      ),     
     *      @OA\Response(
     *          response=404,
     *          description="No encontrado"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Error validación"
     *      )
     *  )
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Salió exitosamente'
        ]);
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

    /**
     * @OA\Get(
     *      path="/api/auth/user",
     *      tags={"AuthController"},
     *      summary="Datos del usuario",
     *      operationId="user",
     *      security={{"bearerAuth":{}}},
     *     
     *      @OA\Response(
     *          response=201,
     *          description="Usuario",
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Solicitud no válida"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="No autorizado"
     *      ),     
     *      @OA\Response(
     *          response=404,
     *          description="No encontrado"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Error validación"
     *      )
     *  )
     */
    public function user(Request $request){
        return response()->json($request->user());
    }

}