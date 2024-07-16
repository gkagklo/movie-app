<?php

namespace App\Livewire;

use App\Models\Cast;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class CastIndex extends Component
{
    use WithPagination;

    public $castTMDBId;
    public $castName;
    public $castPosterPath;

    public function generateCast()
    {
        $newCast = Http::get('https://api.themoviedb.org/3/person/'. $this->castTMDBId .'?language=en-US&api_key=3782d0cbf52bde02c3b8a41ea22481f7')->json();
        $cast = Cast::where('tmdb_id', $newCast['id'])->first();
        if(!$cast){
            Cast::create([
                'tmdb_id' => $newCast['id'],
                'name' => $newCast['name'],    
                'slug' => Str::slug($newCast['name']),
                'poster_path' => $newCast['profile_path']
            ]);
        }
        else
        {
            $this->dispatch('banner-message', style: 'danger', message: 'Cast already exist');
        }
        
    }

    public function render()
    {
        return view('livewire.cast-index', [
            'casts' => Cast::paginate(5)
        ]);
    }
}
