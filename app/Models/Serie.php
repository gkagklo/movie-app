<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Serie extends Model implements Searchable
{
    use HasFactory;

    protected $fillable = [
        'tmdb_id',
        'name',
        'slug',
        'created_year',
        'poster_path',
        'visits'
    ];

    public function getSearchResult(): SearchResult
     {
        $url = route('series.show', $this->slug);
     
         return new \Spatie\Searchable\SearchResult(
            $this,
            $this->name,
            $url
         );
     }

    public function seasons()
    {
        return $this->hasMany(Season::class);
    }
    
}
