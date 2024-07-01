<?php

namespace App\Livewire\Dashboard;

use App\Models\Program;
use App\Models\Subject;
use Livewire\Component;
use App\Models\Course;

class Subjects extends Component
{
    public $selectedProgram;
    public $selectedCourse;
    public $selectedSubject;

    public $courses;
    public $programs;
    public $subjects;
    public $name;
    public $year;
    public $semester;
    public $maximumMarks;
    public $passingMarks;
    public $theoryMarks;
    public $practicalMarks;

    //
    public $editMode = false;

    // -------------------------Rules-----------------------
     protected $rules = [
        'name' => 'required|string|max:255',
        'year' => 'required|integer|min:0',
        'semester' => 'required|integer|min:0|',
        'maximumMarks' => 'required|integer|min:0',
        'passingMarks' => 'required|integer|min:0',
        'theoryMarks' => 'required|integer|min:0',
        'practicalMarks' => 'required|integer|min:0',
        'selectedProgram' => 'required|exists:programs,id',
        'selectedCourse' => 'required|exists:courses,id',
    ];


   public function create()
    {
        try {
            // Validate
            $validatedData = $this->validate();

            // Add To Subject
            $subject = Subject::create([
                'name' => $this->name,
                'maximum_marks' => $this->maximumMarks,
                'passing_marks' => $this->passingMarks,
                'theory_marks' => $this->theoryMarks, 
                'practical_marks' => $this->practicalMarks, 
                'status' => 'active',
            ]);


                $this->addSubjectCourseRelationship($this->selectedCourse, $subject, $this->year, $this->semester);

            // Reset form fields
            $this->resetForm();

            // Flash success message
            session()->flash('message', 'Subject Added Successfully with Id ' . $subject->id);
        } catch (\Exception $e) {
            // Flash error message
            session()->flash('message', 'Error: ' . $e->getMessage());
        }
    }

    public function updatedSelectedCourse(Course $course){
        $this->subjects = $course->activeSubjects()->get();
    }

    public function mount(){
        $this->programs = Program::get();
    }

    //Get Course list For Selected Program;
    public function updatedSelectedProgram(Program $program){
     $this->courses = $program->courses()->get();

        $this->selectedCourse = NULL;
    }


    public function render()
    {
        return view('livewire.dashboard.subjects');
    }


    public function resetForm()
    {
        $this->name = '';
        $this->year = '';
        $this->semester = '';
        $this->maximumMarks = '';
        $this->passingMarks = '';
        $this->theoryMarks = '';
        $this->practicalMarks = '';
        // $this->selectedProgram = '';
        // $this->selectedCourse = '';
    }

   public function addSubjectCourseRelationship($courseId, Subject $subject, $year, $semester)
    {
        $course = Course::find($courseId);
        if ($course) {
            $course->subjects()->attach($subject->id, ['year' => $year, 'semester' => $semester]);
        }
    }
}

