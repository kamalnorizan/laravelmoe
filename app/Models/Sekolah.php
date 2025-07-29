<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sekolah extends Model
{
    /** @use HasFactory<\Database\Factories\SekolahFactory> */
    use HasFactory;

    protected $table = 'sekolah';

    /**
     * Get all of the cikgu for the Sekolah
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cikgu()
    {
        return $this->hasMany(User::class, 'sekolah_id', 'id');
    }

    /**
     * Get all of the kelas for the Sekolah
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'sekolah_id', 'id');
    }
}
