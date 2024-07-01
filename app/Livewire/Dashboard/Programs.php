<?php

namespace App\Livewire\Dashboard;

use App\Models\Program;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

class Programs extends Component
{
    use WithFileUploads;
   public $name;
   public $description;
   public $banner;
   public $comment;

    public $editMode = false;

    protected $rules = [
        'name' => 'required | string | max:255',
        'description' => 'nullable | string',
        'banner' => 'nullable|image|max:10240', //10MB max
        'comment' => 'nullable|string',
    ];

   /// Create New Program 
    public function create(){
        // $user = Auth::user();
        // if($user->role !=='admin'){
        //     abort(404);
        // }
        

        // Validate the data;
        $validatedData = $this->validate();

        // Check if banner image is present and store if present
        if($this->banner){
            $validatedData['banner'] = $this->banner->store('banners', 'public');
        }
       

        //Create New Program
       $NewProgram =  Program::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'banner' => $validatedData['banner'],
            'comment' => $validatedData['comment'],
            'status' => 'active'
        ]);


        //Check if its created
        if($NewProgram){
            session()->flash('message', 'Program Added Successfull');
        }

        //Reset The Fields
        $this->reset(['name', 'description', 'banner', 'comment']);
    }


    //hide the program
    public function hide(Program $program)
    {
        $program->update(['status' => 'inactive']);

        session()->flash('message', 'Program Deactivated Successfully');
    }

    public function unhide(Program $program)
    {
                $program->update(['status' => 'active']);
        session()->flash('message', 'Program Activated Successfully ');

    }

    //delete the program

    public function delete(Program $program){
        if($program->banner){
            \Storage::disk('public')->delete($program->banner);
        }

       $program = Program::withTrashed()->findOrFail($program->id);
        if ($program) {
            $program->forceDelete();
            session()->flash('message', 'Program Deleted Successfully');
        }
    }
    // Program Delete
   

    public function render()
    {
        return view('livewire.dashboard.programs', [
    'programs' => Program::latest()->paginate(10)
]);

    }
}
