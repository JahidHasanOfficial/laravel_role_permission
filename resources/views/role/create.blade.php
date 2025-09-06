<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Role / Permissions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h3 class="text-lg font-bold mb-6">Add New Permission</h3>

                    <form action="{{ route('role.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Permission Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Permission
                                Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                @error('name') border-red-500 @enderror"
                                placeholder="Enter permission name">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-4">
                            @if($permissions->isNotEmpty())
                                @foreach($permissions as $permission)
                                    <div class="flex items-center">
                                        <input type="checkbox" name="permission[]" id="permissions" value="{{ $permission->id }}" class="mr-2">
                                        <label for="permission" class="text-gray-700">{{ $permission->name }}</label>
                                    </div>
                                @endforeach
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
