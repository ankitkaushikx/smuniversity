<?php 
// app/Livewire/Components/Facultynav.php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\Program;

class Facultynav extends Component
{
    public $programs;

    public function mount()
    {
        $this->programs = Program::all();
    }

    public function render()
    {
        return view('livewire.components.faculty-nav');
    }
}
