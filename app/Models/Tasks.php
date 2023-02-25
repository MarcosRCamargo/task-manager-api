<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_estimate_date',
        'end_date',
        'status',
        'owner',
        'delegated_user',
    ];
}
