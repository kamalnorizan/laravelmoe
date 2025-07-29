<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kelas extends Model
{
    use HasFactory;
    protected $table = 'kelas';


    /**
     * Get the sekolah that owns the Kelas
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'sekolah_id', 'id');
    }

    public function guruKelas1()
    {
        return $this->belongsTo(User::class, 'guru_kelas1', 'id');
    }

    public function guruKelas2()
    {
        return $this->belongsTo(User::class, 'guru_kelas2', 'id');
    }
}
