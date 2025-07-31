<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SekolahSeeder::class,
        ]);
        User::factory(100)->create();
        Kelas::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com'
        // ]);

        $this->call([
            RolePermissionSeeder::class,
        ]);

    }
}
