<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_absensi_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained('karyawan')->onDelete('cascade');
            $table->date('tanggal');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_pulang')->nullable();
            $table->enum('status', ['hadir', 'izin', 'sakit', 'tanpa_keterangan'])->default('tanpa_keterangan');
            $table->text('keterangan')->nullable(); // Untuk alasan izin/sakit
            $table->timestamps();

            $table->unique(['karyawan_id', 'tanggal']); // Karyawan hanya bisa absensi sekali sehari
        });
    }

    public function down()
    {
        Schema::dropIfExists('absensi');
    }
};