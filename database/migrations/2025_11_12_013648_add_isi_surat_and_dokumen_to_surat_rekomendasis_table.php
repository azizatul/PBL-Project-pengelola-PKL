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
        Schema::table('surat_rekomendasis', function (Blueprint $table) {
            $table->text('isi_surat')->nullable()->after('tanggal_surat');
            $table->string('dokumen')->nullable()->after('catatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_rekomendasis', function (Blueprint $table) {
            $table->dropColumn(['isi_surat', 'dokumen']);
        });
    }
};
