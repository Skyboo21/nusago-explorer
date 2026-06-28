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
        Schema::create('kuliner', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kuliner');
            $table->text('deskripsi_kuliner')->nullable();
            $table->string('daerah', 100)->nullable();
            $table->enum('kategori', ['restoran', 'kafe', 'street_food', 'tradisional'])->default('restoran');
            $table->integer('harga_estimasi')->nullable();
            $table->string('gambar_kuliner')->nullable();
            $table->decimal('latitude', 10, 8)->nullable(); 
            $table->decimal('longitude', 11, 8)->nullable();
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->boolean('is_halal')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kuliner');
    }
};