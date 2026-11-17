<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OA;

class CursoController extends Controller
{
    private function reglas(?Curso $curso = null): array
    {
        return [
            'codigo'      => ['required', 'string', 'max:20',
                Rule::unique('asis_cursos', 'codigo')->ignore($curso?->id)],
            'nombre'      => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string', 'max:1000'],
        ];
    }

    #[OA\Get(
        path: "/cursos",
        summary: "Listado de cursos (paginado de 10 en 10, ordenado por nombre)",
        tags: ["Cursos"],
        parameters: [
            new OA\Parameter(name: "page", in: "query", required: false, description: "Número de página", schema: new OA\Schema(type: "integer", example: 1)),
        ],
        responses: [
            new OA\Response(response: 200, description: "Vista con el listado de cursos"),
        ]
    )]
    public function index()
    {
        $cursos = Curso::orderBy('nombre')->paginate(10);

        return view('cursos.index', compact('cursos'));
    }

    #[OA\Get(
        path: "/cursos/create",
        summary: "Formulario para crear un curso",
        tags: ["Cursos"],
        responses: [
            new OA\Response(response: 200, description: "Vista del formulario de creación"),
        ]
    )]
    public function create()
    {
        return view('cursos.create');
    }

    #[OA\Post(
        path: "/cursos",
        summary: "Crear un curso",
        tags: ["Cursos"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: "application/x-www-form-urlencoded",
                schema: new OA\Schema(
                    required: ["codigo", "nombre"],
                    properties: [
                        new OA\Property(property: "codigo", type: "string", maxLength: 20, example: "MAT101"),
                        new OA\Property(property: "nombre", type: "string", maxLength: 255, example: "Matemática I"),
                        new OA\Property(property: "descripcion", type: "string", maxLength: 1000, nullable: true, example: "Curso introductorio"),
                        new OA\Property(property: "activo", type: "boolean", example: true),
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(response: 302, description: "Redirige a cursos.index con mensaje de éxito"),
            new OA\Response(response: 422, description: "Error de validación (por ejemplo, código duplicado)"),
        ]
    )]
    public function store(Request $request)
    {
        $datos = $request->validate($this->reglas());
        $datos['activo'] = $request->boolean('activo');

        Curso::create($datos);

        return redirect()->route('cursos.index')->with('ok', 'Curso creado correctamente.');
    }

    #[OA\Get(
        path: "/cursos/{curso}/edit",
        summary: "Formulario para editar un curso",
        tags: ["Cursos"],
        parameters: [
            new OA\Parameter(name: "curso", in: "path", required: true, description: "ID del curso", schema: new OA\Schema(type: "integer", example: 1)),
        ],
        responses: [
            new OA\Response(response: 200, description: "Vista del formulario de edición"),
            new OA\Response(response: 404, description: "Curso no encontrado"),
        ]
    )]
    public function edit(Curso $curso)
    {
        return view('cursos.edit', compact('curso'));
    }

    #[OA\Put(
        path: "/cursos/{curso}",
        summary: "Actualizar un curso",
        tags: ["Cursos"],
        parameters: [
            new OA\Parameter(name: "curso", in: "path", required: true, description: "ID del curso", schema: new OA\Schema(type: "integer", example: 1)),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: "application/x-www-form-urlencoded",
                schema: new OA\Schema(
                    required: ["codigo", "nombre"],
                    properties: [
                        new OA\Property(property: "codigo", type: "string", maxLength: 20, example: "MAT101"),
                        new OA\Property(property: "nombre", type: "string", maxLength: 255, example: "Matemática I"),
                        new OA\Property(property: "descripcion", type: "string", maxLength: 1000, nullable: true, example: "Curso introductorio"),
                        new OA\Property(property: "activo", type: "boolean", example: true),
                    ]
                )
            )
        ),
        responses: [
            new OA\Response(response: 302, description: "Redirige a cursos.index con mensaje de éxito"),
            new OA\Response(response: 404, description: "Curso no encontrado"),
            new OA\Response(response: 422, description: "Error de validación"),
        ]
    )]
    public function update(Request $request, Curso $curso)
    {
        $datos = $request->validate($this->reglas($curso));
        $datos['activo'] = $request->boolean('activo');

        $curso->update($datos);

        return redirect()->route('cursos.index')->with('ok', 'Curso actualizado.');
    }

    #[OA\Delete(
        path: "/cursos/{curso}",
        summary: "Eliminar un curso (no permite si está asignado a docentes)",
        tags: ["Cursos"],
        parameters: [
            new OA\Parameter(name: "curso", in: "path", required: true, description: "ID del curso", schema: new OA\Schema(type: "integer", example: 1)),
        ],
        responses: [
            new OA\Response(response: 302, description: "Redirige a cursos.index con mensaje de éxito, o regresa con error si el curso está en uso"),
            new OA\Response(response: 404, description: "Curso no encontrado"),
        ]
    )]
    public function destroy(Curso $curso)
    {
        // Se activa cuando exista la tabla de asignaciones (RF07)
        $enUso = Schema::hasTable('asis_asignaciones')
            && DB::table('asis_asignaciones')->where('curso_id', $curso->id)->exists();

        if ($enUso) {
            return back()->withErrors(['general' => 'No se puede eliminar: el curso ya está asignado a docentes. Desactívalo en su lugar.']);
        }

        $curso->delete();

        return redirect()->route('cursos.index')->with('ok', 'Curso eliminado.');
    }
}
