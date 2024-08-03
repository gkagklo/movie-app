<?php

namespace App\Livewire;

use App\Models\Cast;
use App\Models\Episode;
use App\Models\Movie;
use App\Models\Season;
use App\Models\Serie;
use Livewire\Component;
use Spatie\Searchable\Search as SpatieSearch;

class Search extends Component
{
    public $showSearchModal = false;
    public $search = '';
    public $searchResults = [];

    public function showSearch()
    {
        $this->showSearchModal = true;
    }
    public function closeSearchModal()
    {
        $this->reset();
    }

    public function render()
    {  
        $searchResults = (new SpatieSearch())
        ->registerModel(Movie::class, 'title')
        ->registerModel(Serie::class, 'name')
        ->registerModel(Season::class, 'name')
        ->registerModel(Cast::class, 'name')
        ->registerModel(Episode::class, 'name') 
        ->search($this->search);
        return view('livewire.search', ['results' => $searchResults]);
    }
}