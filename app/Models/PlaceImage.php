<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaceImage extends Model
{
    use HasFactory;

    protected $table = 'place_images'; // Ensure this matches your database table name

    // Specify which attributes are mass assignable
    protected $fillable = [
        'place_id', 
        'image_path',
    ];

    public function place()
    {
        return $this->belongsTo(Places::class, 'place_id'); // Correct usage
    }
}