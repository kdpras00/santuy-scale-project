<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'description',
        'target_audience',
        'key_benefits',
    ];
}
