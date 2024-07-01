<div class="">

{{$subjects}}
    {{-- Page Heading --}}
    <h1 class="bg-gray-300 px-2 py-2 rounded-md text-center font-bold">Add New Subject</h1>
    <form wire:submit.prevent="{{ $editMode ? 'update' : 'create' }}" class="space-y-4">

        @csrf
        {{-- Success Message --}}
        @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mb-2 rounded relative" role="alert">
            {{ session('message') }}
        </div>
        @endif


        {{-- Faculty List --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-4">
            {{-- Faculty Select--}}
            <div>
                <label for="program" class="block text-sm font-medium text-gray-700">
                    Select Faculty*</label>

                <select wire:model.live="selectedProgram" class="block w-full mt-1 rounded-md">
                    <option>Select Faculty</option>
                    @foreach ($programs as $program)
                    <option class="{{$program->status == 'inactive' ? 'bg-red-500': ''}}" value="{{ $program->id }}">{{ $program->name }}</option>
                    @endforeach
                </select>

                @error('selectedProgram')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>


            {{-- Select Course --}}
            <div>
                <label for="course" class="block text-sm font-medium text-gray-700">
                    Select Course*</label>

                <select wire:model.live="selectedCourse" id="course" name="course" class="block w-full mt-1 rounded-md">
                    <option>Select Course</option>
                    @if (!is_null($courses))
                    @foreach ($courses as $course)
                    <option class="{{$course->status == 'inactive' ? 'bg-red-500': ''}}"  value="{{ $course->id }}">{{ $course->name }} ({{ $course->id }})</option>
                    @endforeach
                    @endif
                </select>

                @error('selectedCourse')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

        </div> {{--- Grid End ---}}

        {{-- 7 column Grid --}}
        @if ($selectedCourse)
        <div class="grid grid-cols-1 md:grid-cols-9 gap-2 p-2 bg-green-500 text-black rounded py-2">
            <div class="p-2 col-span-full text-lg text-center font-bold">
                Add New Subject
            </div>
            {{-- Year --}}
            <div class="">
                <div class="form-group">
                    <label for="year" class="block text-sm font-medium ">
                        Year</label>
                    <input type="number" id="year" wire:model="year"
                        class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Year"
                        max="500" min="0" />
                    @error('year') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Semester --}}
            <div class="">
                <div class="form-group">
                    <label for="semester" class="block text-sm font-medium ">
                        Semester</label>
                    <input type="number" id="semester" wire:model="semester"
                        class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Semester"
                        max="500" min="0" />
                    @error('semester') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Name --}}
            <div class="  col-span-2">
                <div class="form-group">
                    <label for="name" class="block text-sm font-medium ">
                        Subject Name</label>
                    <input type="text" id="name" wire:model="name"
                        class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        placeholder="Subject Name" />
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            {{--MAximum MArks --}}
            <div class=" ">
                <div class="form-group">
                    <label for="MaximumMarks" class="block text-sm font-medium ">
                        Maximum Marks </label>
                    <input type="number" id="maximumMarks" wire:model="maximumMarks"
                        class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        placeholder="Maximum Marks" max="500" min="0" />
                    @error('maximumMarks') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Passing Marks --}}
            <div class=" ">
                <div class="form-group">
                    <label for="passingMarks" class="block text-sm font-medium ">
                        Passing Marks </label>
                    <input type="number" id="passingMarks" wire:model="passingMarks"
                        class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        placeholder="Passing Marks" max="500" min="0" />
                    @error('passingMarks') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Theory Marks --}}
            <div class=" ">
                <div class="form-group">
                    <label for="theoryMarks" class="block text-sm font-medium ">
                        Theory Marks </label>
                    <input type="number" id="theoryMarks" wire:model="theoryMarks"
                        class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        placeholder="Theory Marks" max="500" min="0" />
                    @error('theoryMarks') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>


            {{-- Practical Marks --}}
            <div class=" ">
                <div class="form-group">
                    <label for="practicalMarks" class="block text-sm font-medium ">
                        Practical Marks</label>
                    <input type="number" id="practicalMarks" wire:model="practicalMarks"
                        class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        placeholder="Theory Marks" max="500" min="0" value="0" />
                    @error('practicalMarks') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Submit --}}
            <div class="flex justify-center items-end p-0" >
                <button type="submit" class="bg-blue-700 text-white p-2 rounded-md shadow-md hover:bg-blue-800 mb-2">
                    {{ $editMode ? 'Update' : 'Submit' }}
                </button>
            </div>

        </div>
        @endif
    </form> {{---Form Ends---}}



    {{-- Course List Table --}}
    {{-- <div class="mt-6 bg-green-400 rounded-md p-4">
        <h2 class="text-center font-bold text-lg mb-4">Course List</h2> --}}
        {{-- Search Field --}}
        {{-- <input type="text" wire:model.live.debounce.500ms="search"
            placeholder="Search in... | Name | Program | Status | " class="px-4 py-2 border rounded mb-4 w-full">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-md shadow-md">
                <thead class="bg-gray-100">
                    <tr>
                        <th
                            class="px-4 py-2 border-b border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider">
                            Sr.No</th>
                        <th class="px-4 py-2 border-b border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider"
                            colspan="2">Name</th>
                        <th class="px-4 py-2 border-b border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider"
                            colspan="2">Faculty</th>
                        <th
                            class="px-4 py-2 border-b border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider">
                            Banner</th>
                        <th
                            class="px-4 py-2 border-b border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider">
                            Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                    <tr
                        class=" border-b border-gray-200 text-center {{$course->status == 'inactive' ? 'bg-yellow-400' : 'bg-white hover:bg-gray-100'}}">
                        <td class="px-4 py-3 whitespace-nowrap text-xl">{{ $course->id }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-left text-lg font-bold" colspan="2">{{ $course->name
                            }}<br>
                        </td>

                        <td class="px-4 py-3 whitespace-nowrap text-left " colspan="2">{{$course->program->name}}</td>

                        <td class="px-4 py-3 whitespace-nowrap">
                            @if ($course->banner)
                            <img src="{{ asset('storage/' . $course->banner) }}" alt="Banner"
                                class="h-12 w-12 object-cover rounded-md">
                            @else
                            <span class="text-gray-500">No Image</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <a href="#"
                                class="bg-slate-500 p-2 text-white rounded hover:bg-slate-600 transition duration-300">View</a>
                            <button wire:click="edit({{ $course }})"
                                class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition duration-300">Edit</button>
                            @if ($course->status == 'inactive')
                            <button wire:click="unhide({{ $course->id }})" wire:confirm="Activate This Course ?"
                                class="bg-white p-2 rounded hover:bg-yellow-600 transition duration-300 text-black">Activate</button>
                            @else
                            <button wire:click="hide({{ $course->id }})" wire:confirm="Deactivate This course ?"
                                class="bg-gray-300 p-2 text-gray-700 rounded hover:bg-gray-400 transition duration-300">Deactivate</button>
                            @endif
                            {{-- <button wire:click="delete({{ $course->id }})"
                                wire:confirm="Are You Sure to permantely delete this course ?"
                                class="bg-red-500 p-2 text-white rounded hover:bg-red-600 transition duration-300">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination
    <div class="my-3">
        {{ $courses->links() }}
    </div> --}}
</div>