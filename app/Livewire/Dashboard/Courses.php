<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Course;
use Livewire\WithFileUploads;
use App\Models\Program;
class Courses extends Component
{
    use WithFileUploads;
    public $name;
    public $description;
    public $banner;
    public $eligibility = 'tenth';
    public $duration = '3 month';
    public $status;
    public $program;
    public $comment;
    public $editMode = false;
    public $course;
    protected $rules = [
        'name' => 'required | string | max:255',
        'description' => 'nullable | string',
        'banner' => 'nullable|image|max:10240', //10MB max
        'comment' => 'nullable|string',
        'duration' => 'required|string|max:20',
        'eligibility' => 'required|in:tenth, twelfth,diploma,undergraduate,postgraduate',
        'status' => 'required|in:active, inactive',
        'program' => 'required|exists:programs,id',
    ];

    /// Create New Course
    public function create()
    {
        try {
            // Validate the data
            $validatedData = $this->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'banner' => 'nullable|image|max:2048', // Example: Max 2MB image file
                'comment' => 'nullable|string',
                'eligibility' => 'required|in:tenth,twelfth,diploma,undergraduate,postgraduate',
                'duration' => 'required|in:3 month,6 month,1 Year,2 year,3 year,4 year,5 year',
                'program' => 'required|exists:programs,id',
            ]);
            // dd($this->eligibility);
            // Check if banner image is present and store if present
            if ($this->banner) {
                $validatedData['banner'] = $this->banner->store('banners', 'public');
            }

            // Create New Program
            $newCourse = Course::create([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'banner' => $validatedData['banner'] ?? null,
                'comment' => $validatedData['comment'],
                'status' => 'active', // Set default value if necessary
                'eligibility' => $validatedData['eligibility'],
                'duration' => $validatedData['duration'],
                'program_id' => $validatedData['program'],
            ]);

            // Check if it's created
            if ($newCourse) {
                session()->flash('message', 'Course Added Successfully');
            } else {
                session()->flash('message', 'Failed to add course.');
            }

            // Reset The Fields
            $this->reset(['name', 'description', 'banner', 'comment', 'status', 'eligibility', 'duration', 'program', 'banner']);
        } catch (\Exception $e) {
            // Handle exceptions (e.g., validation errors)
            session()->flash('message', $e->getMessage());
        }
    }


   //  Edit A Course 
    public function edit(Course $course){
      //Fill  the form with data
       $this->course = $course;

      //Populate Livewire Component Properties with course data
      $this->name = $course->name;
      $this->description = $course->description;
      $this->banner = null;
      $this->comment = $course->comment;
      $this->eligibility = $course->eligibility;
      $this->duration = $course->duration;
      $this->status = $course->status;
      $this->program = $course->program_id;

      // Set Edit Mode;
      $this->editMode = true;

      //change the form submission type
      

      //change the button text 

      //  $this->dispatchBrowserEvent('scroll-to-top');
    }
   

    //Update the Course;
   public function update()
{
    try {
        $validatedData = $this->validate([ 
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'banner' => 'nullable|image|max:20480', // Example: Max 20MB image file
            'comment' => 'nullable|string',
            'eligibility' => 'required|in:tenth,twelfth,diploma,undergraduate,postgraduate',
            'duration' => 'required|in:3 month,6 month,1 Year,2 year,3 year,4 year,5 year',
            'program' => 'required|exists:programs,id',
        ]);

        if ($this->banner) {
            $validatedData['banner'] = $this->banner->store('banners', 'public');
        }

        $course = Course::findOrFail($this->course->id);
        $course->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'banner' => $validatedData['banner'] ?? null,
            'comment' => $validatedData['comment'],
            'status' => 'active', // Set default value if necessary
            'eligibility' => $validatedData['eligibility'],
            'duration' => $validatedData['duration'],
            'program_id' => $validatedData['program'],
        ]);

        session()->flash('message', 'Course Updated Successfully');

        $this->reset(['name', 'description', 'banner', 'comment', 'status', 'eligibility', 'duration', 'program', 'editMode', 'course']);
    } catch (\Exception $e) {
        session()->flash('message', 'Error updating course: ' . $e->getMessage());
    }
}



    //hide the program
    public function hide(Course $course)
    {
        $course->delete();

        session()->flash('message', 'Faculty Hided Successfully');
    }

    public function unhide($id)
    {
        $course = Course::withTrashed()->findOrFail($id);
        if ($course && $course->trashed()) {
            $course->restore();
            session()->flash('message', 'Program Unhided Successfully');
        }
    }

    //delete the program

    public function delete(Course $course)
    {
        if ($course->banner) {
            \Storage::disk('public')->delete($course->banner);
        }

        $course = Course::withTrashed()->findOrFail($course->id);
        if ($course) {
            $course->forceDelete();
            session()->flash('message', 'Program Deleted Successfully');
        }
    }


    // Program Delete

    public function render()
    {
        return view('livewire.dashboard.courses', [
            'courses' => Course::withTrashed()->latest()->paginate(10),
            'programs' => Program::withTrashed()->get(),
        ]);
    }
}
