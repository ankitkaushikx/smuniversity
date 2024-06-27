<?php
namespace App\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Student;
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
    public $dob = null;
    public $session_start;

    //Sessions 
    public $session_start_month = NULL;
    public $session_start_year = NULL;
    public $session_end_month = NULL;
    public $session_end_year = NULL;
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

    public $eligibility = 0;


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
        'session_start_month' => 'required',
        'session_start_year' => 'required',
        'session_end_month' => 'required',
         'session_end_year'=> 'required',
        'photo' => 'required|image|max:10000',
        'id_proof' => 'required|mimes:pdf|max:5120',
        'tenth' => 'nullable|mimes:pdf|max:5120',
        'twelfth' => 'nullable|mimes:pdf|max:5120',
        'diploma' => 'nullable|mimes:pdf|max:5120',
        'undergraduate' => 'nullable|mimes:pdf|max:5120',
        'postgraduate' => 'nullable|mimes:pdf|max:5120',
        'gender' => 'required'
    ];


    public function create()
{
    
    
        $validatedData = $this->validate();
        try{
        // Check if the authenticated user is a center and active
        if (Auth::user()?->role === 'center' && Auth::user()->status === 'active') {
            // Get center associated with the authenticated user
                // Get the user with ID 1 and their associated center
                $user = User::with('center')->findOrFail(Auth::id());

                // Access the center
                $center = $user->center;


            // Generate student code
            $total_students = $center->students()->count();
            $incrementedTotalStudents = str_pad($total_students + 1, 4, '0', STR_PAD_LEFT);
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

                $this->session_start = $this->convertSessionString($this->session_start);
                $this->session_end = $this->convertSessionString($this->session_end);
            // Create student
            Student::create([
                'user_id' => $user->id,
                'center_id' => $center->id,
                'student_code' => $student_code,
                'father_name' => $this->father_name,
                'mother_name' => $this->mother_name,
                'dob' => $this->dob,
                'course_id' => $this->selectedCourse,
                'session_start' => $this->session_start,
                'session_end' => $this->session_end,
                'gender'=> $this->gender,
                'photo' => $validatedData['photo'] ?? null,
                'id_proof' => $validatedData['id_proof'] ?? null,
                'tenth' => $validatedData['tenth'] ?? null,
                'twelfth' => $validatedData['twelfth'] ?? null,
                'undergraduate' => $validatedData['undergraduate'] ?? null,
                'postgraduate' => $validatedData['postgraduate'] ?? null,
                'diploma' => $validatedData['diploma'] ?? null,
            ]);

            session()->flash('message', 'Student added successfully with Enrollment Code: ' . $student_code);
                $this->reset(['selectedCourse','selectedProgram','name','dob','gender','email','phone_number','father_name','mother_name','address','comment','id_proof','photo','tenth','twelfth','diploma','undergraduate','postgraduate',]);
        } else {
            abort(403, 'You are not allowed to add a student. Contact Admin for more details.');
        }
    } catch (\Exception $e) {
        session()->flash('message', 'An error occurred while adding the student: ' . $e->getMessage());
    }
}

     public function updatedSelectedProgram(Program $program)
    {
        $this->courses = $program->courses()->get();
        $this->selectedCourse = NULL;
    }

    //session start year for calculating session ends
     
public function updatedSessionStartYear(){
    $start_month = $this->session_start_month; // month as number (1 for January, 2 for February, ...)
    $start_year = $this->session_start_year; // year in four-digit format (2024, 2023)
    
    // Find the selected course by its ID
    $course = Course::find($this->selectedCourse);
    
    // Check if the course is found
    if ($course) {
        $duration = $course->duration; // duration in months

        // Calculate the total number of months
        $total_months = $start_month + $duration;

        // Calculate the end month and year
        $end_year = $start_year + intdiv($total_months - 1, 12);
        $end_month = ($total_months - 1) % 12 + 1;

        $this->session_end_month = $end_month;
        $this->session_end_year = $end_year;

            $this->session_start = $this->session_start_month . '-' . $this->session_start_year;
            $this->session_end = $this->session_end_month . '-' . $this->session_end_year;
    } else {
        // Handle case where course is not found
        $this->session_end_month = null;
        $this->session_end_year = null;
    }
}

    
    public function updatedSelectedCourse(){
        $course = Course::find($this->selectedCourse);
        $this->eligibility = $course->eligibility;
        
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

    // SESSION STRING CONVERSION

   public function convertSessionString($session_string) {
    $string = explode('-', $session_string); // [2, 2023]
    $month = $string[0];
    $year = $string[1];

    switch ($month) {
        case '1':
            $month = 'January';
            break;
        case '2':
            $month = 'February';
            break;
        case '3':
            $month = 'March';
            break;
        case '4':
            $month = 'April';
            break;
        case '5':
            $month = 'May';
            break;
        case '6':
            $month = 'June';
            break;
        case '7':
            $month = 'July';
            break;
        case '8':
            $month = 'August';
            break;
        case '9':
            $month = 'September';
            break;
        case '10':
            $month = 'October';
            break;
        case '11':
            $month = 'November';
            break;
        case '12':
            $month = 'December';
            break;
        default:
            return 'Invalid month';
    }

    return $month . '-' . $year;
}

}