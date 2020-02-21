<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AuthTest extends TestCase
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
    public function testUser($token)
    {
        $this->withoutExceptionHandling();

        $json = json_decode($token);
        $access_token = $json->access_token;
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $access_token
        ])->getJson('/api/auth/user');
        print_r($response->assertStatus(200)->getContent());
    }

    /**
     * @depends testLogin
     */
    public function testLogout($token)
    {
        $this->withoutExceptionHandling();

        $json = json_decode($token);
        $access_token = $json->access_token;
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $access_token
        ])->getJson('/api/auth/logout');
        print_r($response->assertStatus(200)->getContent());
    }
}
