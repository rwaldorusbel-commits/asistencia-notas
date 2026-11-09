<?php

use App\Http\Controllers\ApoderadoPanelController;
use App\Http\Controllers\AsignacionController;
use App\Http\Controllers\AsistenciaController;
use App\Http\Controllers\AvisoController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\EstudiantePanelController;
use App\Http\Controllers\HistorialAsistenciaController;
use App\Http\Controllers\JustificacionController;
use App\Http\Controllers\MailSettingController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PeriodoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SeccionController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth')->group(function () {
//     Route::get('/ajustes/aviso', [AvisoController::class, 'formulario'])->name('aviso.form');
//     Route::post('/ajustes/aviso', [AvisoController::class, 'enviar'])->name('aviso.enviar');
// });

use App\Http\Controllers\NotaController;

Route::get('notas', [NotaController::class, 'index'])->name('notas.index');
Route::get('notas/{asignacion}', [NotaController::class, 'show'])->name('notas.show');
Route::post('notas/{asignacion}', [NotaController::class, 'store'])->name('notas.store');
Route::delete('notas/{nota}/eliminar', [NotaController::class, 'destroy'])->name('notas.destroy');

Route::middleware('guest')->group(function () {
    Route::get('/olvide-contrasena', [PasswordResetController::class, 'formCorreo'])->name('password.request');
    Route::post('/olvide-contrasena', [PasswordResetController::class, 'enviarEnlace'])->name('password.email');
    Route::get('/restablecer-contrasena/{token}', [PasswordResetController::class, 'formReset'])->name('password.reset');
    Route::post('/restablecer-contrasena', [PasswordResetController::class, 'actualizar'])->name('password.reset.update');
});

Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::get('/dashboard', function () {
    if (Auth::user()->rol === 'estudiante') {
        return redirect()->route('estudiante.asistencia');
    }

    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Cualquier usuario con sesión
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

    Route::resource('docentes', DocenteController::class)->except('show');
    Route::resource('periodos', PeriodoController::class)->except('show');
    Route::resource('secciones', SeccionController::class)
        ->parameters(['secciones' => 'seccion'])
        ->except('show');
    Route::resource('asignaciones', AsignacionController::class)
        ->parameters(['asignaciones' => 'asignacion'])
        ->except('show');
});

// Administrador y docente
Route::middleware(['auth', 'rol:admin,docente'])->group(function () {
    Route::resource('cursos', CursoController::class)->except('show');
    Route::resource('estudiantes', EstudianteController::class)->except('show');
    Route::resource('matriculas', MatriculaController::class)->except('show');

    Route::get('asistencia/tomar', [AsistenciaController::class, 'create'])->name('asistencia.create');
    Route::post('asistencia/tomar', [AsistenciaController::class, 'store'])->name('asistencia.store');
    Route::get('historial', [HistorialAsistenciaController::class, 'index'])->name('historial.index');

    Route::get('asistencias/{asistencia}/justificar', [JustificacionController::class, 'create'])->name('justificaciones.create');
    Route::post('asistencias/{asistencia}/justificar', [JustificacionController::class, 'store'])->name('justificaciones.store');
    Route::delete('asistencias/{asistencia}/justificar', [JustificacionController::class, 'destroy'])->name('justificaciones.destroy');
});

// Estudiante
Route::middleware(['auth', 'rol:estudiante'])
    ->prefix('estudiante')
    ->name('estudiante.')
    ->group(function () {
        Route::get('/cursos', [EstudiantePanelController::class, 'cursos'])->name('cursos');
        Route::get('/notas', [EstudiantePanelController::class, 'notas'])->name('notas');
        Route::get('/asistencia', [EstudiantePanelController::class, 'asistencia'])->name('asistencia');
    });

// Apoderado
Route::middleware(['auth', 'rol:apoderado'])
    ->prefix('apoderado')
    ->name('apoderado.')
    ->group(function () {
        Route::get('/hijos', [ApoderadoPanelController::class, 'hijos'])->name('hijos');
        Route::get('/asistencia', [ApoderadoPanelController::class, 'asistencia'])->name('asistencia');
        Route::get('/notas', [ApoderadoPanelController::class, 'notas'])->name('notas');
    });

Route::middleware(['auth'])->group(function () {
    Route::get('/ajustes/correo', [MailSettingController::class, 'edit']);
    Route::post('/ajustes/correo', [MailSettingController::class, 'update']);
});

require __DIR__.'/auth.php';
