<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'category',
        'location',
        'photos', 
        'status',
        'admin_remarks', 
    ];

    protected $casts = [
        'photos' => 'array', 
    ];

    /**
     * Accessor to clean photo paths (replace backslashes with forward slashes)
     * The cast will handle JSON decoding, we just clean the paths
     *
     * @param mixed $value
     * @return array
     */
    public function getPhotosAttribute($value)
    {
        // Get the value from the casts (which handles JSON decoding)
        $photos = $this->castAttribute('photos', $value);
        
        // If it's still a string (cast didn't work), decode manually
        if (is_string($photos)) {
            $photos = json_decode($photos, true) ?? [];
        }
        
        // Ensure we have an array
        if (!is_array($photos)) {
            return [];
        }

        // Clean the paths (replace backslashes with forward slashes)
        return array_map(function($path) {
            return is_string($path) ? str_replace('\\', '/', $path) : $path;
        }, $photos);
    }

    // Define the relationship to the user (reporter)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}