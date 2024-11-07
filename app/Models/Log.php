<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $table = 'logs';

    protected $fillable = [
        'url',
        'origin',
        'method',
        'request_body',
        'dt_log'
    ];

    public $timestamps = false;

}
