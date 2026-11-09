@extends('layouts.panel')
@section('titulo', 'Mis cursos')
@section('contenido')

<style>
    .mc { --indigo-600:#4c49b8; --indigo-700:#3f3d9a; --ink:#1c1b33; --muted:#6b6a85; --line:#dcdbe8; max-width: 980px; color: var(--ink); }
    .mc-head h1 { margin: 0 0 4px; font-family: "Source Serif 4", Georgia, serif; font-size: 30px; font-weight: 600; letter-spacing: -0.01em; }
    .mc-head p { margin: 0; color: var(--muted); }

    .mc-student {
        display: flex; align-items: center; gap: 16px;
        margin: 24px 0 28px; padding: 18px 22px;
        background: #fff; border: 1px solid var(--line); border-radius: 14px;
        box-shadow: 0 1px 2px rgba(43,42,107,.06), 0 8px 24px rgba(43,42,107,.06);
    }
    .mc-avatar {
        flex: none; width: 46px; height: 46px; border-radius: 50%;
        display: grid; place-items: center;
        background: linear-gradient(180deg, var(--indigo-600), var(--indigo-700));
        color: #fff; font-weight: 600; font-size: 16px;
    }
    .mc-student strong { display: block; font-size: 16px; }
    .mc-student span { color: var(--muted); font-size: 14px; }

    .mc-title { margin: 0 0 14px; font-size: 17px; font-weight: 600; }
    .mc-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(290px, 1fr)); gap: 16px; }

    .mc-card {
        background: #fff; border: 1px solid var(--line); border-radius: 14px;
        padding: 20px 22px;
        border-left: 4px solid var(--indigo-600);
        box-shadow: 0 1px 2px rgba(43,42,107,.05);
    }
    .mc-card h3 { margin: 0 0 14px; font-size: 17px; font-weight: 600; }
    .mc-row { display: flex; justify-content: space-between; align-items: center; gap: 12px; padding: 9px 0; border-top: 1px solid #eceaf4; font-size: 14px; }
    .mc-row dt { color: var(--muted); }
    .mc-row dd { margin: 0; font-weight: 500; text-align: right; }

    .mc-badge { display: inline-block; padding: 3px 11px; border-radius: 999px; font-size: 13px; font-weight: 500; background: #eceaf4; color: #4a4965; }
    .mc-badge.ok  { background: #e3f4ea; color: #1d6b3d; }
    .mc-badge.off { background: #fbe7e7; color: #9b2c2c; }

    .mc-empty { padding: 40px 24px; text-align: center; background: #fff; border: 1px dashed #c4c3d8; border-radius: 14px; color: var(--muted); }
    .mc-empty strong { display: block; margin-bottom: 4px; color: var(--ink); font-size: 16px; }
</style>

<div class="mc">
    <header class="mc-head">
        <h1>Mis cursos</h1>
        <p>Cursos en los que estás matriculado.</p>
    </header>

    <div class="mc-student">
        <div class="mc-avatar">
            {{ strtoupper(mb_substr($estudiante->nombres, 0, 1) . mb_substr($estudiante->apellidos, 0, 1)) }}
        </div>
        <div>
            <strong>{{ $estudiante->nombres }} {{ $estudiante->apellidos }}</strong>
            <span>Código de estudiante: {{ $estudiante->codigo }}</span>
        </div>
    </div>

    <h2 class="mc-title">Matrículas</h2>

    @forelse($matriculas as $m)
        @if ($loop->first)
            <div class="mc-grid">
        @endif

        @php
            $estado = strtolower($m->estado);
            $clase = in_array($estado, ['activa', 'activo', 'matriculado', 'matriculada']) ? 'ok'
                   : (in_array($estado, ['retirado', 'retirada', 'inactivo', 'inactiva', 'anulada']) ? 'off' : '');
        @endphp

        <article class="mc-card">
            <h3>{{ $m->seccion->nombre ?? 'Sección #'.$m->seccion_id }}</h3>
            <dl style="margin:0;">
                <div class="mc-row">
                    <dt>Periodo</dt>
                    <dd>{{ $m->periodo->nombre ?? '-' }}</dd>
                </div>
                <div class="mc-row">
                    <dt>Estado</dt>
                    <dd><span class="mc-badge {{ $clase }}">{{ ucfirst($m->estado) }}</span></dd>
                </div>
            </dl>
        </article>

        @if ($loop->last)
            </div>
        @endif
    @empty
        <div class="mc-empty">
            <strong>Aún no tienes cursos</strong>
            Cuando te matriculen en una sección, aparecerá aquí.
        </div>
    @endforelse
</div>

@endsection
