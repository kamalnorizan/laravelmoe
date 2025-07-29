<?php

namespace Database\Seeders;


// use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Uuid;
use App\Models\Sekolah;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sekolah::create([
            'uuid' => Uuid::uuid4(),
            'kod_sekolah' => 'K001',
            'nama_sekolah' => 'Sekolah Kebangsaan 1',
            'alamat_sekolah' => 'Alamat Sekolah Kebangsaan 1',
            'poskod' => '12345',
            'negeri' => 'Negeri 1',
        ]);

        Sekolah::create([
            'uuid' => Uuid::uuid4(),
            'kod_sekolah' => 'K002',
            'nama_sekolah' => 'Sekolah Kebangsaan 2',
            'alamat_sekolah' => 'Alamat Sekolah Kebangsaan 2',
            'poskod' => '12346',
            'negeri' => 'Negeri 1',
        ]);
    }
}
