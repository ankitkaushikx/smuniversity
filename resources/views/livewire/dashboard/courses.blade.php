<div class="">


    {{-- Page Heading --}}
    <h1 class="bg-gray-300 px-2 py-2 rounded-md text-center font-bold">Add New Course</h1>
   <form wire:submit.prevent="{{ $editMode ? 'update' : 'create' }}" class="space-y-4">

    @csrf
    {{-- Success Message --}}
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mb-2 rounded relative" role="alert">
            {{ session('message') }}
        </div>
    @endif

    {{-- Course Name --}}
    <div class="form-group">
        <input type="text" id="name" wire:model="name" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Name Of Course *"/>
        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    {{-- Description --}}
    <div class="form-group">
        <textarea name="description" wire:model="description" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Description of Course (optional)"></textarea>
        @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    {{-- Eligibility And Duration --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label for="eligibility" class="block text-sm font-medium text-gray-700">Eligibility:</label>
            <select wire:model.lazy="eligibility" id="eligibility" name="eligibility" class="block w-full mt-1 rounded-md">
                <option value="10">Tenth</option>
                <option value="11">Diploma</option>
                <option value="12">Twelfth</option>
                <option value="15">Undergraduate</option>
                <option value="17">Postgraduate</option>
            </select>
        </div>
        <div>
            <label for="duration" class="block text-sm font-medium text-gray-700">Duration:</label>
            <select wire:model.lazy="duration" id="duration" name="duration" class="block w-full mt-1 rounded-md">
                <option value="3">3 Month</option>
                <option value="6">6 Month</option>
                <option value="12">1 Year</option>
                <option value="24">2 Year</option>
                <option value="36">3 Year</option>
                <option value="48">4 Year</option>
                <option value="60">5 Year</option>
            </select>
        </div>
    </div>

    {{-- Faculty --}}
    <div>
        <label for="program" class="block text-sm font-medium text-gray-700">Select Faculty</label>
        <select wire:model="program" id="program" name="program" class="block w-full mt-1 rounded-md">
            <option>Select</option>
            @foreach ($programs as $program)
                <option class="{{ $program->deleted_at ? 'bg-red-400': '' }}" value="{{ $program->id }}">{{ $program->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- Banner --}}
    <div class="form-group">
        <label for="banner" class="block text-sm font-medium text-gray-700">Banner (Optional)</label>
        <input type="file" id="banner" wire:model="banner" class="mt-1 block w-full border border-gray-300 sm:text-sm border-gray-300 rounded-md" accept="image/jpeg, image/jpg, image/png">
        @error('banner') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    {{-- Comment --}}
    <div class="form-group">
        <input type="text" id="comment" wire:model="comment" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Comment For Faculty (optional)"/>
        @error('comment') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    {{-- Submit --}}
    <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-md shadow-md hover:bg-blue-700">
        {{ $editMode ? 'Update' : 'Submit' }}
    </button>
</form>



    {{-- Course List Table --}}
    <div class="mt-6 bg-green-400 rounded-md p-4">
    <h2 class="text-center font-bold text-lg mb-4">Course List</h2>
    {{-- Search Field --}}
     <input type="text" wire:model.live.debounce.500ms="search" placeholder="Search in... | Name | Program | Status | " class="px-4 py-2 border rounded mb-4 w-full">
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-md shadow-md">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border-b border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider">Sr.No</th>
                    <th class="px-4 py-2 border-b border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider" colspan="2">Name</th>
                    <th class="px-4 py-2 border-b border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider" colspan="2">Faculty</th>
                    <th class="px-4 py-2 border-b border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider">Banner</th>
                    <th class="px-4 py-2 border-b border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($courses as $course)
                    <tr class=" border-b border-gray-200 text-center {{$course->status == 'inactive' ? 'bg-yellow-400' : 'bg-white hover:bg-gray-100'}}">
                        <td class="px-4 py-3 whitespace-nowrap text-xl">{{ $course->id }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-left text-lg font-bold" colspan="2">{{ $course->name }}<br>
                      </td>

                        <td class="px-4 py-3 whitespace-nowrap text-left " colspan="2">{{$course->program->name}}</td>

                        <td class="px-4 py-3 whitespace-nowrap">
                            @if ($course->banner)
                                <img src="{{ asset('storage/' . $course->banner) }}" alt="Banner" class="h-12 w-12 object-cover rounded-md">
                            @else
                                <span class="text-gray-500">No Image</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <a href="#" class="bg-slate-500 p-2 text-white rounded hover:bg-slate-600 transition duration-300">View</a>
                            <button wire:click="edit({{ $course }})" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition duration-300">Edit</button>
                            @if ($course->status == 'inactive')
                                <button wire:click="unhide({{ $course->id }})" wire:confirm="Activate This Course ?" class="bg-white p-2 rounded hover:bg-yellow-600 transition duration-300 text-black">Activate</button>
                            @else
                                <button wire:click="hide({{ $course->id }})" wire:confirm="Deactivate This course ?" class="bg-gray-300 p-2 text-gray-700 rounded hover:bg-gray-400 transition duration-300">Deactivate</button>
                            @endif
                            {{-- <button wire:click="delete({{ $course->id }})" wire:confirm="Are You Sure to permantely delete this course ?" class="bg-red-500 p-2 text-white rounded hover:bg-red-600 transition duration-300">Delete</button> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

    {{-- Pagination --}}
    <div class="my-3">
     {{ $courses->links() }} 
</div>
</div>

