<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('asis_justificaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asistencia_id')->unique()->constrained('asis_asistencias')->cascadeOnDelete();
            $table->string('estado_original', 20);
            $table->string('motivo', 500);
            $table->foreignId('registrado_por')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('asis_justificaciones');
    }
};
