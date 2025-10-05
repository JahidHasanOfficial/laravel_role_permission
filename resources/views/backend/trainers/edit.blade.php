<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Trainer') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('trainers.update', $trainer->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block">Name</label>
                    <input type="text" name="name" value="{{ $trainer->name }}" class="w-full border p-2 rounded" required>
                </div>
                <div>
                    <label class="block">Email</label>
                    <input type="email" name="email" value="{{ $trainer->email }}" class="w-full border p-2 rounded">
                </div>
                <div>
                    <label class="block">Phone</label>
                    <input type="text" name="phone" value="{{ $trainer->phone }}" class="w-full border p-2 rounded">
                </div>
                <div>
                    <label class="block">Image</label>
                    <input type="file" name="image" class="w-full border p-2 rounded">
                    @if($trainer->image)
                        <img src="{{ asset('storage/' . $trainer->image) }}" alt="Trainer Image" class="mt-2 h-20 w-20 object-cover">
                    @endif  
                </div>
                <button class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
            </form>
        </div>
    </div>
</x-app-layout>
