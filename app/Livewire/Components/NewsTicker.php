<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\Notice;
class NewsTicker extends Component
{
    public function render()
    {
      
        return view('livewire.components.news-ticker', ['headings' => Notice::latest()->take(3)->get()]);
    }
}
