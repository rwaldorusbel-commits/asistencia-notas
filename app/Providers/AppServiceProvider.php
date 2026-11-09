<?php

namespace App\Providers;

use App\Models\MailSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
  // Configuración fija: no depende del .env
config([
    'mail.default' => 'smtp',
'mail.mailers.smtp.transport'  => 'smtp',
'mail.mailers.smtp.host'       => 'smtp-relay.brevo.com',
'mail.mailers.smtp.port'       => 587,
'mail.mailers.smtp.encryption' => 'tls',
'mail.mailers.smtp.username'   => 'c225f4001@smtp-brevo.com',
'mail.mailers.smtp.password'   => env('BREVO_SMTP_KEY'),
'mail.from.address'            => 'rwaldorusbel@gmail.com',
'mail.from.name'               => 'asistecia-notas',
]);
        // Si hay datos guardados en /ajustes/correo, esos tienen prioridad
        if (! app()->runningInConsole() && Schema::hasTable('mail_settings')) {
            if ($m = MailSetting::first()) {
                config([
                    'mail.mailers.smtp.username' => $m->username,
                    'mail.mailers.smtp.password' => $m->password,
                    'mail.from.address'          => $m->username,
                    'mail.from.name'             => $m->from_name ?: config('app.name'),
                ]);
            }
        }
    }
}
