<?php

namespace App\Livewire;

use App\Models\Season;
use App\Models\Serie;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class SeasonIndex extends Component
{
    use WithPagination;

    public $seasonTMDBId;
    public $seasonName;
    public $seasonPosterPath;
    public $seasonNumber;
    public $showSeasonModal = false;
    public $seasonId;
    public $search = '';
    public $sort = 'asc';
    public $perPage = 5;

    public Serie $serie;

    protected $rules = [
        'seasonName' => 'required',
        'seasonPosterPath' => 'required',
        'seasonNumber' => 'required'
    ];

    public function generateSeason()
    {
        $newSeason = Http::get('https://api.themoviedb.org/3/tv/'. $this->serie->id .'/season/'. $this->seasonTMDBId .'?language=en-US&api_key=3782d0cbf52bde02c3b8a41ea22481f7')->json();
        $season = Season::where('tmdb_id', $newSeason['id'])->first();
        if(!$season){
            Season::create([
                'tmdb_id' => $newSeason['id'],
                'serie_id' => $this->serie->id,
                'name' => $newSeason['name'],    
                'slug' => Str::slug($newSeason['name']),
                'poster_path' => $newSeason['poster_path'],
                'season_number' => $newSeason['season_number']
            ]);
        }
        else
        {
            $this->dispatch('banner-message', style: 'danger', message: 'Season already exist');
        }
        
    }

    public function showEditModal($id)
    {
        $this->seasonId = $id;
        $this->loadSeason();
        $this->showSeasonModal = true;
    }

    public function loadSeason()
    {
        $season = Season::findOrFail($this->seasonId);
        $this->seasonName = $season->name;
        $this->seasonPosterPath = $season->poster_path;
        $this->seasonNumber = $season->season_number;
    }

    public function updateSeason()
    {
        $this->validate();
        $season = Season::findOrFail($this->seasonId);
        $season->update([
            'name' => $this->seasonName,
            'poster_path' => $this->seasonPosterPath,
            'season_number' => $this->season_number
        ]);
        $this->dispatch('banner-message', style: 'success', message: 'Season updated successfully');
        $this->reset();
    }

    public function closeSeasonModal()
    {
        $this->reset();
        $this->resetValidation();
    }

    public function deleteSeason($id)
    {
        $season = Season::findOrFail($id);
        $season->delete();
        $this->dispatch('banner-message', style: 'danger', message: 'Season deleted successfully');
    }

    public function resetFilters()
    {
        $this->reset(['search', 'sort', 'perPage']);
    }

    public function render()
    {
        return view('livewire.season-index', [
            'seasons' => Season::where('serie_id', $this->serie->id)->search('name', $this->search)->orderBy('name', $this->sort)->paginate($this->perPage)
        ]);
    }
}
