<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Notice;
use Illuminate\Support\Facades\Auth;
class Noticezone extends Component
{
    use WithFileUploads;

    public $heading;
    public $detail;
    public $banner;
    public $link;
    public $status;
    // public $notices;
    public $search;

    protected $rules = [
        'heading' => 'required|string|max:255',
        'detail' => 'required|string',
        'banner' => 'nullable|image|max:10240', // 10MB Max
        'link' => 'nullable|url',
        'status' => 'required|in:active,inactive',
    ];


    // Create New Notice
    public function submit()
    {
        $user = Auth::user();
        
        // if ($user->role !== 'admin') {
        //     abort(404);
        // }

        $validatedData = $this->validate();

        if ($this->banner) {
            $validatedData['banner'] = $this->banner->store('banners', 'public');
        }

        Notice::create([
            'heading' => $validatedData['heading'],
            'detail' => $validatedData['detail'],
            'banner' => $validatedData['banner'] ?? null,
            'link' => $validatedData['link'],
            'status' => $validatedData['status'],
        ]);

        session()->flash('message', 'Notice Added Successfully');

        // Optionally reset form fields
        $this->reset(['heading', 'detail', 'banner', 'link', 'status']);
    }

    // Delete Notice
 public function delete(Notice $notice)
{
    if ($notice->banner) {
        // Delete the banner file from the storage
        \Storage::disk('public')->delete($notice->banner);
        //  $this->removeUpload($notice->banner);
    }

    // Delete the notice from the database
    $notice->delete();

    session()->flash('message', 'Notice deleted successfully.');
}


    public function render()
    {

      
    return view('livewire.dashboard.noticezone', ['notices'=> Notice::latest()->paginate(10)]);
    }
}
