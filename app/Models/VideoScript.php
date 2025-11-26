<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VideoScript extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'script_content',
        'settings',
    ];
}
