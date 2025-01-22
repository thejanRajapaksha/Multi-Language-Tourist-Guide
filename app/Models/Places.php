<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Places extends Model
{
    use HasFactory;

    protected $table = 'famous_places'; // Ensure this matches your database table name

    // Specify which attributes are mass assignable
    protected $fillable = [
        'place',
        'description',
        'activities',
        'status',
    ];

    public function images()
    {
        return $this->hasMany(PlaceImage::class, 'place_id'); // Reference to PlaceImage model
    }
}