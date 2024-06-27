<div class="">
    {{-- Page Heading --}}
    <h1 class="bg-gray-300 px-2 py-2 rounded-md text-center font-bold">Add New Student</h1>
    <form wire:submit.prevent="{{ $editMode ? 'update' : 'create' }}" class="space-y-4">

        @csrf
        {{-- Success Message --}}
        @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mb-2 rounded relative" role="alert">
            {{ session('message') }}
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Course Details --}}
            {{-- Program Selection --}}
            <div>

                <label for="program" class="block text-sm font-medium text-gray-700">Select Faculty</label>
                <select wire:model.live="selectedProgram" class="block w-full mt-1 rounded-md">
                    <option value="null" selected>Select</option>
                    @foreach ($programs as $program)
                    <option value="{{ $program->id }}">{{ $program->name }}</option>
                    @endforeach
                </select>
            @error('selectedProgram')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
            </div>

            {{-- Courses --}}

            <div>
                <label for="course" class="block text-sm font-medium text-gray-700">Select Course</label>
                <select wire:model.live="selectedCourse" id="course" name="course" class="block w-full mt-1 rounded-md">
                    <option>Select</option>
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

            {{-- Session Start --}}
            @if(!is_null($selectedCourse))
            <div class="space-y-4 text-center  border border-green-500 p-1 rounded-md">
                <span class="text-center">Session Start </span>
                {{-- Month and Year Selects --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Month Select --}}
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

                    {{-- Year Select --}}
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
                </div>
            </div>
            @endif
            {{-- Session Ends --}}

            @if (!is_null($selectedCourse))
            <div class="space-y-4 text-center  border border-green-500 p-1 rounded-md">
                <span class="text-center">Session Ends </span>
                {{-- Month and Year Selects --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Month Select --}}
                    <div>

                        <select wire:model.live="session_end_month" id="month" name="month"
                            class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Select Month</option>
                            @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August',
                            'September', 'October', 'November', 'December'] as $index => $month)
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
                </div>
            </div>
            @endif



            {{-- Name --}}
            <div>
                <div class="flex items-center">
                    <label for="name" class="block text-sm font-medium text-gray-700 w-1/3">Student Name*</label>
                    <input type="text" id="name" wire:model="name"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 w-2/3"
                        placeholder="Student Name">
                </div>
                @error('name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <div class="flex items-center">
                    <label for="gender" class="block text-sm font-medium text-gray-700 w-1/3">Gender*</label>
                    <select wire:model="gender" name="gender" id="gender"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-2/3">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>
            </div>

            <div>
                <div class="flex items-center">
                    <label for="dob" class="block text-sm font-medium text-gray-700 w-1/3">Date of Birth*</label>
                    <input wire:model="dob" type="date" name="dob" id="dob"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 w-2/3">
                    </div>
                    @error('dob')
            <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
            </div>

            <div>
                <div class="flex items-center">
                    <label for="email" class="block text-sm font-medium text-gray-700 w-1/3">Email*</label>
                    <input type="email" id="email" wire:model="email"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 w-2/3"
                        placeholder="Email">
                </div>
                @error('email')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <div class="flex items-center">
                    <label for="phone_number" class="block text-sm font-medium text-gray-700 w-1/3">Phone
                        Number*</label>
                    <input type="text" id="phone_number" wire:model="phone_number"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 w-2/3"
                        placeholder="Phone Number (10 Digit Only)" maxlength="10">
                </div>
                @error('phone_number')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <div class="flex items-center">
                    <label for="father_name" class="block text-sm font-medium text-gray-700 w-1/3">Father's
                        Name*</label>
                    <input type="text" id="father_name" wire:model="father_name"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 w-2/3"
                        placeholder="Father's Name">
                </div>
                @error('father_name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <div class="flex items-center">
                    <label for="mother_name" class="block text-sm font-medium text-gray-700 w-1/3">Mother's
                        Name*</label>
                    <input type="text" id="mother_name" wire:model="mother_name"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 w-2/3"
                        placeholder="Mother's Name">
                </div>
                @error('mother_name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <div class="flex items-center">
                    <label for="address" class="block text-sm font-medium text-gray-700 w-1/3">Address*</label>
                    <textarea id="address" wire:model="address"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 w-2/3"
                        placeholder="Full Address"></textarea>
                </div>
                @error('address')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <div class="flex items-center">
                    <label for="comment" class="block text-sm font-medium text-gray-700 w-1/3">Any Comment
                        (optional)</label>
                    <input type="text" id="comment" wire:model="comment"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 w-2/3">
                </div>
                @error('comment')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <div class="flex items-center">
                    <label for="id_proof" class="block text-sm font-medium text-gray-700 w-1/3">Student ID Proof
                        (pdf)*</label>
                    <input type="file" id="id_proof" wire:model="id_proof"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 w-2/3" accept=".pdf">
                </div>
                @error('id_proof')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <div class="flex items-center">
                    <label for="photo" class="block text-sm font-medium text-gray-700 w-1/3">Student Photo
                        (.jpeg,.jpg)*</label>
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
        </div>
        {{-- Academics Documents --}}
        <div class="bg-gray-200 px-2 py-3 rounded-md text-center">
            <h1 class="  font-bold">Academics Documents</h1>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Tenth DMC --}}
            @if ($eligibility == 10)
            <div>
                <div class="flex items-center">
                    <label for="tenth" class="block text-sm font-medium text-gray-700 w-1/3">10th DMC</label>
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



            @if ($eligibility == 15)
            <div>
                <div class="flex items-center">
                    <label for="undergraduate" class="block text-sm font-medium text-gray-700 w-1/3">Undergraduate
                        (Bachelors)</label>
                    <input type="file" id="undergraduate" wire:model="undergraduate"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 w-2/3" accept=".pdf"
                        required>
                </div>
                @error('undergraduate')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            @endif

            @if ($eligibility == 17)
            <div>
                <div class="flex items-center">
                    <label for="postgraduate" class="block text-sm font-medium text-gray-700 w-1/3">Postgraduate
                        (Masters)</label>
                    <input type="file" id="postgraduate" wire:model="postgraduate"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 w-2/3" accept=".pdf"
                        required>
                </div>
                @error('postgraduate')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            @endif
        </div>
        {{-- Submit Button --}}
        <div>
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-md shadow-md hover:bg-blue-700">{{
                $editMode ? 'Update' : 'Submit' }}</button>
        </div>
    </form>


    {{-- Centers List --}}
    {{-- <div class="mt-6 bg-green-400 rounded-md p-4">
        <h2 class="text-center font-bold text-lg mb-4">Centers List</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-md shadow-md">
                <thead class="bg-gray-100">
                    <tr>
                        <th
                            class="px-4 py-2 border-b border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider">
                            Center Code</th>
                        <th class="px-4 py-2 border-b border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider"
                            colspan="2"> Center Name</th>
                        <th class="px-4 py-2 border-b border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider"
                            colspan="2"> Person Name</th>
                        <th
                            class="px-4 py-2 border-b border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider">
                            Phone</th>
                        <th
                            class="px-4 py-2 border-b border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider">
                            Action</th>
                        <th
                            class="px-4 py-2 border-b border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider">
                            Address</th>
                        <th
                            class="px-4 py-2 border-b border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider">
                            Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($centers as $center)
                    <tr
                        class=" border-b border-gray-200 text-center {{$center->status == 'inactive' ? 'bg-yellow-400' :'bg-white hover:bg-gray-200' }}">
                        <td class="px-4 py-3 whitespace-nowrap text-xl font-bold">{{ $center->center->center_code}}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-left" colspan="2">
                            {{ $center->name }} <br>

                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-left" colspan="2">
                            {{ $center->center->proprietor_name }} <br>

                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            {{$center->phone_number}}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <a href="#"
                                class="bg-slate-500 p-2 text-white rounded hover:bg-slate-600 transition duration-300">View</a>
                            <button wire:click="edit({{ $center }})"
                                class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition duration-300">Edit</button>
                            @if ($center->status == 'active')
                            <button wire:click="deactivate({{ $center->id }})" wire:confirm="Deactivate This  Center"
                                class="bg-yellow-500 p-2 text-white rounded hover:bg-yellow-600 transition duration-300">Deactivate</button>
                            @else
                            <button wire:click="activate({{ $center->id }})" wire:confirm="Activate This Center"
                                class="bg-white p-2 text-gray-700 rounded hover:bg-gray-400 transition duration-300">Activate</button>
                            @endif --}}

                            {{-- <button wire:click="delete({{ $center->id }})"
                                wire:confirm="Are you sure to delete this center permanently ?"
                                class="bg-red-500 p-2 text-white rounded hover:bg-red-600 transition duration-300">Delete</button>
                            --}}

                            {{--
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            {{$center->center->address}}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">

                            {{$center->email}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div> --}}

    {{-- Pagination --}}
    {{-- <div class="my-3">
        {{ $centers->links() }}
    </div> --}}

</div>