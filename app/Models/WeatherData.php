<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WeatherData extends Model
{
    use HasFactory;

    protected $fillable = [
        'weather_id',
        'main',
        'description',
        'icon',
        'recorded_at',
    ];
}
