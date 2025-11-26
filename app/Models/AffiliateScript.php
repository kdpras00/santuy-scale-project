<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AffiliateScript extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_link',
        'platform',
        'benefits',
        'tone',
        'generated_script',
    ];
}
