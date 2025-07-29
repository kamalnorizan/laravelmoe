<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Sekolah;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kelas>
 */
class KelasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $guru_kelas_1 = User::all()->random();
        $sekolah = Sekolah::find($guru_kelas_1->sekolah_id);
        $guru_kelas_2 = User::where('sekolah_id',$guru_kelas_1->sekolah_id)->get()->random();

        return [
            'nama_kelas' => fake()->word,
            'sekolah_id' => $sekolah->id,
            'tahunting' => rand(1,6),
            'tahun' => rand(2022,2026),
            'guru_kelas1' => $guru_kelas_1->id,
            'guru_kelas2' => $guru_kelas_2->id,
        ];
    }
}
