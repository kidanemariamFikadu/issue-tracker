<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'category_id',
        'issue',
        'description',
        'status',
        'priority',
        'assigned_to',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at',
        'agent_id',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function comments()
    {
        return $this->hasMany(IssueComment::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function agent()
    {
        return $this->belongsTo(LershaAgent::class);
    }

    public function scopeSearch($query, $value)
    {
        $query->where('issue', 'like', "%{$value}%"); 
    }
}
