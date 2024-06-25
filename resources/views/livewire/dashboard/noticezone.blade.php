<div class="p-4">

    
    <h1 class="bg-gray-300 px-4 py-2 rounded-md text-center font-bold mb-4">{{$editMode ? 'Update Notice': 'Add New Notice'}}</h1>
    <form wire:submit.prevent="{{ $editMode ? 'update' : 'create' }}" class="space-y-4">
        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                {{ session('message') }}
            </div>
        @endif
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="form-group">
                <label for="heading" class="block text-sm font-medium text-gray-700">Heading</label>
                <input type="text" id="heading" wire:model="heading" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Notice Heading">
                @error('heading') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="detail" class="block text-sm font-medium text-gray-700">Detail</label>
                <textarea id="detail" wire:model="detail" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Details For Notice"></textarea>
                @error('detail') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="banner" class="block text-sm font-medium text-gray-700">Banner</label>
                <input type="file" id="banner" wire:model="banner" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" accept="image/jpeg, image/jpg, image/png" >
                @error('banner') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="link" class="block text-sm font-medium text-gray-700">Link</label>
                <input type="url" id="link" wire:model="link" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="External Link For Notice">
                @error('link') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        

        <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-md shadow-md hover:bg-blue-700">
            Submit
        </button>
    </form>

    {{-- Notice List Table --}}
    <div class="mt-6 bg-green-400 rounded-md p-4">
        <h2 class="text-center font-bold text-lg mb-4">Notices</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-md shadow-md">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border-b border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider">Sr.No</th>

                        <th class="px-4 py-2 border-b border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider" colspan="2">Heading</th>

                        <th class="px-4 py-2 border-b border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider">Banner</th>

                        
                        <th class="px-4 py-2 border-b border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notices as $notice)
                        <tr class="hover:bg-gray-200 border-b border-gray-200">
                            <td class="px-4 py-3 whitespace-nowrap">{{ $notice->id }}</td>
                            <td class="px-4 py-3" colspan="2">{{ $notice->heading }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                @if ($notice->banner)
                                    <img src="{{ asset('storage/' . $notice->banner) }}" alt="Banner" class="h-12 w-12 object-cover rounded-md">
                                @else
                                    <span class="text-gray-500">No Image</span>
                                @endif
                            </td>
                            {{-- <td class="px-4 py-3 whitespace-nowrap">{{ $notice->created_at->format('M d, Y') }}</td> --}}
                             <td class="px-4 py-3 whitespace-nowrap space-x-2 text-right">
                            <a href="#" class="bg-slate-500 text-white p-2 rounded hover:bg-slate-600 transition duration-300">View</a> 
                            <button wire:click="edit({{ $notice->id }})" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition duration-300">Edit</button>
                            @if ($notice->trashed())
                                <button wire:click="unhide({{ $notice->id }})" wire:confirm="Are You sure you want to hide this notice?" class="bg-yellow-500 text-white p-2 rounded hover:bg-yellow-600 transition duration-300">Unhide</button>
                            @else
                                <button wire:click="hide({{ $notice->id }})" wire:confirm="Are You sure you want to hide this notice?" class="bg-gray-300 text-gray-700 p-2 rounded hover:bg-gray-400 transition duration-300">Hide</button>
                            @endif
                            <button wire:click="delete({{ $notice->id }})" wire:confirm="Are You sure you want to delete this notice?" class="bg-red-500 text-white p-2 rounded hover:bg-red-600 transition duration-300">Delete</button>
                        </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- Pagination --}}
        <div class="my-3">
            {{ $notices->links() }} 
        </div>
    </div>
</div>
