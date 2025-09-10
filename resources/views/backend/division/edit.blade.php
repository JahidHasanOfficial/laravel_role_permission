<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Divisions / Update') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h3 class="text-lg font-bold mb-6">Add New Division</h3>

                 <form action="{{ route('divisions.update', $division->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!--  Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Division
                                Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $division->name) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                @error('name') border-red-500 @enderror"
                                placeholder="Enter Division Name">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
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
