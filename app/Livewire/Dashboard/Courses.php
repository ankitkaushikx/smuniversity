<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;

class Courses extends Component
{

   public $title = "Courses";
    public function render()
    {
       return view('livewire.dashboard.courses', [
        'title' =>$this->title,
        'courseList' => ['course 1', 'course 2', 'course 3', 'course 4']
       ] );
    }
}
