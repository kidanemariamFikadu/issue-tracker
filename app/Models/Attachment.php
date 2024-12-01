<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable=[
        'issue_report_id',
        'url'
    ];

    public function issueReport()
    {
        return $this->belongsTo(IssueReport::class);
    }
}
