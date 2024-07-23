<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use HasFactory;

    protected $fillable = [
        'tmdb_id',
        'serie_id',
        'name',
        'slug',
        'season_number',
        'poster_path'
    ];
}
