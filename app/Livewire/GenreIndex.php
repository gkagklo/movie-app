<?php

namespace App\Livewire;

use App\Models\Genre;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class GenreIndex extends Component
{
    use WithPagination;

    public $genreTMDBId;
    public $genreTitle;
    public $showGenreModal = false;
    public $genreId;
    public $search = '';
    public $sort = 'asc';
    public $perPage = 5;

    protected $rules = [
        'genreTitle' => 'required'
    ];

    public function generateGenre()
    {
        $newGenre = Http::get('https://api.themoviedb.org/3/genre/'. $this->genreTMDBId .'?language=en-US&api_key=3782d0cbf52bde02c3b8a41ea22481f7')->json();
        $genre = Genre::where('tmdb_id', $newGenre['id'])->first();
        if(!$genre){
            Genre::create([
                'tmdb_id' => $newGenre['id'],
                'title' => $newGenre['name'],    
                'slug' => Str::slug($newGenre['name'])
            ]);
            $this->reset();
            $this->dispatch('banner-message', style: 'danger', message: 'Genre created successfully');
        }
        else
        {
            $this->dispatch('banner-message', style: 'danger', message: 'Genre already exist');
        }   
    }

    public function showEditModal($id)
    {
        $this->genreId = $id;
        $this->loadGenre();
        $this->showGenreModal = true;
    }

    public function loadGenre()
    {
        $genre = Genre::findOrFail($this->genreId);
        $this->genreTitle = $genre->title;
    }

    public function updateGenre()
    {
        $this->validate();
        $genre = Genre::findOrFail($this->genreId);
        $genre->update([
            'title' => $this->genreTitle,
            'slug' => Str::slug($this->genreTitle)
        ]);
        $this->dispatch('banner-message', style: 'success', message: 'Genre updated successfully');
        $this->reset();
    }

    public function closeGenreModal()
    {
        $this->reset();
        $this->resetValidation();
    }

    public function deleteGenre($id)
    {
        $genre = Genre::findOrFail($id);
        $genre->delete();
        $this->dispatch('banner-message', style: 'danger', message: 'Genre deleted successfully');
        $this->reset();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'sort', 'perPage']);
    }

    public function render()
    {
        return view('livewire.genre-index', [
            'genres' => Genre::search('title', $this->search)->orderBy('title', $this->sort)->paginate($this->perPage)
        ]);
        
    }
}
