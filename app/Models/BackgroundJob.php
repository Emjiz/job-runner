<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BackgroundJob extends Model
{
    //
    use HasFactory; // Ensure this line is here
    protected $fillable = [
        'class',
        'method',
        'parameters',
        'status',
        'retry_count',
        'priority',
        'scheduled_at',
    ];

    protected $casts = [
        'parameters' => 'array', // To handle JSON data as an array
        'scheduled_at' => 'datetime', // Ensures correct handling of timestamp
    ];
}
