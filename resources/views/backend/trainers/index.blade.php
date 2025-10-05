<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Trainers List') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-between mb-4">
                <h1>All Trainers</h1>
                <a href="{{ route('trainers.create') }}"
                    class="bg-green-500 hover:bg-green-700 text-white px-4 py-2 rounded">
                    Create Trainer
                </a>
            </div>

            <table class="min-w-full border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2">#</th>
                        <th class="px-4 py-2">District</th>
                        @if (Auth::user()->hasRole('superadmin'))
                            <th>Created By</th>
                        @endif
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Phone</th>
                        <th class="px-4 py-2">Image</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($trainers as $key => $trainer)
                        <tr>
                            <td class="px-4 py-2">{{ $key + 1 }}</td>
                            <td class="px-4 py-2">{{ $trainer->district->name ?? 'N/A' }}</td>
                            @if (Auth::user()->hasRole('superadmin'))
                                <td>
                                    {{ $trainer->creator?->name ?? 'N/A' }}
                                </td>
                            @endif
                            <td class="px-4 py-2">{{ $trainer->name }}</td>
                            <td class="px-4 py-2">{{ $trainer->email }}</td>
                            <td class="px-4 py-2">{{ $trainer->phone }}</td>
                            <td class="px-4 py-2"><img src="{{ App\Helpers\ImageHelper::get($trainer->image) }}" alt="Trainer Image" class="w-16 h-16 object-cover rounded"></td>
                            <td class="px-4 py-2 space-x-2">
                                <a href="{{ route('trainers.edit', $trainer->id) }}"
                                    class="bg-blue-500 text-white px-3 py-1 rounded">Edit</a>
                                <form action="{{ route('trainers.destroy', $trainer->id) }}" method="POST"
                                    class="inline-block" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-500 text-white px-3 py-1 rounded">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-4 text-center text-gray-500">
                                No trainers found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
