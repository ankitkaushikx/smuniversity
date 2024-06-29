<div class="">
   
    {{-- Page Heading --}}
    <h1 class="bg-gray-300 px-2 py-2 rounded-md text-center font-bold">Add New Center</h1>
    <form wire:submit.prevent="{{$editMode ? 'update' : 'create'}}" class="space-y-4">
     @csrf
    {{-- Success Message --}}
     @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 mb-2 rounded relative" role="alert">
            {{ session('message') }}
        </div>
    @endif
       
       <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Center Name*</label>
                <input type="text" id="name" wire:model="name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" placeholder="Center Name">
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email*</label>
                <input type="email" id="email" wire:model="email" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" placeholder="Email">
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            
            <div>
                <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number*</label>
                <input type="text" id="phone_number" wire:model="phone_number" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" placeholder="Phone Number (10 Digit Only)  " maxlength="10" >
                @error('phone_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="proprietor_name" class="block text-sm font-medium text-gray-700">Proprietor Name*</label>
                <input type="text" id="proprietor_name" wire:model="proprietor_name" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" placeholder="Proprietor Name">
                @error('proprietor_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
           
            <div>
                <label for="address" class="block text-sm font-medium text-gray-700">Address*</label>
                <input type="text" id="address" wire:model="address" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="id_proof" class="block text-sm font-medium text-gray-700">ID Proof*</label>
                <input type="file" id="id_proof" wire:model="id_proof" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" accept=".pdf">
                @error('id_proof') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <label for="comment" class="block text-sm font-medium text-gray-700">Comment</label>
                <input type="text" id="comment" wire:model="comment" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                @error('comment') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>
        <div>
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-md shadow-md hover:bg-blue-700">{{$editMode ? 'Update':'Submit'}}</button>
        </div>
      </form>


      {{-- Centers List --}}
       <div class="mt-6 bg-green-400 rounded-md p-4">
         <input type="text" wire:model.live.debounce.500ms="search" placeholder="Search in...     Center code | Name | Phone Number | Status" class="px-4 py-2 border rounded mb-4 w-full">
    <h2 class="text-center font-bold text-lg mb-4">Centers List</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-md shadow-md">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border-b border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider">Center Code</th>
                    <th class="px-4 py-2 border-b border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider" colspan="2"> Center Name</th>
                    <th class="px-4 py-2 border-b border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider" colspan="2"> Person Name</th>
                    <th class="px-4 py-2 border-b border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider">Phone</th>
                    <th class="px-4 py-2 border-b border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider">Action</th>
                    <th class="px-4 py-2 border-b border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider">ID Proof</th>
                    <th class="px-4 py-2 border-b border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider">Address</th>
                    <th class="px-4 py-2 border-b border-gray-300 text-xs font-medium text-gray-600 uppercase tracking-wider">Email</th>
                </tr>
            </thead>
            <tbody>
               
                @foreach ($centers as $center)
                    <tr class=" border-b border-gray-200 text-center {{$center->user->status == 'inactive' ? 'bg-yellow-400' :'bg-white hover:bg-gray-200' }}">
                        <td class="px-4 py-3 whitespace-nowrap text-xl font-bold">{{ $center->center_code}}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-left" colspan="2">
                            {{ $center->user->name }} <br>
                           
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-left" colspan="2">
                            {{ $center->proprietor_name }} <br>
                           
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                           {{$center->user->phone_number}}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <a href="#" class="bg-slate-500 p-2 text-white rounded hover:bg-slate-600 transition duration-300">View</a>
                            <button wire:click="edit({{ $center }})" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition duration-300">Edit</button>
                            @if ($center->user->status == 'active')
                                <button wire:click="deactivate({{ $center->id }})" wire:confirm="Deactivate This  Center"class="bg-yellow-500 p-2 text-white rounded hover:bg-yellow-600 transition duration-300">Deactivate</button>
                            @else
                                <button wire:click="activate({{ $center->id }})" wire:confirm="Activate This Center" class="bg-white p-2 text-gray-700 rounded hover:bg-gray-400 transition duration-300">Activate</button>
                            @endif
                            {{-- <button wire:click="delete({{ $center->id }})" wire:confirm="Are you sure to delete this center permanently ?" class="bg-red-500 p-2 text-white rounded hover:bg-red-600 transition duration-300">Delete</button> --}}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                          <a href="{{ asset('storage/' . $center->id_proof) }}" target="_blank">View</a>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                           {{$center->address}}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                           
                           {{$center->user->email}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

    {{-- Pagination --}}
    <div class="my-3">
     {{ $centers->links() }} 
    </div>

</div>

