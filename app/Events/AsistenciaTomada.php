<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AsistenciaTomada implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $cursoId;
    public $mensaje;

    public function __construct($cursoId, $mensaje)
    {
        $this->cursoId = $cursoId;
        $this->mensaje = $mensaje;
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('asistencias-global'),
        ];
    }

    // ⬇️ ESTO ES LO QUE FALTABA ⬇️
    public function broadcastAs(): string
    {
        return 'AsistenciaTomada';
    }
}
