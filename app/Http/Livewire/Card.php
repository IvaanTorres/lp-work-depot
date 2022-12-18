<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Card extends Component
{
    public $count = 0;
    public $name = 'John Doe';

    public function increment()
    {
        $this->count++;
    }

    public function render()
    {
        return view('livewire.card');
    }
}
