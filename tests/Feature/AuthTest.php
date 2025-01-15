<?php

use Illuminate\Testing\Fluent\AssertableJson;

it('should return 401 when login with non-existent email', function () {
    $response = $this->post('api/v1/auth/login', [
        'email' => 'invalid@email.com',
        'password' => 'wrongpassword',
    ]);

    $response->assertStatus(401)
        ->assertJson([
            'status' => 401,
            'error' => 'Query error - unauthorized access',
            'message' => 'Login gagal, Email tidak ditemukan.',
        ]);
});

it('should return 401 when login with invalid credentials', function () {
    $response = $this->post('api/v1/auth/login', [
        'email' => 'kaprodi@example.com',
        'password' => 'wrongpassword',
    ]);

    $response->assertStatus(401)
        ->assertJson([
            'status' => 401,
            'error' => 'Query error - unauthorized access',
            'message' => 'Email / Password anda salah!',
        ]);
});

it('should return 200 and token when login with valid DPPM credentials', function () {
    $response = $this->post('api/v1/auth/login', [
        'email' => 'dppm@example.com',
        'password' => 'password',
    ]);

    $response->assertStatus(200)
        ->assertJson(function (AssertableJson $json) {
            $json->has('status')
                ->whereType('status', 'integer')
                ->has('message')
                ->whereType('message', 'string')
                ->has('data');
        });
});

it('should return 200 and token when login with valid Kaprodi credentials', function () {
    $response = $this->post('api/v1/auth/login', [
        'email' => 'kaprodi@example.com',
        'password' => 'password',
    ]);

    $response->assertStatus(200)
        ->assertJson(function (AssertableJson $json) {
            $json->has('status')
                ->whereType('status', 'integer')
                ->has('message')
                ->whereType('message', 'string')
                ->has('data');
        });
});

it('should return 200 and token when login with valid Dosen credentials', function () {
    $response = $this->post('api/v1/auth/login', [
        'email' => 'dosen@example.com',
        'password' => 'password',
    ]);

    $response->assertStatus(200)
        ->assertJson(function (AssertableJson $json) {
            $json->has('status')
                ->whereType('status', 'integer')
                ->has('message')
                ->whereType('message', 'string')
                ->has('data');
        });
});
