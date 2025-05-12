<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_gaji_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('gaji', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained('karyawan')->onDelete('cascade');
            $table->tinyInteger('bulan'); // 1-12
            $table->year('tahun');
            $table->integer('total_hadir')->default(0);
            $table->integer('total_izin')->default(0);
            $table->integer('total_sakit')->default(0);
            $table->integer('total_tanpa_keterangan')->default(0);
            $table->decimal('gaji_pokok', 10, 2);
            $table->decimal('potongan', 10, 2)->default(0);
            $table->decimal('gaji_bersih', 10, 2);
            $table->text('keterangan_gaji')->nullable(); // Catatan tambahan untuk gaji
            $table->date('tanggal_pembayaran')->nullable();
            $table->timestamps();

            $table->unique(['karyawan_id', 'bulan', 'tahun']); // Gaji unik per karyawan per periode
        });
    }

    public function down()
    {
        Schema::dropIfExists('gaji');
    }
};