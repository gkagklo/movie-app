<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use App\Models\Episode;
use App\Models\Season;
use App\Models\Serie;
use App\Models\TrailerUrl;
use Livewire\Component;
use Illuminate\Support\Str;

class EpisodeIndex extends Component
{

    public Serie $serie;
    public Season $season;
    public $episodeNumber;
    public $episodeName;
    public $episodeId;
    public $overview;
    public $isPublic;
    public $showEpisodeModal = false;
    public $search = '';
    public $sort = 'asc';
    public $perPage = 5;

    public $showTrailer = false;
    public $episode;

    public $trailerName;
    public $embedHtml;

    protected $rules = [
        'episodeName' => 'required',
        'overview' => 'required',
        'episodeNumber' => 'required'
    ];

    public function generateEpisode()
    {
        $newEpisode = Http::get('https://api.themoviedb.org/3/tv/'. $this->serie->tmdb_id .'/season/'. $this->season->season_number .'/episode/'. $this->episodeNumber .'?language=en-US&api_key=3782d0cbf52bde02c3b8a41ea22481f7');
        if($newEpisode->ok()){
            $episode = Episode::where('tmdb_id', $newEpisode['id'])->first();
            if(!$episode){
                Episode::create([
                    'tmdb_id' => $newEpisode['id'],
                    'season_id' => $this->season->id,
                    'name' => $newEpisode['name'],    
                    'slug' => Str::slug($newEpisode['name']),
                    'episode_number' => $newEpisode['season_number'],
                    'overview' => $newEpisode['overview'],  
                    'is_public' => false,
                    'visits' => 1, 
                ]);
                $this->reset('episodeNumber');
                $this->dispatch('banner-message', style: 'success', message: 'Episode created successfully');
            }
            else
            {
                $this->dispatch('banner-message', style: 'danger', message: 'Episode already exist');
            }
        }
        else
        {
            $this->dispatch('banner-message', style: 'danger', message: 'Api not exists');
            $this->reset('episodeNumber');
        }
    }

    public function showEditModal($id)
    {
        $this->episodeId = $id;
        $this->loadEpisode();
        $this->showEpisodeModal = true;
    }

    public function loadEpisode()
    {
        $episode = Episode::findOrFail($this->episodeId);
        $this->episodeName = $episode->name;
        $this->overview = $episode->overview;
        $this->episodeNumber = $episode->episode_number;
        $this->isPublic = $episode->is_public;
    }

    public function updateEpisode()
    {
        $this->validate();
        $episode = Episode::findOrFail($this->episodeId);
        $episode->update([
            'name' => $this->episodeName,
            'overview' => $this->overview,
            'episode_number' => $this->episodeNumber,
            'is_public' => $this->isPublic
        ]);
        $this->dispatch('banner-message', style: 'success', message: 'Episode updated successfully');
        $this->reset('episodeNumber', 'episodeName', 'overview', 'episodeId', 'showEpisodeModal');
    }

    public function closeEpisodeModal()
    {
        $this->reset('episodeNumber', 'episodeName', 'episodeId', 'showEpisodeModal', 'overview', 'showTrailer');
        $this->resetValidation();
    }

    public function deleteEpisode($id)
    {
        $episode = Episode::findOrFail($id);
        $episode->delete();
        $this->reset('episodeNumber', 'episodeName', 'episodeId', 'showEpisodeModal', 'overview');
        $this->dispatch('banner-message', style: 'danger', message: 'Episode deleted successfully');
    }

    public function resetFilters()
    {
        $this->reset(['search', 'sort', 'perPage']);
    }

    public function showTrailerModal($episodeId)
    {
        $this->episode = Episode::findOrFail($episodeId);
        $this->showTrailer = true;

    }

    public function addTrailer()
    {
        $this->episode->trailers()->create([
            'name' => $this->trailerName,
            'embed_html' => $this->embedHtml
        ]);
        $this->dispatch('banner-message', style: 'success', message: 'Trailer added');
        $this->reset('episode', 'showTrailer', 'trailerName', 'embedHtml');
    }

    public function deleteTrailer($trailerId)
    {
        $trailer = TrailerUrl::findOrFail($trailerId);
        $trailer->delete();
        $this->dispatch('banner-message', style: 'danger', message: 'Trailer deleted');
        $this->reset('episode', 'showTrailer', 'trailerName', 'embedHtml');
    }

    public function render()
    {
        return view('livewire.episode-index', [
            'episodes' => Episode::where('season_id', $this->season->id)->search('name', $this->search)->orderBy('name', $this->sort)->paginate($this->perPage)
        ]);
    }
}
