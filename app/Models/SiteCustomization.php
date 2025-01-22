<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteCustomization extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo_image',
        'about_video',
        'banner_video',
        'main_topic',
        'main_topic2',
        'main_topic3',
        'sub_topic',
        'sub_topic2',
        'sub_topic3',
        'status',
    ];    
}

