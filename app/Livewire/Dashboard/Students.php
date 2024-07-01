<?php
namespace App\Livewire\Dashboard;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Student;
use Livewire\WithFileUploads;
use App\Models\Program;
use App\Models\Course;
use Livewire\WithPagination;

class Students extends Component
{
    use WithFileUploads,  WithPagination;
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
    // public $students;
    public $editMode = false;

    // Utility
    public $programs;
    public $courses;
    public $selectedProgram;
    public $selectedCourse;

    public $search = '';
    public $eligibility = 0;

    public $isAdmin = false;

    protected $rules = [
        'name'                           => 'required|string',
        'email'                          => 'required|email',
        'phone_number'                   => ['required','regex:/^\d{10}$/' ],
        'father_name'                    => 'required|string',
        'mother_name'                    => 'required|string',
        'dob'                            => 'required|date',
        'selectedProgram'                => 'required',
        'selectedCourse'                 => 'required|exists:courses,id',
        'session_start'                  => 'required|string',
        'session_end'                    => 'required|string',
        'comment'                        => 'nullable|string',
        'address'                        => 'required|string',
        'session_start_month'            => 'required',
        'session_start_year'             => 'required',
        'session_end_month'              => 'required',
        'session_end_year'               => 'required',
        'photo'                          => 'required|image|max:5000',
        'id_proof'                       => 'required|mimes:pdf|max:5120',
        'tenth'                          => 'nullable|mimes:pdf|max:5120',
        'twelfth'                        => 'nullable|mimes:pdf|max:5120',
        'diploma'                        => 'nullable|mimes:pdf|max:5120',
        'undergraduate'                  => 'nullable|mimes:pdf|max:5120',
        'postgraduate'                   => 'nullable|mimes:pdf|max:5120',
        
    ];


    // Function To Create New Student 
    public function create()
    {
        $validatedData = $this->validate();
        try{
    
            //Check User is Active Center & and Authticated 
        if (Auth::user()?->role === 'center' && Auth::user()->status === 'active') {
            
            //Get User With Center Relationship
            $user = User::with('center')->findOrFail(Auth::id());
            $center = $user->center;

            //Generate Student Code 
            $total_students = $center->students()->count();
            $incrementedTotalStudents = str_pad($total_students + 1, 4, '0', STR_PAD_LEFT);
            $student_code = $center->center_code . $incrementedTotalStudents;
   
            //Register A New User
            $user = User::create([
                'name'              => $this->name,
                'email'             => $this->email,
                'phone_number'      => $this->phone_number,
                'status'            => 'active',
                'role'              => 'student',
                'password'          => 'SMUS' . $this->phone_number,
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


            //Merge and Convert Session String to More Readable Form
            $this->session_start = $this->convertSessionString($this->session_start);
            $this->session_end = $this->convertSessionString($this->session_end);

            //Register New Student
            Student::create([
                'user_id'               => $user->id,
                'center_id'             => $center->id,
                'student_code'          => $student_code,
                'father_name'           => $this->father_name,
                'mother_name'           => $this->mother_name,
                'dob'                   => $this->dob,
                'course_id'             => $this->selectedCourse,
                'session_start'         => $this->session_start,
                'session_end'           => $this->session_end,
                'gender'                => $this->gender,
                'address'               => $this->address,
                'photo'                 => $validatedData['photo'] ?? null,
                'id_proof'              => $validatedData['id_proof'] ?? null,
                'tenth'                 => $validatedData['tenth'] ?? null,
                'twelfth'               => $validatedData['twelfth'] ?? null,
                'undergraduate'         => $validatedData['undergraduate'] ?? null,
                'postgraduate'          => $validatedData['postgraduate'] ?? null,
                'diploma'               => $validatedData['diploma'] ?? null,
            ]);

            //Send Feedback To User  
            session()->flash('message', 'Student Added Successfull With Enrollment Code: ' . $student_code);


            $this->reset(['selectedCourse','selectedProgram','name','dob','gender','email','phone_number','father_name','mother_name','address','comment','id_proof','photo',
            'tenth','twelfth','diploma','undergraduate','postgraduate'
            ]);

        } else {

            //Send Authorisation Error Message;
            abort(403, 'You are not allowed to add a student. Contact Admin for more details.');
        }

        } catch (\Exception $e) {

        session()->flash('message', 'An error occurred while adding the student: ' . $e->getMessage());
        }
    }

    public function updatedSelectedProgram(Program $program)
    {
      $this->courses = $program->courses()->where('status', 'active')->get();

        $this->selectedCourse = NULL;

    }
     
    //Session Ends Updated According to Session Start 
    public function updatedSessionStartYear()
    {
    
                //Get Session Start Data 
            $start_month = $this->session_start_month; 
            $start_year = $this->session_start_year; 
            
            //Find Course and Duration 
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
                session()->flash('message', 'Course Not Found. ' );
            }
    }

    
    //Change Eligiblity According to Selected Course
    public function updatedSelectedCourse(){

        $course = Course::find($this->selectedCourse);
        $this->eligibility = $course->eligibility;
    }


    //Mount Function To Render With DAta
   public function mount()
    {
        // Get All Programs
        $this->programs = Program::where('status', 'active')->get();
   

        //Get All Students  
        $this->isAdmin = Auth::user()->role === 'admin';

        // Get All Courses
        $this->courses = null;
        
    }

    
    // Render 
    public function render()
    {
        if (!$this->isAdmin) {
            # code...
            $user = User::find(Auth::id()); // Retrieve authenticated user
            $centerId = $user->center->id;
            $students = Student::where('center_id', $centerId) // Filter students by the center ID of the authenticated user
            ->where(function ($query) { // Nested query to handle search functionality
                $query->whereHas('course', function ($query) { // Check if the related course name matches the search term
                    $query->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('user', function ($query) { // Check if the related user details match the search term
                    $query->where('name', 'like', '%' . $this->search . '%') // Match user name
                          ->orWhere('phone_number', 'like', '%' . $this->search . '%'); // Match user phone number
                })
                ->orWhere('student_code', 'like', '%' . $this->search . '%'); // Match student code
            })
            ->with([
                'course' => function ($query) { // Eager load the related course with selected fields
                    $query->select('id', 'name', 'program_id');
                },
                'user' => function ($query) { // Eager load the related user with selected fields
                    $query->select('id', 'name', 'status', 'phone_number', 'email');
                }
            ])
            ->latest() // Order the results by the latest entries
            ->paginate(10); // Paginate the results, 10 per page

        } else {
        $students = Student::where(function ($query) { // Nested query to handle search functionality
                $query->whereHas('course', function ($query) { // Check if the related course name matches the search term
                    $query->where('name', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('user', function ($query) { // Check if the related user details match the search term
                    $query->where('name', 'like', '%' . $this->search . '%') // Match user name
                          ->orWhere('phone_number', 'like', '%' . $this->search . '%'); // Match user phone number
                })
                ->orWhere('student_code', 'like', '%' . $this->search . '%'); // Match student code
            })
            ->with([
                'course' => function ($query) { // Eager load the related course with selected fields
                    $query->select('id', 'name', 'program_id');
                },
                'user' => function ($query) { // Eager load the related user with selected fields
                    $query->select('id', 'name', 'status', 'phone_number', 'email');
                }
            ])
            ->latest() // Order the results by the latest entries
            ->paginate(10); // Paginate the results, 10 per page
        }

            return view('livewire.dashboard.students',[
          'students' => $students
        
        ]);
    }

  

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


    public function deactivate(User $user){
        $user->update(['status' => 'inactive']);

        session()->flash('message', 'Student Deactivated Successfully');
    }

    public function activate(User $user){
        $user->update(['status' => 'active']);

        session()->flash('message', 'Student Activated Successfully');
    }

}