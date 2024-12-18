<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserManual extends Model
{
    protected $fillable = [
        'title',
        'url',
        'sequence',
    ];

    protected $casts = [
        'sequence' => 'integer',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->where('title', 'like', "%$search%");
    }
}
