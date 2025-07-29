<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelas', 100)->nullable();
            $table->foreignId('sekolah_id')->constrained('sekolah')->onDelete('restrict')->onUpdate('cascade');
            $table->string('tahunting', 4);
            $table->string('tahun', 4);
            $table->foreignId('guru_kelas1')->constrained('users')->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('guru_kelas2')->nullable()->constrained('users')->onDelete('restrict')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
