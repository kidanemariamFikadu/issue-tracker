<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentAttachment extends Model
{
    protected $fillable = ['issue_comment_id', 'url'];

    public function comment()
    {
        return $this->belongsTo(IssueComment::class);
    }
}
