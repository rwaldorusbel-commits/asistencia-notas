<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // RF03: periodos académicos
        if (!Schema::hasTable('asis_periodos')) {
            Schema::create('asis_periodos', function (Blueprint $table) {
                $table->id();
                $table->string('nombre');                    // 2026-I, 2026 Bimestre 1...
                $table->unsignedSmallInteger('anio');
                $table->enum('tipo', ['anual', 'semestre', 'bimestre'])->default('semestre');
                $table->date('fecha_inicio');
                $table->date('fecha_fin');
                $table->boolean('activo')->default(true);
                $table->boolean('notas_cerradas')->default(false);   // RF15
                $table->timestamps();

                $table->unique(['nombre', 'anio']);
            });
        }

        // RF04: cursos
        if (!Schema::hasTable('asis_cursos')) {
            Schema::create('asis_cursos', function (Blueprint $table) {
                $table->id();
                $table->string('codigo', 20)->unique();
                $table->string('nombre');
                $table->text('descripcion')->nullable();
                $table->boolean('activo')->default(true);
                $table->timestamps();
            });
        }

        // RF05: grados
        if (!Schema::hasTable('asis_grados')) {
            Schema::create('asis_grados', function (Blueprint $table) {
                $table->id();
                $table->string('nombre');                    // 1ro, 2do, 3ro...
                $table->unsignedTinyInteger('orden')->default(1);
                $table->boolean('activo')->default(true);
                $table->timestamps();

                $table->unique('nombre');
            });
        }

        // RF05: secciones (un grado + una letra, dentro de un periodo)
        if (!Schema::hasTable('asis_secciones')) {
            Schema::create('asis_secciones', function (Blueprint $table) {
                $table->id();
                $table->foreignId('grado_id')->constrained('asis_grados')->restrictOnDelete();
                $table->foreignId('periodo_id')->constrained('asis_periodos')->restrictOnDelete();
                $table->string('nombre', 20);                // A, B, C
                $table->unsignedSmallInteger('capacidad')->default(40);
                $table->boolean('activo')->default(true);
                $table->timestamps();

                $table->unique(['grado_id', 'periodo_id', 'nombre']);
            });
        }

        // RF06: apoderados
        if (!Schema::hasTable('asis_apoderados')) {
            Schema::create('asis_apoderados', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
                $table->string('nombres');
                $table->string('apellidos');
                $table->string('dni', 15)->nullable()->unique();
                $table->string('telefono', 20)->nullable();
                $table->string('email')->nullable();         // RF19: notificaciones
                $table->timestamps();
            });
        }

        // RF06: estudiantes
        if (!Schema::hasTable('asis_estudiantes')) {
            Schema::create('asis_estudiantes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
                $table->foreignId('apoderado_id')->nullable()->constrained('asis_apoderados')->nullOnDelete();
                $table->string('codigo', 20)->unique();
                $table->string('dni', 15)->nullable()->unique();
                $table->string('nombres');
                $table->string('apellidos');
                $table->date('fecha_nacimiento')->nullable();
                $table->boolean('activo')->default(true);
                $table->timestamps();

                $table->index(['apellidos', 'nombres']);
            });
        }

        // RF06: matrículas (estudiante + sección; el periodo se obtiene de la sección)
        if (!Schema::hasTable('asis_matriculas')) {
            Schema::create('asis_matriculas', function (Blueprint $table) {
                $table->id();
                $table->foreignId('estudiante_id')->constrained('asis_estudiantes')->restrictOnDelete();
                $table->foreignId('seccion_id')->constrained('asis_secciones')->restrictOnDelete();
                $table->foreignId('periodo_id')->constrained('asis_periodos')->restrictOnDelete();
                $table->date('fecha_matricula');
                $table->enum('estado', ['matriculado', 'retirado'])->default('matriculado');
                $table->timestamps();

                // Un estudiante solo puede estar matriculado una vez por periodo
                $table->unique(['estudiante_id', 'periodo_id']);
            });
        }

        // RF07: asignación docente + curso + sección
        if (!Schema::hasTable('asis_asignaciones')) {
            Schema::create('asis_asignaciones', function (Blueprint $table) {
                $table->id();
                $table->foreignId('docente_id')->constrained('users')->restrictOnDelete();
                $table->foreignId('curso_id')->constrained('asis_cursos')->restrictOnDelete();
                $table->foreignId('seccion_id')->constrained('asis_secciones')->restrictOnDelete();
                $table->boolean('activo')->default(true);
                $table->timestamps();

                $table->unique(['curso_id', 'seccion_id']);   // un docente por curso en cada sección
            });
        }
    }

    public function down(): void
    {
        // Solo borra tus tablas, en orden inverso por las llaves foráneas
        Schema::dropIfExists('asis_asignaciones');
        Schema::dropIfExists('asis_matriculas');
        Schema::dropIfExists('asis_estudiantes');
        Schema::dropIfExists('asis_apoderados');
        Schema::dropIfExists('asis_secciones');
        Schema::dropIfExists('asis_grados');
        Schema::dropIfExists('asis_cursos');
        Schema::dropIfExists('asis_periodos');
    }
};
