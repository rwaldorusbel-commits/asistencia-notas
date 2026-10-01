<?php
use App\Http\Controllers\CursoController;
use App\Http\Controllers\PeriodoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SeccionController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\AsignacionController;
use App\Http\Controllers\HistorialAsistenciaController;
use App\Http\Controllers\JustificacionController;
use App\Http\Controllers\AsistenciaController;

Route::get('asistencia/tomar', [AsistenciaController::class, 'create'])->name('asistencia.create');
Route::post('asistencia/tomar', [AsistenciaController::class, 'store'])->name('asistencia.store');
Route::get('historial', [HistorialAsistenciaController::class, 'index'])->name('historial.index');

Route::get('asistencias/{asistencia}/justificar', [JustificacionController::class, 'create'])->name('justificaciones.create');
Route::post('asistencias/{asistencia}/justificar', [JustificacionController::class, 'store'])->name('justificaciones.store');
Route::delete('asistencias/{asistencia}/justificar', [JustificacionController::class, 'destroy'])->name('justificaciones.destroy');

Route::resource('docentes', DocenteController::class)->except('show');
Route::resource('cursos', CursoController::class)->except('show');

Route::resource('asignaciones', AsignacionController::class)
    ->parameters(['asignaciones' => 'asignacion'])
    ->except('show');

Route::resource('docentes', DocenteController::class)->except('show');

Route::resource('estudiantes', EstudianteController::class)->except('show');

Route::resource('matriculas', MatriculaController::class)->except('show');

Route::resource('estudiantes', EstudianteController::class)->except('show');


Route::middleware(['auth'])->group(function () {   // tu grupo actual

    Route::resource('periodos', PeriodoController::class)->except('show');

    Route::resource('cursos', CursoController::class)->except('show');

    Route::resource('secciones', SeccionController::class)
        ->parameters(['secciones' => 'seccion'])
        ->except('show');

});

Route::middleware(['auth'])->group(function () {   // el grupo que ya tienes

    Route::resource('periodos', PeriodoController::class)->except('show');

    Route::resource('cursos', CursoController::class)->except('show');   // <- aquí

});

Route::get('/', function () {
   return Auth::check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Solo administrador
Route::middleware(['auth', 'rol:admin'])->group(function () {
    Route::resource('usuarios', UsuarioController::class)
        ->except('show')
        ->parameters(['usuarios' => 'usuario']);

    Route::patch('usuarios/{usuario}/activar', [UsuarioController::class, 'activar'])
        ->name('usuarios.activar');

    Route::resource('periodos', PeriodoController::class)->except('show');
});

require __DIR__.'/auth.php';
