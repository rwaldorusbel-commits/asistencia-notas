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

            // De la migración original (A)
            $table->string('descripcion', 100)->nullable();   // Ej: Examen parcial, Tarea 1
            $table->decimal('peso', 5, 2)->default(100);      // Porcentaje para promedio ponderado

            // De la migración posterior (B)
            $table->string('tipo', 50)->nullable();           // Examen, Tarea, etc.

            // Columna común: se toma la versión más permisiva (decimal 5,2 nullable)
            $table->decimal('valor', 5, 2)->nullable();       // La nota (escala 0 a 20)

            $table->date('fecha')->nullable();
            $table->text('observacion')->nullable();          // text es más flexible que string

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asis_notas');
    }
};
