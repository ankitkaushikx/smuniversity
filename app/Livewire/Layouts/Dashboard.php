<?php 
namespace App\Livewire\Layouts;

use Livewire\Component;

class Dashboard extends Component
{
    
    
    public function render()
    {
       $title = "dashboard";
        return view('livewire.layouts.dashboard', ['title' => $title]);
    }
}
