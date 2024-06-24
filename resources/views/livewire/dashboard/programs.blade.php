<div class="">

{{-- Success Message --}}
 @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            {{ session('message') }}
        </div>
    @endif
    {{-- Page Heading --}}
    <h1 class="bg-gray-300 px-2 py-2 rounded-md text-center font-bold">Add New Faculty</h1>
    <form wire:submit.prevent=" create" class="space-y-4">
     @csrf
    
     {{-- Program Name --}}
    <div class="form-group">
     <input type="text" id="name" wire:model="name" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Name Of Faculty"/>
     @error('name')
      <span class="text-red-500 text-sm">{{$message}}</span>         
     @enderror
    </div>

    {{-- Description --}}
    <div class="form-group">
     <textarea name="description" wire:model="description" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Description of Faculty (optional)"></textarea>
     @error('description')
      <span class="text-red-500 text-sm">{{$message}}</span>         
     @enderror
    </div>

    {{--Banner   --}}
    <div class="form-group">
            <label for="banner" class="block text-sm font-medium text-gray-700">Banner</label>
            <input type="file" id="banner" wire:model="banner" class="mt-1 block w-full border border-gray-300 sm:text-sm border-gray-300 rounded-md" accept="image/jpeg, image/jpg, image/png">
            @error('banner') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Comment --}}
         <div class="form-group">
     <input type="text" id="comment" wire:model="comment" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" placeholder="Comment For Faculty"/>
     @error('comment')
      <span class="text-red-500 text-sm">{{$message}}</span>         
     @enderror
    </div>

    {{-- Submit --}}
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Submit
        </button>
    </form>


    {{-- Program List Table --}}
    <div class="mt-6 bg-green-400 rounded-md p-1">
        <h2 class="text-center font-bold text-lg mb-2">Faculty List</h2>
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap borde">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-3 py-3 border-b-2 border-gray-300 text-xs font-medium text-gray-500 uppercase tracking-wider">Sr.No</th>
                        <th class="px-3 py-3 border-b-2 border-gray-300 text-xs font-medium text-gray-500 uppercase tracking-wider" colspan="2">Name</th>
                        {{-- <th class="px-3 py-3 border-b-2 border-gray-300 text-xs font-medium text-gray-500 uppercase tracking-wider">Detail</th> --}}
                        <th class="px-3 py-3 border-b-2 border-gray-300 text-xs font-medium text-gray-500 uppercase tracking-wider">Banner</th>
                        {{-- <th class="px-3 py-3 border-b-2 border-gray-300 text-xs font-medium text-gray-500 uppercase tracking-wider">Date Created</th> --}}
                        <th class="px-3 py-3 border-b-2 border-gray-300 text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody>

                    {{-- {{print_r($notices)}} --}}
                    @foreach ($programs as $program)
                        <tr class="hover:bg-gray-50 border-b-2 text-center">
                            <td class="px-3 py-2 whitespace-nowrap">{{ $program->id }}</td>
                            <td class="px-3 py-2 whitespace-nowrap" colspan="2">{{ $program->name}}</td>
                            {{-- <td class="px-3 py-2 ">{{ Str::limit($program->detail,20,'...') }}</td> --}}
                            <td class="px-3 py-2 whitespace-nowrap">
                                @if ($program->banner)
                                    <img src="{{ asset('storage/' . $program->banner) }}" alt="Banner" class="h-12 w-12 object-cover">
                                @else
                                    No Image
                                @endif
                            </td>
                            {{-- <td class="px-3 py-2 whitespace-nowrap">{{ $program->created_at->format('M d, Y') }}</td> --}}
                            <td class="px-3 py-2 whitespace-nowrap ">
                                <a href="#" class="bg-slate-500 p-1 text-white rounded hover:underline ">View</a> 
                                  <button wire:click="edit({{ $program->id }})"  class="bg-blue-500 text-white p-1 rounded">Edit</button>
                               @if ($program->trashed())
                                    <button wire:click="unhide({{ $program->id }})" wire:confirm="Are You sure you want to hide this program ?" class="bg-white p-1 rounded">Unhide</button>
                               @else
                                 <button wire:click="hide({{ $program->id }})" wire:confirm="Are You sure you want to hide this program ?" class="bg-slate-300 p-1 rounded">Hide</button>
                               @endif
                               <button wire:click="delete({{ $program->id }})" wire:confirm="Are You sure you want to delete this program ?" class="bg-red-500 p-1 rounded">Delete</button>

                               
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