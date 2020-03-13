<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class EmpleadoTest extends TestCase
{
    use WithFaker;

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
                'nombre' => $this->faker->firstName,
                'apellido' => $this->faker->lastName
            ]
        );

        $idPersona = $response->assertStatus(200);
        return $idPersona;
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

    /**
     * @depends testLogin
     */
    public function testEmpleadosIndex($token)
    {
        $this->withoutExceptionHandling();

        $json = json_decode($token);
        $access_token = $json->access_token;
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $access_token
        ])->getJson(
            '/api/empleado'
        );
        $response->assertStatus(200);
    }

    /**
     * @depends testLogin
     * @depends testEmpleadoStore
     */
    public function testShow($token)
    {
        // $this->withoutExceptionHandling();

        $json = json_decode($token);
        $access_token = $json->access_token;
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $access_token
        ])->getJson(
            '/api/empleado/1'
        );
        $response->assertStatus(200);
    }

    /**
     * @depends testLogin
     * @depends testEmpleadoStore
     */
    public function testUpdate($token, $idPersona)
    {
        // $this->withoutExceptionHandling();

        $json = json_decode($token);
        $access_token = $json->access_token;
        $json = json_decode($idPersona->getContent());
        $id = $json->id;

        $data =  [
            'id' => $id,
            'nombre' => $this->faker->firstName,
            'apellido' => $this->faker->lastName
        ];
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $access_token
        ])->putJson(
            '/api/empleado',
            $data
        );
        $response->assertStatus(200);
    }
}
