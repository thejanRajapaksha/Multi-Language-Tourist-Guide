<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    protected $table = 'support_messages'; // Ensure this matches your database table name

    protected $fillable = ['name', 'email', 'phone', 'message'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
