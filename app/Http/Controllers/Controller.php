<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: "Sistema de Asistencia y Notas",
    version: "1.0.0",
    description: "Documentación del sistema"
)]
#[OA\Server(url: "http://localhost:8000", description: "Servidor local")]
abstract class Controller
{
    //
}
