<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpleadoUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required',
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100'
        ];
    }

    /**
     * @OA\Schema(
     *     schema="EmpleadoUpdateRequest",
     *     title="EmpleadoUpdateRequest",
     *     description="Empleados Update Request",
     *     @OA\Property(type="integer", property="id", description="Id del empleado"),
     *     @OA\Property(type="string", property="nombre", description="nombre del empleado"),
     *     @OA\Property(type="string", property="apellido", description="Apellido del empleado"),
     * )
     */
}
