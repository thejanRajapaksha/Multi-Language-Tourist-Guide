<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spending extends Model
{
    use HasFactory;

    protected $table = 'spending_records';

    protected $fillable = [
        'passport_number',
        'business_id',
        'business_category',
        'spending_category',
        'spending_amount',
        'tax_included',
        'spending_date',
    ];

    public function business()
    {
        return $this->belongsTo(User::class, 'business_id');
    }
}
