<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_karyawan_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nik', 20)->unique();
            $table->text('alamat')->nullable();
            $table->string('no_telepon', 15)->nullable();
            $table->string('posisi', 100);
            $table->date('tanggal_masuk');
            $table->decimal('gaji_pokok', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('karyawan');
    }
};