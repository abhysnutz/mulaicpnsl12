<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class AuthTest extends TestCase
{
    // use RefreshDatabase;

    #[Test]
    public function user_can_login_with_correct_credentials()
    {
        // Arrange
        $user = User::factory()->create([
            'password' => bcrypt('M2APS2Ldoank'),
        ]);

        // Act
        $response = $this->post('/login', [
            'email'    => $user->email,
            'password' => 'M2APS2Ldoank',
        ]);

        // Assert
        $response->assertStatus(302); // redirect ke dashboard (web)
        $this->assertAuthenticatedAs($user);
    }

    #[Test]
    public function user_cannot_login_with_wrong_password()
    {
        // Arrange
        $user = User::factory()->create([
            'password' => bcrypt('M2APS2Ldoank'),
        ]);

        // Act
        $response = $this->post('/login', [
            'email'    => $user->email,
            'password' => 'salahpassword',
        ]);

        // Assert
        $response->assertStatus(302); // kembali ke login
        $this->assertGuest();
    }
}
