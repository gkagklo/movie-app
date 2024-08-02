<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Episode extends Model implements Searchable
{
    use HasFactory;

    protected $fillable = [
        'tmdb_id',
        'season_id',
        'name',
        'slug',
        'episode_number',
        'is_public',
        'visits',
        'overview'
    ];

    public function getSearchResult(): SearchResult
     {
        $url = route('episodes.show', $this->slug);
     
         return new \Spatie\Searchable\SearchResult(
            $this,
            $this->name,
            $url
         );
     }

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function trailers()
    {
        return $this->morphMany(TrailerUrl::class, 'trailerable');
    }

}
