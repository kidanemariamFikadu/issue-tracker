<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LershaAgent extends Model
{
    protected $fillable= [
        'lersha_id',
        'first_name',
        'middle_name',
        'last_name',
        'phone',
    ];
}
