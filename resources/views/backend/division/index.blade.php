<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Divisions List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Success Message -->
                    @if (session('success'))
                        <div class="mb-4 p-4 text-green-700 bg-green-100 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Permission Table -->
                    <div class="overflow-x-auto">
                        <div class="flex justify-between mb-4">
                            <h1>All Divisions</h1>
                            <a href="{{ route('divisions.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Create Division</a>
                        </div>
                        <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">#</th>
                                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Division Name</th>
                                    <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($divisions as $key => $division)
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-700">{{ $key + 1 }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-700">{{ $division->name }}</td>
                                    
                                        <td class="px-4 py-2 text-center space-x-2">
                                            <a href="{{ route('divisions.edit', $division->id) }}"
                                                class="px-3 py-1 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                                                Edit
                                            </a>
                                            <form action="{{ route('divisions.destroy', $division->id) }}"
                                                method="POST" class="inline-block"
                                                onsubmit="return confirm('Are you sure you want to delete this permission?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-3 py-1 bg-red-600 text-white rounded-md text-sm hover:bg-red-700">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-4 text-center text-gray-500">
                                            No Divisions found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
