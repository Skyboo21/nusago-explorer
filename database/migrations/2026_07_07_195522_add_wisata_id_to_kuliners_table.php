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
        Schema::table('kuliner', function (Blueprint $table) {
            // Menambahkan kolom wisata_id sebagai Foreign Key ke tabel wisatas
            // nullable() -> Agar data kuliner lama yang belum punya wisata tidak error
            // onDelete('set null') -> Jika wisata dihapus, kulinernya tetap ada (hanya lepas relasinya)
            $table->foreignId('wisata_id')->nullable()->constrained('wisatas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kuliner', function (Blueprint $table) {
            $table->dropForeign(['wisata_id']);
            $table->dropColumn('wisata_id');
        });
    }
};