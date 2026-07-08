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
            $table->string('jam_operasional')->nullable()->after('rating');
            $table->string('link_maps')->nullable()->after('jam_operasional');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kuliner', function (Blueprint $table) {
            $table->dropColumn(['jam_operasional', 'link_maps']);
        });
    }
};
