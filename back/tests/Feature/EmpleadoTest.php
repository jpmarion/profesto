<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmpleadoTest extends TestCase
{
    public function testLogin()
    {
        $data = [
            'email' => 'totomarion@gmail.com',
            'password' => 'jpm141560',
            'remember_me' => true
        ];
        $this->withoutExceptionHandling();
        $response = $this->post('/api/auth/login', $data);
        $token = $response->assertStatus(200)->getContent();
        return $token;
    }

    /**
     * @depends testLogin
     */
    public function testEmpleadoStore($token)
    {
        $this->withoutExceptionHandling();

        $json = json_decode($token);
        $access_token = $json->access_token;
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $access_token
        ])->postJson(
            '/api/empleado',
            [
                'user_id' => 1,
                'nombre' => 'Juan Pablo',
                'apellido' => 'Marión'
            ]
        );

        $response
            ->assertStatus(201);
    }

    /**
     * @depends testLogin
     */
    public function testEmpleadosShowPorUsuario($token)
    {
        $this->withoutExceptionHandling();

        $json = json_decode($token);
        $access_token = $json->access_token;
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $access_token
        ])->getJson(
            '/api/empleado/showPorUsuario/1'
        );

        $response
            ->assertStatus(200);
    }
}
