<div class="">


    {{-- Page Heading --}}
    <h1 class="bg-gray-300 px-2 py-2 rounded-md text-center font-bold">Add New Faculty</h1>
    <form wire:submit.prevent="{{ $editMode ? 'update' : 'create' }}" class="space-y-4">
    @csrf
    {{-- Success Message --}}
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mb-2 rounded relative" role="alert">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        {{-- Program Name --}}
        <div class="form-group">
            <label for="name" class="block text-sm font-medium text-gray-700">Name Of Faculty *</label>
            <input type="text" id="name" wire:model="name" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Name Of Faculty *"/>
            @error('name') <span class="text-red-500 text-sm">{{$message}}</span> @enderror
        </div>

        {{-- Description --}}
        <div class="form-group">
            <label for="description" class="block text-sm font-medium text-gray-700">Description of Faculty (optional)</label>
            <textarea id="description" wire:model="description" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Description of Faculty (optional)"></textarea>
            @error('description') <span class="text-red-500 text-sm">{{$message}}</span> @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        {{-- Banner --}}
        <div class="form-group">
            <label for="banner" class="block text-sm font-medium text-gray-700">Banner (Optional)</label>
            <input type="file" id="banner" wire:model="banner" class="mt-1 block w-full border border-gray-300 sm:text-sm border-gray-300 rounded-md" accept="image/jpeg, image/jpg, image/png">
            @error('banner') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Comment --}}
        <div class="form-group">
            <label for="comment" class="block text-sm font-medium text-gray-700">Comment For Faculty (optional)</label>
            <input type="text" id="comment" wire:model="comment" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Comment For Faculty (optional)"/>
            @error('comment') <span class="text-red-500 text-sm">{{$message}}</span> @enderror
        </div>
    </div>

    {{-- Submit --}}
    <div class="flex justify-end">
        <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-md shadow-md hover:bg-blue-700">
            Submit
        </button>
    </div>
</form>



    {{-- Program List Table --}}
   <div class="mt-6 bg-green-400 rounded-md p-4">
    <h2 class="text-center font-bold text-lg mb-4">Faculty List</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-md shadow-md">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border-b border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider">Sr.No</th>
                    <th class="px-4 py-2 border-b border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider" colspan="2">Name</th>
                    <th class="px-4 py-2 border-b border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider">Banner</th>
                    <th class="px-4 py-2 border-b border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($programs as $program)
                    <tr class="hover:bg-gray-100 border-b border-gray-200 text-center">
                        <td class="px-4 py-3 whitespace-nowrap">{{ $program->id }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-left" colspan="2">{{ $program->name }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @if ($program->banner)
                                <img src="{{ asset('storage/' . $program->banner) }}" alt="Banner" class="h-12 w-12 object-cover rounded-md">
                            @else
                                <span class="text-gray-500">No Image</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap space-x-2">
                            <a href="#" class="bg-slate-500 text-white p-2 rounded hover:bg-slate-600 transition duration-300">View</a> 
                            <button wire:click="edit({{ $program->id }})" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition duration-300">Edit</button>
                            @if ($program->trashed())
                                <button wire:click="unhide({{ $program->id }})" wire:confirm="Are You sure you want to hide this program?" class="bg-yellow-500 text-white p-2 rounded hover:bg-yellow-600 transition duration-300">Unhide</button>
                            @else
                                <button wire:click="hide({{ $program->id }})" wire:confirm="Are You sure you want to hide this program?" class="bg-gray-300 text-gray-700 p-2 rounded hover:bg-gray-400 transition duration-300">Hide</button>
                            @endif
                            <button wire:click="delete({{ $program->id }})" wire:confirm="Are You sure you want to delete this program?" class="bg-red-500 text-white p-2 rounded hover:bg-red-600 transition duration-300">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

    {{-- Pagination --}}
    <div class="my-3">
     {{ $programs->links() }} 
    </div>
</div>