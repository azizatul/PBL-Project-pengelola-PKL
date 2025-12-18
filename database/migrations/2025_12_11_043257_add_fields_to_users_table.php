<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('nim')->nullable();
        $table->string('program_studi')->nullable();
        $table->string('phone')->nullable();
        $table->string('foto')->nullable();
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['nim', 'program_studi', 'phone', 'role']);
    });
}

};
