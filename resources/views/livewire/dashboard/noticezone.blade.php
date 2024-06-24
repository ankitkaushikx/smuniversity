<div class="p-4">
   
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            {{ session('message') }}
        </div>
    @endif

    <h1 class="bg-gray-300 px-2 py-2 rounded-md text-center font-bold">Add New Notice</h1>
    <form wire:submit.prevent="submit" class="space-y-4">
        @csrf

        <div class="form-group">
            <label for="heading" class="block text-sm font-medium text-gray-700">Heading</label>
            <input type="text" id="heading" wire:model="heading" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            @error('heading') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="detail" class="block text-sm font-medium text-gray-700">Detail</label>
            <textarea id="detail" wire:model="detail" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
            @error('detail') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="banner" class="block text-sm font-medium text-gray-700">Banner</label>
            <input type="file" id="banner" wire:model="banner" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" accept="image/jpeg, image/jpg, image/png">
            @error('banner') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="link" class="block text-sm font-medium text-gray-700">Link</label>
            <input type="url" id="link" wire:model="link" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            @error('link') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label class="block text-sm font-medium text-gray-700">Status</label>
            <div class="mt-2 space-y-2">
                <label class="inline-flex items-center">
                    <input type="radio" wire:model="status" value="active" class="form-radio text-indigo-600">
                    <span class="ml-2">Active</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" wire:model="status" value="inactive" class="form-radio text-indigo-600">
                    <span class="ml-2">Inactive</span>
                </label>
            </div>
            @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Submit
        </button>
    </form>


    {{-- Notice List Table --}}
    <div class="mt-4 bg-green-400 rounded-md p-1">
        <h2 class="text-center font-bold text-lg mb-2">Notices</h2>
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap borde">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-3 py-3 border-b-2 border-gray-300 text-xs font-medium text-gray-500 uppercase tracking-wider">Sr.No</th>
                        <th class="px-3 py-3 border-b-2 border-gray-300 text-xs font-medium text-gray-500 uppercase tracking-wider">Heading</th>
                        {{-- <th class="px-3 py-3 border-b-2 border-gray-300 text-xs font-medium text-gray-500 uppercase tracking-wider">Detail</th> --}}
                        <th class="px-3 py-3 border-b-2 border-gray-300 text-xs font-medium text-gray-500 uppercase tracking-wider">Banner</th>
                        <th class="px-3 py-3 border-b-2 border-gray-300 text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-3 py-3 border-b-2 border-gray-300 text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody>

                    {{-- {{print_r($notices)}} --}}
                    @foreach ($notices as $notice)
                        <tr class="hover:bg-gray-50 border-b-2">
                            <td class="px-3 py-2 whitespace-nowrap">{{ $notice->id }}</td>
                            {{-- <td class="px-3 py-2 whitespace-nowrap">{{ $notice->heading }}</td> --}}
                            <td class="px-3 py-2 ">{{ Str::limit($notice->detail,20,'...') }}</td>
                            <td class="px-3 py-2 whitespace-nowrap">
                                @if ($notice->banner)
                                    <img src="{{ asset('storage/' . $notice->banner) }}" alt="Banner" class="h-12 w-12 object-cover">
                                @else
                                    No Image
                                @endif
                            </td>
                            <td class="px-3 py-2 whitespace-nowrap">{{ $notice->created_at->format('M d, Y') }}</td>
                            <td class="px-3 py-2 whitespace-nowrap">
                                <a href="#" class="bg-blue-500 p-1 text-white rounded hover:underline ">Edit</a>
                                 <button wire:click="delete({{ $notice->id }})" wire:confirm="Are You sure you want to delete this Notice ?" class="bg-red-500 p-1 rounded">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        {{-- Pagination --}}
    </div>
</div>
<div class="my-3">
     {{ $notices->links() }} 
</div>
</div>
