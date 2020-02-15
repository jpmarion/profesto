<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'active', 'activation_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'activation_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     *
     * @OA\Schema(
     *     schema="User",
     *     title="User",
     *     description="User representation",
     *     @OA\Property(type="integer", property="id", description="The user id"),
     *     @OA\Property(type="string", property="name", description="Nombre del usuario"),
     *     @OA\Property(type="string", property="email", format="email", description="Email del usuario"),
     *     @OA\Property(type="string", format="date-time", property="email_verified_at", description="Cuando el usuario verifica su email", nullable=true),
     *     @OA\Property(type="boolean", property="active", description="Si usuario se encuentra activo"),
     *     @OA\Property(type="string", format="date-time", property="created_at", description="Cuando el usuario fue creado"),
     *     @OA\Property(type="string", format="date-time", property="updated_at", description="Cuando el usuario fue modificado la última vez"),
     *     @OA\Property(type="string", format="date-time", property="deleted_at", description="When user was last updated"),
     *     @OA\Property(type="string", property="email_alternativo", format="email", description="Email alternativo del usuario")
     * )
     *
     */
}
