<?php

namespace Tests\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SmartMeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testUpdateSmartMeInformation() : void
    {
        $user = \App\Models\User::factory()->create([
            'smartme_username' => 'old_username',
            'smartme_password' => 'old_password',
            'smartme_directory_id' => 'old_directory_id',
            'email' => 'user@example.com',
            'email_verified_at' => now(),
        ]);

        $this->actingAs($user);

        $response = $this->patch(route('smartme.update'), [
            'username' => 'new_username',
            'password' => 'new_password',
            'directory_id' => 'new_directory_id',
        ]);

        $user->refresh();

        $this->assertEquals('new_username', $user->smartme_username);
        $this->assertEquals('new_password', $user->smartme_password);
        $this->assertEquals('new_directory_id', $user->smartme_directory_id);
        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHas('status', 'smartme-updated');
    }
}
