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
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->string('rfid_tag')->unique();  
            $table->string('nis')->unique();
            $table->string('nama_siswa')->nullable();
            $table->enum('gender', ['L', 'P'])->nullable();
            $table->enum('kelas', ['X', 'XI', 'XII'])->nullable();
            $table->string('jurusan')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
