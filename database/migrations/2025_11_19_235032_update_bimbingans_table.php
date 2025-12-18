n<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE bimbingans DROP FOREIGN KEY IF EXISTS bimbingans_user_id_foreign');
        DB::statement('ALTER TABLE bimbingans DROP FOREIGN KEY IF EXISTS bimbingans_dosen_id_foreign');
        DB::statement('ALTER TABLE bimbingans DROP FOREIGN KEY IF EXISTS fk_bimbingans_mahasiswa_id');
        DB::statement('ALTER TABLE bimbingans DROP FOREIGN KEY IF EXISTS fk_bimbingans_dosen_id');
        DB::statement('ALTER TABLE bimbingans DROP COLUMN IF EXISTS title, DROP COLUMN IF EXISTS date, DROP COLUMN IF EXISTS time, DROP COLUMN IF EXISTS location, DROP COLUMN IF EXISTS status, DROP COLUMN IF EXISTS user_id, DROP COLUMN IF EXISTS dosen_id');
        DB::statement('ALTER TABLE bimbingans ADD COLUMN IF NOT EXISTS mahasiswa_id BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE bimbingans ADD CONSTRAINT fk_bimbingans_mahasiswa_id FOREIGN KEY (mahasiswa_id) REFERENCES mahasiswas(id) ON DELETE CASCADE');
        DB::statement('ALTER TABLE bimbingans ADD COLUMN IF NOT EXISTS dosen_id BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE bimbingans ADD CONSTRAINT fk_bimbingans_dosen_id FOREIGN KEY (dosen_id) REFERENCES dosens(id) ON DELETE SET NULL');
        DB::statement('ALTER TABLE bimbingans ADD COLUMN IF NOT EXISTS tanggal DATE NOT NULL');
        DB::statement('ALTER TABLE bimbingans ADD COLUMN IF NOT EXISTS waktu_mulai TIME NOT NULL');
        DB::statement('ALTER TABLE bimbingans ADD COLUMN IF NOT EXISTS waktu_selesai TIME NOT NULL');
        DB::statement('ALTER TABLE bimbingans ADD COLUMN IF NOT EXISTS topik VARCHAR(255) NULL');
        DB::statement('ALTER TABLE bimbingans ADD COLUMN IF NOT EXISTS catatan TEXT NULL');
        DB::statement('ALTER TABLE bimbingans ADD COLUMN IF NOT EXISTS calendar_event_id VARCHAR(255) NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE bimbingans DROP COLUMN IF EXISTS mahasiswa_id, DROP COLUMN IF EXISTS dosen_id, DROP COLUMN IF EXISTS tanggal, DROP COLUMN IF EXISTS waktu_mulai, DROP COLUMN IF EXISTS waktu_selesai, DROP COLUMN IF EXISTS topik, DROP COLUMN IF EXISTS catatan, DROP COLUMN IF EXISTS calendar_event_id');
        DB::statement('ALTER TABLE bimbingans ADD COLUMN title VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE bimbingans ADD COLUMN date DATE NOT NULL');
        DB::statement('ALTER TABLE bimbingans ADD COLUMN time TIME NOT NULL');
        DB::statement('ALTER TABLE bimbingans ADD COLUMN location VARCHAR(255) NOT NULL');
        DB::statement('ALTER TABLE bimbingans ADD COLUMN status ENUM(\'pending\', \'approved\', \'rejected\') DEFAULT \'pending\'');
        DB::statement('ALTER TABLE bimbingans ADD COLUMN user_id BIGINT UNSIGNED NOT NULL, ADD CONSTRAINT fk_bimbingans_user_id FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE');
        DB::statement('ALTER TABLE bimbingans ADD COLUMN dosen_id BIGINT UNSIGNED NULL, ADD CONSTRAINT fk_bimbingans_dosen_id FOREIGN KEY (dosen_id) REFERENCES users(id) ON DELETE SET NULL');
    }
};
