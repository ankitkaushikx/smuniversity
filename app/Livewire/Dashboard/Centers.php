<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;

class Centers extends Component
{
    public $title = 'Centersss';

    public function render()
    {
        return view('livewire.dashboard.centers', ['title' => $this->title]);
    }
}
