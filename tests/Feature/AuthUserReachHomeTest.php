<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthUserReachHomeTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_user_auth_and_restrict(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/home');

        $response->assertStatus(200);
    }
}
