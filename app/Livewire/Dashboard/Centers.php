<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Center;
use App\Models\User;
use Livewire\WithFileUploads;

class Centers extends Component
{
    use WithFileUploads;

    public $name;
    public $center_code = null;
    public $proprietor_name;
    public $address;
    public $id_proof;
    public $comment;
    public $total_student = 0;
    public $email;
    public $phone_number;
    public $status;
    public $role;
    public $password;

    public $center;
    public $editMode = false;

    protected $rules = [
        'name' => 'required|string',
        'email' => 'required|email',
        'phone_number' => [
            'required',
            'regex:/^\d{10}$/'
        ],
        'status' => 'nullable|string',
        'role' => 'nullable|string',
        // 'password' => 'required|string|min:8', // assuming a rule for password
        'proprietor_name' => 'required|string',
        'address' => 'required|string',
        'id_proof' => 'required|image | max: 5000',
        'comment' => 'nullable|string'
    ];

    
       
     public function create()
{
   
        // Validate the Fields
        $validatedData = $this->validate($this->rules);

        // Generate the center code
        $centerPrefix = "SMU";
        $centerNumber = $this->generateCenterNumber();
        $centerCode = $centerPrefix . $centerNumber;

        // Create User record
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'status' => 'active',
            'role' => 'center',
            'password' => 'SMU'.  $this->phone_number
        ]);

        if (!$user) {
            throw new \Exception('Failed to create user.');
        }

        // Store ID proof if provided
        if ($this->id_proof) {
            $validatedData['id_proof'] = $this->id_proof->store('documents', 'public');
        }

        // Create Center record
        Center::create([
            // 'name' => $validatedData['name'],
            'center_code' => $centerCode,
            'proprietor_name' => $validatedData['proprietor_name'],
            'address' => $validatedData['address'],
            'id_proof' => $validatedData['id_proof'] ?? null,
            'comment' => $validatedData['comment'],
            'user_id'=> $user->id,
            'total_student' => $this->total_student,
            // 'email' => $validatedData['email'],
            // 'phone_number' => $validatedData['phone_number'],
            // 'status' => $this->status,
            // 'role' => $this->role,
            // 'password' => bcrypt($validatedData['password']), // Assuming password needs to be hashed
        ]);

        // Optionally reset form fields
        $this->reset(['name', 'proprietor_name', 'address', 'id_proof', 'comment', 'total_student', 'email', 'phone_number', 'status', 'role', 'password']);

        session()->flash('message', 'Center Added Successfully');
   
}



        protected function generateCenterNumber()
    {
        $alphabet = range('A', 'Z');
        $currentLetter = 'A';
        $currentNumber = 1;

        // Fetch the last center code to determine the next one
        $lastCenter = Center::latest()->first();

        if ($lastCenter) {
            $lastCenterCode = $lastCenter->center_code;

            $lastLetter = substr($lastCenterCode, 3, 1);
            $lastNumber = intval(substr($lastCenterCode, 4, 2));

            if ($lastLetter == 'Z' && $lastNumber == 99) {
                // Reset to start from 'A01'
                $currentLetter = 'A';
                $currentNumber = 1;
            } else {
                if ($lastNumber < 99) {
                    $currentLetter = $lastLetter;
                    $currentNumber = $lastNumber + 1;
                } else {
                    $currentLetter = chr(ord($lastLetter) + 1);
                    $currentNumber = 1;
                }
            }
        }

        $centerNumber = $currentLetter . str_pad($currentNumber, 2, '0', STR_PAD_LEFT);

        return $centerNumber;
    }


    public function render()
    {
        return view('livewire.dashboard.centers',['centers'=>  User::with('center')->latest()->paginate(30)]);
    }
}
