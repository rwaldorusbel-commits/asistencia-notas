@extends('layouts.panel')
@section('titulo', 'Mi asistencia')
@section('contenido')

<style>
    .ma { --indigo-600:#4c49b8; --indigo-700:#3f3d9a; --ink:#1c1b33; --muted:#6b6a85; --line:#dcdbe8; max-width: 980px; color: var(--ink); }
    .ma-head h1 { margin: 0 0 4px; font-family: "Source Serif 4", Georgia, serif; font-size: 30px; font-weight: 600; letter-spacing: -0.01em; }
    .ma-head p { margin: 0; color: var(--muted); }

    .ma-student {
        display: flex; align-items: center; gap: 16px;
        margin: 24px 0 20px; padding: 18px 22px;
        background: #fff; border: 1px solid var(--line); border-radius: 14px;
        box-shadow: 0 1px 2px rgba(43,42,107,.06), 0 8px 24px rgba(43,42,107,.06);
    }
    .ma-avatar {
        flex: none; width: 46px; height: 46px; border-radius: 50%;
        display: grid; place-items: center;
        background: linear-gradient(180deg, var(--indigo-600), var(--indigo-700));
        color: #fff; font-weight: 600; font-size: 16px;
    }
    .ma-student strong { display: block; font-size: 16px; }
    .ma-student span { color: var(--muted); font-size: 14px; }

    /* Resumen */
    .ma-summary { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 14px; margin-bottom: 28px; }
    .ma-stat {
        background: #fff; border: 1px solid var(--line); border-radius: 14px;
        padding: 16px 20px; border-top: 3px solid #c9c8da;
        box-shadow: 0 1px 2px rgba(43,42,107,.05);
    }
    .ma-stat .n { display: block; font-family: "Source Serif 4", Georgia, serif; font-size: 30px; font-weight: 600; line-height: 1.1; }
    .ma-stat .t { color: var(--muted); font-size: 14px; }
    .ma-stat.ok   { border-top-color: #2f9e5f; }
    .ma-stat.warn { border-top-color: #d99a1c; }
    .ma-stat.off  { border-top-color: #c94848; }

    /* Tabla */
    .ma-title { margin: 0 0 14px; font-size: 17px; font-weight: 600; }
    .ma-table-wrap {
        background: #fff; border: 1px solid var(--line); border-radius: 14px;
        overflow-x: auto;
        box-shadow: 0 1px 2px rgba(43,42,107,.06), 0 8px 24px rgba(43,42,107,.06);
    }
    .ma-table { width: 100%; border-collapse: collapse; font-size: 14.5px; }
    .ma-table th {
        text-align: left; padding: 13px 20px; font-weight: 600; font-size: 13.5px; color: var(--muted);
        background: #faf9fd; border-bottom: 1px solid var(--line); white-space: nowrap;
    }
    .ma-table td { padding: 14px 20px; border-bottom: 1px solid #eceaf4; vertical-align: middle; }
    .ma-table tbody tr:last-child td { border-bottom: 0; }
    .ma-table tbody tr:hover { background: #fbfbfe; }
    .ma-date { font-weight: 500; white-space: nowrap; }
    .ma-muted { color: var(--muted); }

    .ma-badge { display: inline-block; padding: 3px 11px; border-radius: 999px; font-size: 13px; font-weight: 500; background: #eceaf4; color: #4a4965; }
    .ma-badge.ok   { background: #e3f4ea; color: #1d6b3d; }
    .ma-badge.warn { background: #fdf2d9; color: #8a5a06; }
    .ma-badge.off  { background: #fbe7e7; color: #9b2c2c; }

    .ma-empty { padding: 44px 24px !important; text-align: center; color: var(--muted); }
    .ma-empty strong { display: block; margin-bottom: 4px; color: var(--ink); font-size: 16px; }
</style>

@php
    $tono = function ($estado) {
        $e = strtolower($estado);
        if (in_array($e, ['presente', 'asistio', 'asistió', 'puntual'])) return 'ok';
        if (in_array($e, ['tardanza', 'tarde', 'justificado', 'justificada', 'permiso'])) return 'warn';
        if (in_array($e, ['falta', 'ausente', 'inasistencia'])) return 'off';
        return '';
    };
@endphp

<div class="ma">
    <header class="ma-head">
        <h1>Mi asistencia</h1>
        <p>Registro de tus asistencias por fecha.</p>
    </header>

    <div class="ma-student">
        <div class="ma-avatar">
            {{ strtoupper(mb_substr($estudiante->nombres, 0, 1) . mb_substr($estudiante->apellidos, 0, 1)) }}
        </div>
        <div>
            <strong>{{ $estudiante->nombres }} {{ $estudiante->apellidos }}</strong>
            <span>Código de estudiante: {{ $estudiante->codigo }}</span>
        </div>
    </div>

    @if (count($resumen))
        <div class="ma-summary">
            @foreach($resumen as $estado => $total)
                <div class="ma-stat {{ $tono($estado) }}">
                    <span class="n">{{ $total }}</span>
                    <span class="t">{{ ucfirst($estado) }}</span>
                </div>
            @endforeach
        </div>
    @endif

    <h2 class="ma-title">Detalle de asistencias</h2>

    <div class="ma-table-wrap">
        <table class="ma-table">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Observación</th>
                    <th>Justificación</th>
                </tr>
            </thead>
            <tbody>
                @forelse($asistencias as $a)
                    <tr>
                        <td class="ma-date">{{ $a->fecha->format('d/m/Y') }}</td>
                        <td><span class="ma-badge {{ $tono($a->estado) }}">{{ ucfirst($a->estado) }}</span></td>
                        <td class="{{ $a->observacion ? '' : 'ma-muted' }}">{{ $a->observacion ?: '-' }}</td>
                        <td>
                            @if($a->justificacion)
                                <span class="ma-badge warn">Justificada</span>
                            @else
                                <span class="ma-muted">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="ma-empty">
                            <strong>Sin registros por ahora</strong>
                            Tus asistencias aparecerán aquí cuando tus docentes las registren.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
