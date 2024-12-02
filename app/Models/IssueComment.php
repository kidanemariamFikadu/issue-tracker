<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IssueComment extends Model
{
    protected $fillable =[
        'issue_report_id',
        'comment',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at',
    ];

    public function issueReport()
    {
        return $this->belongsTo(IssueReport::class);
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

    public function attachments()
    {
        return $this->hasMany(CommentAttachment::class);
    }
}
