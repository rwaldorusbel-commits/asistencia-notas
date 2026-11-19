<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // La columna y la llave foránea ya existen; solo se agrega el unique.
        Schema::table('asis_estudiantes', function (Blueprint $table) {
            $table->unique('user_id');
        });
    }

    public function down(): void
    {
        Schema::table('asis_estudiantes', function (Blueprint $table) {
            $table->dropUnique(['user_id']);
        });
    }
};
