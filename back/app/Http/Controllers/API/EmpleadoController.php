<?php

namespace App\Http\Controllers\API;

use App\Empleado;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmpleadoStoreRequest;
use App\Http\Requests\EmpleadoUpdateRequest;
use App\User;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Muestra todos los empleados
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Get(
     *      path="/api/empleado",
     *      tags={"EmpleadoController"},
     *      summary="Muestra todos los empleados",
     *      operationId="empleadoIndex",
     *      security={{"bearerAuth":{}}},
     *  @OA\Response(
     *      response=200,
     *      description="Empleados",
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
    public function index()
    {
        $empleados = Empleado::all();
        return response()->json($empleados, 200);
    }

    /**
     * Crear el empleado
     *
     * @param EmpleadoStoreRequest $request
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
            'id' => $empleado->id,
        ]);
    }

    /**
     * @OA\Get(
     *      path="/api/empleado/{id}",
     *      tags={"EmpleadoController"},
     *      summary="Buscar un empleado",
     *      operationId="empleadoShow",
     *      security={{"bearerAuth":{}}},
     *   @OA\Parameter(
     *     name="id",
     *     description="Id del empleado",
     *     required=true,
     *     in="path",
     *       @OA\Schema(
     *       type="integer"
     *     )
     *   ),
     *  @OA\Response(
     *      response=200,
     *      description="Empleado",
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
    public function show($id)
    {
        $empleado = Empleado::find($id);
        return response()->json($empleado, 200);
    }

    /**
     * Actualiza el empleado
     *
     * @param EmpleadoUpdateRequest $request
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Put(
     *      path="/api/empleado",
     *      tags={"EmpleadoController"},
     *      summary="Modificar un empleado",
     *      operationId="empleadoUpdate",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="EmpleadoUpdate",
     *          in="query",
     *          @OA\JsonContent(ref="#/components/schemas/EmpleadoUpdateRequest"),
     *      ),
     *  @OA\Response(
     *      response=200,
     *      description="Empleado modificado",
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
    public function update(EmpleadoUpdateRequest $request)
    {
        $empleado = Empleado::find($request->id);
        $empleado->nombre = $request->nombre;
        $empleado->apellido = $request->apellido;
        $empleado->save();
        return response()->json('Empleado modificado', 200);
    }

    /**
     * Elimina el empleado
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Delete(
     *      path="/api/empleado/{id}",
     *      tags={"EmpleadoController"},
     *      summary="Eliminar un empleado",
     *      operationId="empleadoDestroy",
     *      security={{"bearerAuth":{}}},
     *   @OA\Parameter(
     *     name="id",
     *     description="Id del empleado",
     *     required=true,
     *     in="path",
     *       @OA\Schema(
     *       type="integer"
     *     )
     *   ),
     *  @OA\Response(
     *      response=200,
     *      description="Empleado",
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
    public function destroy($id)
    {
        $empleado = Empleado::destroy($id);
        return response()->json('Empleado eliminado', 200);
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
