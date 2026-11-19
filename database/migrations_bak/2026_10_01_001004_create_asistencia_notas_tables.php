<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asis_notas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('matricula_id')->constrained('asis_matriculas')->cascadeOnDelete();
            $table->foreignId('asignacion_id')->constrained('asis_asignaciones')->cascadeOnDelete();
            $table->string('descripcion', 100);          // Ej: Examen parcial, Tarea 1
            $table->decimal('valor', 4, 2);              // Ej: 15.50 (escala 0 a 20)
            $table->decimal('peso', 5, 2)->default(100); // Porcentaje para el promedio ponderado
            $table->date('fecha')->nullable();
            $table->text('observacion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asis_notas');
    }
};
