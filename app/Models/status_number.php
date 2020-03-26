<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class status_number extends Model
{
    
    protected $table = 'status_number';

    protected $fillable = [
        'description',
        'active'
    ];
    
}
