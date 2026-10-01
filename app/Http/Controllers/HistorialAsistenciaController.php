<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use App\Models\Asistencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class HistorialAsistenciaController extends Controller
{ public function index(Request $request) { $usuario = Auth::user();
 $esAdmin = $usuario && $usuario->rol === 'admin';
 $asignaciones = Asignacion::with([ 'curso', 'seccion.grado', 'seccion.periodo' ]) ->when( ! $esAdmin, fn ($q) => $q->where('docente_id', Auth::id()) ) ->get();
  $request->validate([ 'desde' => ['nullable', 'date'], 'hasta' => ['nullable', 'date', 'after_or_equal:desde'], ]); $base = Asistencia::query() ->whereIn('asignacion_id', $asignaciones->pluck('id')) ->when( $request->asignacion_id, fn ($q, $v) => $q->where('asignacion_id', $v) ) ->when
  ( $request->q, fn ($q, $t) => $q->whereHas( 'matricula.estudiante', fn ($e) => $e ->where('nombres', 'like', "%$t%") ->orWhere('apellidos', 'like', "%$t%") ->orWhere('codigo', 'like', "%$t%") ) ) ->when( $request->desde, fn ($q, $v) => $q->whereDate('fecha', '>=', $v) ) ->when( $request->hasta, fn ($q, $v) => $q->whereDate('fecha', '<=', $v) ); $resumen = (clone $base) ->select( 'estado', DB::raw('COUNT(*) as total') ) ->groupBy('estado') ->pluck('total', 'estado');
   $total = $resumen->sum(); $porcentaje = $total > 0 ? round( ( ($resumen['presente'] ?? 0) + ($resumen['tarde'] ?? 0) ) * 100 / $total, 1 ) : null; $registros = $base ->with([ 'matricula.estudiante', 'asignacion.curso', 'asignacion.seccion.grado', 'justificacion' ]) ->orderByDesc('fecha') ->orderByDesc('id') ->paginate(15) ->withQueryString(); return view( 'historial.index', compact( 'asignaciones', 'registros', 'resumen', 'total', 'porcentaje' ) ); }
}
