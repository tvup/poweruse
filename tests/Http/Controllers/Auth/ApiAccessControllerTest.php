<?php

namespace Tests\Http\Controllers\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Bridge\RefreshToken;
use Laravel\Passport\PersonalAccessTokenFactory;
use Mockery;
use ReflectionClass;
use Tests\TestCase;

class ApiAccessControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateApiAccessToken() : void
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);

        // Mock the Personal Access Token response
        $token = $user->tokens()->create(['id' => 123, 'user_id' => $user->id, 'client_id' => 1, 'name' => 'Laravel Password Grant Client', 'scopes' => [], 'revoked' => false]);

        $reflectionClass = new ReflectionClass(RefreshToken::class);
        $reflectionClass->getProperty('accessToken')->setValue($token, 'generated_access_token');

        $tokenFactoryMock = Mockery::mock(PersonalAccessTokenFactory::class);
        $tokenFactoryMock->shouldReceive('make')
            ->once()
            ->andReturn($token);

        app()->instance(PersonalAccessTokenFactory::class, $tokenFactoryMock);

        $response = $this->withSession(['status' => 'api-token-created'])
            ->get(route('api.create'));

        $user->refresh();

        $this->assertEquals('generated_access_token', $user->api_access_token);
        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHas('status', 'api-token-created');
    }
}
