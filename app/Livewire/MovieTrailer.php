<?php

namespace App\Livewire;

use Livewire\Component;

class MovieTrailer extends Component
{

    public $showMovieEmbedModal = false;
    public $trailer;

    public function mount($trailer)
    {
        $this->trailer = $trailer;
    }

    public function render()
    {
        return view('livewire.movie-trailer');
    }

    public function showMovieTrailerModal()
    {
        $this->showMovieEmbedModal = true;
    }

    public function closeMovieTrailerModal()
    {
        $this->reset('showMovieEmbedModal');
    }

}
