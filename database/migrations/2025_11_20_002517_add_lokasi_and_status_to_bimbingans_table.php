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
        Schema::table('bimbingans', function (Blueprint $table) {
            $table->string('lokasi')->nullable()->after('catatan');
            $table->enum('status', ['pending', 'approved', 'completed', 'cancelled'])->default('pending')->after('lokasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bimbingans', function (Blueprint $table) {
            $table->dropColumn(['lokasi', 'status']);
        });
    }
};
