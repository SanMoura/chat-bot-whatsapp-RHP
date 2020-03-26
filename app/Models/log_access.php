<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class log_access extends Model
{
    protected $table = 'log_access';

    protected $fillable = [
        'number',
        'status_number_id',
        'menu_id',
        'xml',
        'active',
        'cd_atendimento',
    ];


}
