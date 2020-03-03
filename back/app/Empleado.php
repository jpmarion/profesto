<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{

    protected $fillable = [
        'nombre',
        'apellido'
    ];

    public function Usuarios()
    {
        return $this->belongsToMany(User::class, 'empleados_users');
    }

    /**
     * @OA\Schema(
     *     schema="Empleado",
     *     title="Empleado",
     *     description="Representación del empleado",
     *     @OA\Property(type="integer", property="id", description="Id de empleado"),
     *     @OA\Property(type="string", property="apellido", description="Apellido del empleado"),
     *     @OA\Property(type="string", property="nombre", description="nombre del empleado"),
     *     @OA\Property(property="user",  ref="#/components/schemas/User")
     * )
     */
}
