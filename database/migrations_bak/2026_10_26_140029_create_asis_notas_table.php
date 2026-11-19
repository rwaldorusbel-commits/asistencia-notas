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
            $table->string('tipo', 50)->nullable();          // Examen, Tarea, etc.
            $table->decimal('valor', 5, 2)->nullable();      // la nota
            $table->date('fecha')->nullable();
            $table->string('observacion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asis_notas');
    }
};
