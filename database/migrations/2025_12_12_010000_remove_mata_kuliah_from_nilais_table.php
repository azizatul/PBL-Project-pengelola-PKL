<?php

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
        if (Schema::hasColumn('nilais', 'mata_kuliah')) {
            Schema::table('nilais', function (Blueprint $table) {
                $table->dropColumn('mata_kuliah');
            });
        }

        // Restrict kategori to only 'pkl'
        DB::statement("ALTER TABLE `nilais` MODIFY `kategori` ENUM('pkl') NOT NULL DEFAULT 'pkl'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Re-add mata_kuliah as nullable string
        if (!Schema::hasColumn('nilais', 'mata_kuliah')) {
            Schema::table('nilais', function (Blueprint $table) {
                $table->string('mata_kuliah')->nullable()->after('dosen_id');
            });
        }

        // Revert kategori enum to include mata_kuliah
        DB::statement("ALTER TABLE `nilais` MODIFY `kategori` ENUM('mata_kuliah','pkl') NOT NULL DEFAULT 'mata_kuliah'");
    }
};
