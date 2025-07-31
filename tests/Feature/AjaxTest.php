<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AjaxTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_ajax_load_users_returns_json(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        $response = $this->actingAs($admin)->postJson(route('user.ajaxLoadUsers'));

        $response->assertStatus(200);
    }
}
