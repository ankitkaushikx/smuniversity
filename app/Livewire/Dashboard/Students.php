<?php
namespace App\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Student;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;
use App\Models\Program;
use App\Models\Course;

class Students extends Component
{
    use WithFileUploads;
    public $name;
    public $email;
    public $phone_number;
    public $status;
    public $role = 'student';
    public $password;

    // Student Table
    public $student_code;
    public $gender = 'male';
    public $father_name;
    public $mother_name;
    public $dob;
    public $session_start;
    public $session_end;
    public $comment;
    public $address;
    public $photo;
    public $id_proof;
    public $tenth;
    public $twelfth;
    public $diploma;
    public $undergraduate;
    public $postgraduate;
    public $student;
    public $editMode = false;

    // Utility
    public $programs;
    public $courses;
    public $selectedProgram;
    public $selectedCourse;


    protected $rules = [
        'name' => 'required|string',
        'email' => 'required|email',
        'phone_number' => [
            'required',
            'regex:/^\d{10}$/'
        ],
        'father_name' => 'required|string',
        'mother_name' => 'required|string',
        'dob' => 'required|date',
        'selectedProgram' => 'required',
        'selectedCourse' => 'required|exists:courses,id',
        'session_start' => 'required|string',
        'session_end' => 'required|string',
        'comment' => 'nullable|string',
        'address' => 'required|string',
        'photo' => 'required|image|max:10000',
        'id_proof' => 'required|mimes:pdf|max:5120',
        'tenth' => 'nullable|mimes:pdf|max:5120',
        'twelfth' => 'nullable|mimes:pdf|max:5120',
        'diploma' => 'nullable|mimes:pdf|max:5120',
        'undergraduate' => 'nullable|mimes:pdf|max:5120',
        'postgraduate' => 'nullable|mimes:pdf|max:5120',
        'gender' => 'required| in: male, female'
    ];


    public function create()
{
    
    try {
        $validatedData = $this->validate();
        // Check if the authenticated user is a center and active
        // if (Auth::user()?->role === 'center' && Auth::user()->status === 'active') {
            // Get center associated with the authenticated user
                // Get the user with ID 1 and their associated center
                $user = User::with('center')->findOrFail(1);

                // Access the center
                $center = $user->center;


            // Generate student code
            $total_students = $center->students()->count();
            $incrementedTotalStudents = $total_students + 1;
            $student_code = $center->center_code . $incrementedTotalStudents;

            // Register User
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'phone_number' => $this->phone_number,
                'status' => 'active',
                'role' => 'student',
              'password' => 'SMUS' . $this->phone_number,
            ]);

            // Handle file uploads
            if ($this->id_proof) {
                $validatedData['id_proof'] = $this->id_proof->store('documents', 'public');
            }
            if ($this->photo) {
                $validatedData['photo'] = $this->photo->store('photos', 'public');
            }
            if ($this->tenth) {
                $validatedData['tenth'] = $this->tenth->store('documents', 'public');
            }
            if ($this->twelfth) {
                $validatedData['twelfth'] = $this->twelfth->store('documents', 'public');
            }
            if ($this->diploma) {
                $validatedData['diploma'] = $this->diploma->store('documents', 'public');
            }
            if ($this->undergraduate) {
                $validatedData['undergraduate'] = $this->undergraduate->store('documents', 'public');
            }
            if ($this->postgraduate) {
                $validatedData['postgraduate'] = $this->postgraduate->store('documents', 'public');
            }

            // Create student
            Student::create([
                'user_id' => $user->id,
                'center_id' => $center->id,
                'student_code' => $student_code,
                'father_name' => $this->father_name,
                'mother_name' => $this->mother_name,
                'dob' => $this->dob,
                'course_id' => $this->course,
                'session_start' => 'Jan 2024',
                'session_end' => 'Jan 2025',
                'photo' => $validatedData['photo'] ?? null,
                'id_proof' => $validatedData['id_proof'] ?? null,
                'tenth' => $validatedData['tenth'] ?? null,
                'twelfth' => $validatedData['twelfth'] ?? null,
                'undergraduate' => $validatedData['undergraduate'] ?? null,
                'postgraduate' => $validatedData['postgraduate'] ?? null,
                'diploma' => $validatedData['diploma'] ?? null,
            ]);

            session()->flash('message', 'Student added successfully with Enrollment (Student) Code: ' . $student_code);
        // } else {
            // abort(403, 'You are not allowed to add a student. Contact Admin for more details.');
        // }
    } catch (\Exception $e) {
        session()->flash('message', 'An error occurred while adding the student: ' . $e->getMessage());
    }
}

     public function updatedSelectedProgram(Program $program)
    {
        $this->courses = $program->courses()->get();
        $this->selectedCourse = NULL;
    }

    function mount(){
        $this->programs = Program::all();
        $this->courses = NULL;
    }
    public function render()
    {
        return view('livewire.dashboard.students', [
        
            
           
        ]);
    }
}
