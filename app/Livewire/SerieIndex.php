<?php

namespace App\Livewire;

use App\Models\Serie;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class SerieIndex extends Component
{
    use WithPagination;

    public $serieTMDBId;
    public $serieName;
    public $seriePosterPath;
    public $createdYear;
    public $showSerieModal = false;
    public $serieId;
    public $search = '';
    public $sort = 'asc';
    public $perPage = 5;

    protected $rules = [
        'serieName' => 'required',
        'seriePosterPath' => 'required',
        'createdYear' => 'required'
    ];

    public function generateSerie()
    {
        $newSerie = Http::get('https://api.themoviedb.org/3/tv/'. $this->serieTMDBId .'?language=en-US&api_key=3782d0cbf52bde02c3b8a41ea22481f7')->json();
        $serie = Serie::where('tmdb_id', $newSerie['id'])->first();
        if(!$serie){
            Serie::create([
                'tmdb_id' => $newSerie['id'],
                'name' => $newSerie['name'],    
                'slug' => Str::slug($newSerie['name']),
                'poster_path' => $newSerie['poster_path'],
                'created_year' => $newSerie['first_air_date']
            ]);
        }
        else
        {
            $this->dispatch('banner-message', style: 'danger', message: 'Serie already exist');
        }
        
    }

    public function showEditModal($id)
    {
        $this->serieId = $id;
        $this->loadSerie();
        $this->showSerieModal = true;
    }

    public function loadSerie()
    {
        $serie = Serie::findOrFail($this->serieId);
        $this->serieName = $serie->name;
        $this->seriePosterPath = $serie->poster_path;
        $this->createdYear = $serie->created_year;
    }

    public function updateSerie()
    {
        $this->validate();
        $serie = Serie::findOrFail($this->serieId);
        $serie->update([
            'name' => $this->serieName,
            'poster_path' => $this->seriePosterPath,
            'created_year' => $this->createdYear
        ]);
        $this->dispatch('banner-message', style: 'success', message: 'Serie updated successfully');
        $this->reset();
    }

    public function closeSerieModal()
    {
        $this->reset();
        $this->resetValidation();
    }

    public function deleteSerie($id)
    {
        $serie = Serie::findOrFail($id);
        $serie->delete();
        $this->dispatch('banner-message', style: 'danger', message: 'Serie deleted successfully');
    }

    public function resetFilters()
    {
        $this->reset(['search', 'sort', 'perPage']);
    }

    public function render()
    {
        return view('livewire.serie-index', [
            'series' => Serie::search('name', $this->search)->orderBy('name', $this->sort)->paginate($this->perPage)
        ]);
    }
}
