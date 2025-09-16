<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Trainer') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('trainers.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block">Name</label>
                    <input type="text" name="name" class="w-full border p-2 rounded" required>
                </div>
                <div>
                    <label class="block">Email</label>
                    <input type="email" name="email" class="w-full border p-2 rounded">
                </div>
                <div>
                    <label class="block">Phone</label>
                    <input type="text" name="phone" class="w-full border p-2 rounded">
                </div>
                <button class="bg-green-500 text-white px-4 py-2 rounded">Save</button>
            </form>
        </div>
    </div>
</x-app-layout>
