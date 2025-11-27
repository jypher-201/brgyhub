<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class IssueReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'category',
        'location',
        'photo',
        'status',
        'admin_remarks',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
