<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Notice;
use Illuminate\Support\Facades\Auth;
use Storage;
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
    public $notice;
    public $editMode = false;
 protected $rules = [
        'heading' => 'required|string|max:255',
        'detail' => 'required|string',
        'banner' => 'nullable|image|max:10240', // 10MB Max
        'link' => 'nullable|url',
    ];

    public function create()
    {
        $validatedData = $this->validate();

        if ($this->banner) {
            $validatedData['banner'] = $this->banner->store('banners', 'public');
        }

        Notice::create([
            'heading' => $validatedData['heading'],
            'detail' => $validatedData['detail'],
            'banner' => $validatedData['banner'] ?? null,
            'link' => $validatedData['link'],
        ]);

        session()->flash('message', 'Notice Added Successfully');

        $this->reset(['heading', 'detail', 'banner', 'link']);
    }

    public function hide($id)
    {
        $notice = Notice::findOrFail($id);
        $notice->delete();

        session()->flash('message', 'Notice Hidden Successfully');
    }

    public function unhide($id)
    {
        $notice = Notice::withTrashed()->findOrFail($id);
        
        if ($notice->trashed()) {
            $notice->restore();
            session()->flash('message', 'Notice Unhided Successfully');
        }
    }

    public function delete($id)
    {
        $notice = Notice::findOrFail($id);

        if ($notice->banner) {
            Storage::disk('public')->delete($notice->banner);
        }

        $notice->forceDelete();

        session()->flash('message', 'Notice deleted successfully.');
    }

    public function edit($id)
{
    $this->editMode = true;
    $this->notice = Notice::findOrFail($id);

    // Populate form fields with $this->notice properties
    $this->heading = $this->notice->heading;
    $this->detail = $this->notice->detail;
    $this->link = $this->notice->link;
        $this->banner = null;
    // If banner exists, set the banner property (if you have a form field for banner)
    // Assuming you are not directly editing the banner in the form (optional)
    // $this->banner = $this->notice->banner;

    // Optionally, you might want to clear the validation errors when switching to edit mode
    $this->resetValidation();
}


   



public function update()
{
    $validatedData = $this->validate([
        'heading' => 'required|string|max:255',
        'detail' => 'required|string',
        'banner' => 'nullable|image|max:10240', // 10MB Max
        'link' => 'nullable|url',
    ]);

    $notice = Notice::findOrFail($this->notice['id']);

    if ($this->banner) {
        // Delete old banner if exists
        if ($notice->banner) {
            Storage::disk('public')->delete($notice->banner);
        }
        // Store new banner
        $validatedData['banner'] = $this->banner->store('banners', 'public');
    } else {
        // Keep existing banner
        $validatedData['banner'] = $notice->banner;
    }

    $notice->update([
        'heading' => $validatedData['heading'],
        'detail' => $validatedData['detail'],
        'banner' => $validatedData['banner'],
        'link' => $validatedData['link'],
    ]);

    session()->flash('message', 'Notice updated successfully.');

    $this->reset(['heading', 'detail', 'banner', 'link', 'editMode']);
}

    public function render()
    {
    return view('livewire.dashboard.noticezone', ['notices'=> Notice::withTrashed()->latest()->paginate(10)]);
    }
}
