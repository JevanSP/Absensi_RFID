<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengaturan_absensi', function (Blueprint $table) {
            $table->id();
            $table->time('jam_masuk')->default('07:00');
            $table->time('jam_pulang')->default('15:00');
            $table->timestamps();
        });

        DB::table('pengaturan_absensi')->insert([
            'jam_masuk' => '07:00',
            'jam_pulang' => '15:00',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturan_absensi');
    }
};
