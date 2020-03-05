<?php

namespace App\Http\Controllers\API;

use App\Empleado;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmpleadoStoreRequest;
use App\User;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Post(
     *      path="/api/empleado",
     *      tags={"EmpleadoController"},
     *      summary="Cargar un empleado",
     *      operationId="empleadoStore",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="Register",
     *          in="query",
     *          @OA\JsonContent(ref="#/components/schemas/EmpleadoStoreRequest"),
     *      ),
     *  @OA\Response(
     *      response=200,
     *      description="Empleado creado",
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
    public function store(EmpleadoStoreRequest $request)
    {
        $empleado = new Empleado([
            'apellido' => $request->apellido,
            'nombre' => $request->nombre
        ]);
        $user = User::find($request->user_id);
        $user->Empleados()->save($empleado);
        return response()->json([
            'Empleado creado con exito'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @OA\Get(
     *      path="/api/empleado/showPorUsuario/{idUser}",
     *      tags={"EmpleadoController"},
     *      summary="Empleados de un usuario en particular",
     *      operationId="empleadosPorUsuario",
     *      security={{"bearerAuth":{}}},
     *   @OA\Parameter(
     *     name="idUser",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="integer")
     *   ),
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
    public function showPorUsuario($id)
    {
        $empleados = User::find($id)->empleados;
        return response()->json($empleados, 200);
    }
}
