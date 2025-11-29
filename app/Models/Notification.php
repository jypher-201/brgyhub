<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'report_id',
        'suggestion_id',
        'message',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function report()
    {
        return $this->belongsTo(IssueReport::class, 'report_id');
    }

    public function suggestion()
    {
        return $this->belongsTo(Suggestion::class, 'suggestion_id');
    }

    public function markAsRead()
    {
        $this->update(['status' => 'Read']);
    }
}