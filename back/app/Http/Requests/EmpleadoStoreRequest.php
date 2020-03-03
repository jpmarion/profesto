<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpleadoStoreRequest extends FormRequest
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
            'user_id' => 'required',
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100'
        ];
    }

    /**
     *
     * @OA\Schema(
     *     schema="EmpleadoStoreRequest",
     *     title="EmpleadoStoreRequest",
     *     description="EmpleadosStore Request",
     *     @OA\Property(type="integer", property="user_id", description="Id del usuario"),
     *     @OA\Property(type="string", property="nombre", description="Nombre del empleado"),
     *     @OA\Property(type="string", property="apellido", description="Apellido del empleado"),
     * )
     */
}
