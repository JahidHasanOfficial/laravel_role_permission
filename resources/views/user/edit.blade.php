<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User / Update') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h3 class="text-lg font-bold mb-6">Update User</h3>

                    <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- User Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">User
                                Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                @error('name') border-red-500 @enderror"
                                placeholder="Enter permission name">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- User Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">User
                                Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                @error('email') border-red-500 @enderror"
                                placeholder="Enter permission name">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Role -->
                        <div class="grid grid-cols-4 gap-4">
                            @if ($roles->isNotEmpty())
                                @foreach ($roles as $role)
                                    <div class="flex items-center space-x-2">
                                        <input type="checkbox" name="role[]" id="role-{{ $role->id }}"
                                            value="{{ $role->name }}"
                                            {{ $hasRoles->contains($role->id) ? 'checked' : '' }}
                                            class="mr-2">
                                        <label for="role-{{ $role->id }}" class="text-gray-700">
                                            {{ $role->name }}
                                        </label>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-gray-500 col-span-4">No permissions available.</p>
                            @endif
                        </div>



                        <!-- Submit Button -->
                        <div>
                            <button type="submit"
                                class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1">
                                Submit
                            </button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
