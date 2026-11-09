<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailSetting extends Model
{
    protected $fillable = ['host', 'port', 'username', 'password', 'from_address', 'from_name'];

    protected $hidden = ['password'];

    protected $casts = [
        'port'     => 'integer',
        'password' => 'encrypted',
    ];
}
