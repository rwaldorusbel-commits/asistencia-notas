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
    Schema::create('asis_asistencias', function (Blueprint $table) {
        $table->id();
        $table->foreignId('asignacion_id')->constrained('asis_asignaciones')->cascadeOnDelete();
        $table->foreignId('matricula_id')->constrained('asis_matriculas')->cascadeOnDelete();
        $table->date('fecha');
        $table->string('estado', 20); // presente, ausente, tardanza, justificado
        $table->string('observacion')->nullable();
        $table->timestamps();

        $table->unique(['asignacion_id', 'matricula_id', 'fecha']);
    });
}

public function down(): void
{
    Schema::dropIfExists('asis_asistencias');
}
};
