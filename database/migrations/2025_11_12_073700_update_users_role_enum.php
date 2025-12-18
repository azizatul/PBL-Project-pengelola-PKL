<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ensure the enum contains 'perusahaan' to avoid truncation warnings
        DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('mahasiswa','dosen','admin','kaprodi','perusahaan') NOT NULL DEFAULT 'mahasiswa'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to previous set without 'perusahaan' if needed
        DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('mahasiswa','dosen','admin','kaprodi') NOT NULL DEFAULT 'mahasiswa'");
    }
};
