<div>

    {{-- Page Heading  --}}
    <h1 class="bg-gray-300 p-3 rounded-md text-center font-bold">
        {{$editMode ? 'Update Student' : 'Add New Student' }}</h1>
        
     
    {{-- Student Registration Form --}}
    <form wire:submit.prevent="{{ $editMode ? 'update' : 'create' }}" class="space-y-4">
        @csrf
            {{-- Session Message --}}
            @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mb-2 rounded relative" role="alert">
            {{ session('message') }}
            </div>
            @endif

            {{-- 2*2 Form Grid --}}
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

            {{-- Faculty Select--}}
            <div>  
                    <label for="program" class="block text-sm font-medium text-gray-700">
                    Select Faculty*</label>

                    <select wire:model.live="selectedProgram" class="block w-full mt-1 rounded-md">
                    <option>Select Faculty</option>
                    @foreach ($programs as $program)
                    <option value="{{ $program->id }}">{{ $program->name }}</option>
                    @endforeach
                    </select>

                    @error('selectedProgram')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
            </div>

           
            {{-- Select Course  --}}
            <div>
                 <label for="course" class="block text-sm font-medium text-gray-700">
                Select Course*</label>

                <select wire:model.live="selectedCourse" id="course" name="course" class="block w-full mt-1 rounded-md">
                    <option>Select Course</option>
                    @if (!is_null($courses))
                    @foreach ($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->name }} ({{ $course->id }})</option>
                    @endforeach
                    @endif
                </select>

                @error('selectedCourse')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Session Start Grid  --}}
            @if(!is_null($selectedCourse))

            <div class="space-y-4 text-center  border-2 border-green-500 p-1 rounded-md">
                <span class="text-center">Session Start</span>
                 {{-- session Start Grid 2*2 --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    {{-- Session Start Month Select --}}
                    <div>
                        <select wire:model.live="session_start_month" id="month" name="month"
                            class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Select Month</option>
                            @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
                            'September', 'October', 'November', 'December'] as $index => $month)
                            <option value="{{ $index + 1 }}">{{ $month }}</option>
                            @endforeach
                        </select>
                            @error('session_start_month')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                    </div>

                    {{-- Session Start Year Select --}}
                    <div>
                        <select wire:model.live="session_start_year" id="year" name="year"
                            class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Select Year</option>
                            @for ($year = date('Y'); $year >= 2010; $year--)
                            <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                            @error('session_start_year')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                    </div>

                </div> {{-- Grid Ends Here--}}
            </div>
            @endif


            {{-- Session Ends --}}
            @if (!is_null($selectedCourse))
            <div class="space-y-4 text-center  border-2 border-green-500 p-1 rounded-md">
                <span class="text-center">Session Ends </span>
                {{-- Session End Grid 2*2 --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    {{-- Month Select --}}
                    <div>
                        <select wire:model.live="session_end_month" id="month" name="month"
                            class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Select Month</option>
                            @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August','September', 'October', 'November', 'December'] as $index => $month)
                            <option value="{{ $index + 1 }}">{{ $month }}</option>
                            @endforeach
                        </select>
                            @error('session_end_month')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                    </div>

                    {{-- Year Select --}}
                    <div>
                        <select wire:model.live="session_end_year" id="year" name="year"
                            class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Select Year</option>
                            @for ($year = date('Y') + 6; $year >= 2010; $year--)
                            <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                            @error('session_end_year')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                    </div>

                </div> {{--Grid Ends --}}
            </div>
            @endif

            {{-- Student Name --}}
            <div>
                <div class="flex items-center">
                    <label for="name" class="block text-sm font-medium text-gray-700 w-1/3">
                    Student Name*</label>

                    <input type="text" id="name" wire:model="name"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 w-2/3"
                    placeholder="Student Name">
                </div>

                @error('name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Gender --}}
            <div>
                <div class="flex items-center">
                    <label for="gender" class="block text-sm font-medium text-gray-700 w-1/3">
                    Gender*</label>
                    <select wire:model="gender" name="gender" id="gender"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-2/3">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
            </div>

            {{-- DOB --}}
            <div>
                <div class="flex items-center">
                    <label for="dob" class="block text-sm font-medium text-gray-700 w-1/3">
                    Date of Birth*</label>
                    <input wire:model="dob" type="date" name="dob" id="dob"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-2/3">
                    </div>

                     @error('dob')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
            </div>

            {{-- Email --}}
            <div>
                <div class="flex items-center">
                    <label for="email" class="block text-sm font-medium text-gray-700 w-1/3">
                    Email*</label>

                    <input type="email" id="email" wire:model="email"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 w-2/3"
                    placeholder="Email">
                </div>

                    @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
            </div>

            {{-- Phone Number --}}
            <div>
                <div class="flex items-center">
                    <label for="phone_number" class="block text-sm font-medium text-gray-700 w-1/3">Phone Number*</label>
                    <input type="text" id="phone_number" wire:model="phone_number"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 w-2/3"
                        placeholder="10 Digit Only" maxlength="10" minlength="10">
                </div>

                    @error('phone_number')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
            </div>

            {{-- Father's Name --}}
            <div>
                <div class="flex items-center">
                <label for="father_name" class="block text-sm font-medium text-gray-700 w-1/3">
                    Father's Name*</label>
                    <input type="text" id="father_name" wire:model="father_name"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 w-2/3"
                        placeholder="Father's Name">
                </div>

                    @error('father_name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
            </div>

            {{-- Mother's Name --}}
            <div>
                <div class="flex items-center">
                <label for="mother_name" class="block text-sm font-medium text-gray-700 w-1/3">
                    Mother's Name*
                </label>
                    <input type="text" id="mother_name" wire:model="mother_name"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 w-2/3"
                        placeholder="Mother's Name">
                </div>

                    @error('mother_name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
            </div>

            {{-- Address --}}
            <div>
                <div class="flex items-center">
                    <label for="address" class="block text-sm font-medium text-gray-700 w-1/3">
                    Address*
                    </label>
                    <textarea id="address" wire:model="address"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 w-2/3"
                        placeholder="Full Address"></textarea>
                </div>
                    @error('address')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
            </div>

            {{--Comments  --}}
            <div>
                <div class="flex items-center">
                    <label for="comment" class="block text-sm font-medium text-gray-700 w-1/3">Any Comment(optional)
                    </label>
                    <input type="text" id="comment" wire:model="comment"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 w-2/3">
                </div>

                @error('comment')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- ID Proof --}}
            <div>
                <div class="flex items-center">
                    <label for="id_proof" class="block text-sm font-medium text-gray-700 w-1/3">
                    Student ID Proof* [.pdf]
                </label>
                    <input type="file" id="id_proof" wire:model="id_proof"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 w-2/3" accept=".pdf">
                </div>

                @error('id_proof')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Photo --}}
            <div>
                <div class="flex items-center">
                    <label for="photo" class="block text-sm font-medium text-gray-700 w-1/3">
                    Student Photo* [.jpeg,.jpg]
                    </label>
                    <input type="file" id="photo" wire:model="photo"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 w-2/3"
                        accept="image/jpeg, image/jpg">
                </div>
                @error('photo')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            {{-- Preview Image --}}
            <div>
                @if ($photo)
                <img width="150px" height="auto" class="rounded-md" src="{{ $photo->temporaryUrl() }}">
                @endif
            </div>

        </div> {{--2*2 Form Grid Ends Here--}}
    

        {{-- -----------------------------ACADEMICS DOCUMENTS ---------------------------------- --}}
        {{-- Heading --}}
        <div class="bg-gray-200 p-3  mt-4 rounded-md text-center">
            <p class="text-lg font-bold">Academic Documents</p>
        </div>

        {{-- 2*2 Grid For Documents --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        
            {{-- Tenth DMC --}}
            @if ($eligibility == 10)
            <div>
                <div class="flex items-center">
                    <label for="tenth" class="block text-sm font-medium text-gray-700 w-1/3">
                    10th DMC</label>
                    <input type="file" id="tenth" wire:model="tenth"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 w-2/3" accept=".pdf"
                    required>
                </div>
                @error('tenth')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            @endif


            {{-- Diploma --}}
            @if ($eligibility == 11)
            <div>
                <div class="flex items-center">
                    <label for="diploma" class="block text-sm font-medium text-gray-700 w-1/3">Previous Diploma</label>
                    <input type="file" id="diploma" wire:model="diploma"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 w-2/3" accept=".pdf"
                     required>
                </div>
                @error('diploma')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            @endif


            {{-- 12th DMC --}}
            @if ($eligibility == 12)
            <div>
                <div class="flex items-center">
                    <label for="twelfth" class="block text-sm font-medium text-gray-700 w-1/3">12th DMC</label>
                    <input type="file" id="twelfth" wire:model="twelfth"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 w-2/3" accept=".pdf"
                    required>
                </div>
                @error('twelfth')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            @endif

            {{-- UnderGraduate Degree --}}
            @if ($eligibility == 15)
            <div>
                <div class="flex items-center">
                    <label for="undergraduate" class="block text-sm font-medium text-gray-700 w-1/3">
                    Undergraduate(Bachelors)</label>
                    <input type="file" id="undergraduate" wire:model="undergraduate"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 w-2/3" accept=".pdf"
                    required>
                </div>
                @error('undergraduate')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            @endif

            {{-- Post Graduate Degree --}}
            @if ($eligibility == 17)
            <div>
                <div class="flex items-center">
                    <label for="postgraduate" class="block text-sm font-medium text-gray-700 w-1/3">Postgraduate(Masters)</label>
                    <input type="file" id="postgraduate" wire:model="postgraduate"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 w-2/3" accept=".pdf"
                    required>
                </div>
                @error('postgraduate')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            @endif


        </div> {{--2*2 Grid Ends HERE--}}

        {{-- Submit Button --}}
        <div>
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-md shadow-md hover:bg-blue-700">{{
            $editMode ? 'Update' : 'Submit' }}</button>
        </div>

    </form>  {{--Form Ends HERE--}}


    {{-- --------------------------------STUDENT LIST TABLE --------------------------------}}

    <div class="mt-6 bg-green-400 rounded-md p-4">
        
        <!-- Heading for the table -->
        <h2 class="text-center font-bold text-lg mb-4">Latest Students</h2>

        <!-- Search input for students -->
        <input type="text" wire:model.live.debounce.500ms="search" placeholder="Search in... Enrollment code | Name | Course | Phone Number | Status" class="px-4 py-2 border rounded mb-4 w-full">
    
    <!-- Table container with horizontal scrolling -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr class="text-left bg-slate-500 text-white">
                    <!-- Table headers -->
                    <th class="px-4 py-2 border-b border-gray-300 text-xs font-medium uppercase tracking-wider">Enrollment</th>
                    <th class="px-4 py-2 border-b border-gray-300 text-xs font-medium uppercase tracking-wider">Comment</th>
                    <th class="px-4 py-2 border-b border-gray-300 text-xs font-medium uppercase tracking-wider">Photo</th>
                    <th class="px-4 py-2 border-b border-gray-300 text-xs font-medium uppercase tracking-wider">Name</th>
                    <th class="px-4 py-2 border-b border-gray-300 text-xs font-medium uppercase tracking-wider">Course</th>
                    <th class="px-4 py-2 border-b border-gray-300 text-xs font-medium uppercase tracking-wider">Phone No.</th>
                    <th class="px-4 py-2 border-b border-gray-300 text-xs font-medium uppercase tracking-wider">Action</th>
                    <th class="px-4 py-2 border-b border-gray-300 text-xs font-medium uppercase tracking-wider">DOB (M/F)</th>
                    <th class="px-4 py-2 border-b border-gray-300 text-xs font-medium uppercase tracking-wider">Father's Name</th>
                    <th class="px-4 py-2 border-b border-gray-300 text-xs font-medium uppercase tracking-wider">Mother's Name</th>
                    <th class="px-4 py-2 border-b border-gray-300 text-xs font-medium uppercase tracking-wider">Address</th>
                    <th class="px-4 py-2 border-b border-gray-300 text-xs font-medium uppercase tracking-wider">Email</th>
                    <th class="px-4 py-2 border-b border-gray-300 text-xs font-medium uppercase tracking-wider">ID Proof</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr class="font-semibold text-gray-700 border-b border-gray-200 text-student {{ $student->user->status == 'inactive' ? 'bg-yellow-400' : 'bg-white hover:bg-gray-200' }}">
                        <!-- Student details -->
                        <td class="px-4 py-3 whitespace-nowrap text-xl font-bold">{{ $student->student_code }}</td>
                        
                        <td class="px-4 whitespace-nowrap">
                            <!-- Comment icon (highlighted if comment exists) -->
                            <svg class="w-6 h-6 @if (!is_null($student->comment)) bg-red-500 text-white @endif dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 0 1 1-1h11.586a1 1 0 0 1 .707.293l2.414 2.414a1 1 0 0 1 .293.707V19a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V5Z"/>
                                <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M8 4h8v4H8V4Zm7 10a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            </svg>
                        </td>
                        
                        <td>
                            <!-- Student photo -->
                            <img src="{{ asset('storage/' . $student->photo) }}" style="min-height:200px min-width:200px" class="rounded-full">
                        </td>
                        
                        <td class="px-4 py-3 whitespace-nowrap">{{ $student->user->name }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $student->course->name }} ({{$student->course->id}})</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $student->user->phone_number }}</td>
                        
                        <td class="px-4 py-3 whitespace-nowrap">
                            <!-- Action buttons -->
                            <a href="#" class="bg-slate-500 p-2 text-white rounded hover:bg-slate-600 transition duration-300">View</a>
                            {{-- Uncomment and use these buttons as needed --}}
                            
                           @if ($isAdmin)   {{--- Is Admin ---}}
                                <button wire:click="edit({{ $student->id }})" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition duration-300">Edit</button>
                            @if ($student->user->status == 'active')
                                <button wire:click="deactivate({{ $student->user->id }})" wire:confirm="Deactivate This student" class="bg-yellow-500 p-2 text-white rounded hover:bg-yellow-600 transition duration-300">Deactivate</button>
                            @else
                                <button wire:click="activate({{ $student->user->id }})" wire:confirm="Activate This student" class="bg-white p-2 text-gray-700 rounded hover:bg-gray-400 transition duration-300">Activate</button>
                            @endif 
                           @endif
                           
                            
                        </td>
                        
                        <td class="px-4 py-3 whitespace-nowrap">{{ date('d-m-Y', strtotime($student->dob)) }} ({{ substr($student->gender, 0, 1) }})</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $student->father_name }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $student->mother_name }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $student->address }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">{{ $student->user->email }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-blue-500">
                            <!-- Link to view ID proof -->
                            <a href="{{ asset('storage/' . $student->id_proof) }}" target="_blank">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="my-3">
        {{ $students->links() }}
    </div>
</div>
