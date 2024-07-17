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
    public $showCastModal = false;
    public $castId;

    protected $rules = [
        'castName' => 'required',
        'castPosterPath' => 'required'
    ];

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

    public function showEditModal($id)
    {
        $this->castId = $id;
        $this->loadCast();
        $this->showCastModal = true;
    }

    public function loadCast()
    {
        $cast = Cast::findOrFail($this->castId);
        $this->castName = $cast->name;
        $this->castPosterPath = $cast->poster_path;
    }

    public function updateCast()
    {
        $this->validate();
        $cast = Cast::findOrFail($this->castId);
        $cast->update([
            'name' => $this->castName,
            'poster_path' => $this->castPosterPath
        ]);
        $this->dispatch('banner-message', style: 'success', message: 'Cast updated successfully');
        $this->reset();
    }

    public function closeCastModal()
    {
        $this->reset();
        $this->resetValidation();
    }

    public function deleteCast($id)
    {
        $cast = Cast::findOrFail($id);
        $cast->delete();
        $this->dispatch('banner-message', style: 'danger', message: 'Cast deleted successfully');
    }

    public function render()
    {
        return view('livewire.cast-index', [
            'casts' => Cast::paginate(5)
        ]);
    }
}
