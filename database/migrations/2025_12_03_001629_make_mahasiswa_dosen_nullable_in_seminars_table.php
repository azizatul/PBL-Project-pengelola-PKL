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
        // Make dosen_id nullable to allow creating seminars before assigning a dosen
        // Use raw statements to be resilient to missing constraints
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE seminars DROP FOREIGN KEY IF EXISTS seminars_dosen_id_foreign');
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE seminars MODIFY dosen_id BIGINT UNSIGNED NULL');
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE seminars ADD CONSTRAINT seminars_dosen_id_foreign FOREIGN KEY (dosen_id) REFERENCES dosens(id) ON DELETE CASCADE');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE seminars DROP FOREIGN KEY IF EXISTS seminars_dosen_id_foreign');
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE seminars MODIFY dosen_id BIGINT UNSIGNED NOT NULL');
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE seminars ADD CONSTRAINT seminars_dosen_id_foreign FOREIGN KEY (dosen_id) REFERENCES dosens(id) ON DELETE CASCADE');
    }
};
