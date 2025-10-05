<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Permissions / Update') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h3 class="text-lg font-bold mb-6">Add New Permission</h3>

                  <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')


                        <!--  Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Posts
                                Name</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                @error('title') border-red-500 @enderror"
                                placeholder="Enter Post Title">
                            @error('title')r
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!--  Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Posts
                                Description</label>
                            <input type="text" name="description" id="description" value="{{ old('description', $post->description) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                @error('description') border-red-500 @enderror"
                                placeholder="Enter Post Description">
                            @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!--  author -->
                        <div>
                            <label for="author" class="block text-sm font-medium text-gray-700">Posts
                                Author</label>
                            <input type="text" name="author" id="author" value="{{ old('author', $post->author) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                @error('author') border-red-500 @enderror"
                                placeholder="Enter Post Author">
                            @error('author')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                         <div>
                    <label class="block">Image</label>
                    <input type="file" name="image" class="w-full border p-2 rounded">
                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Trainer Image" class="mt-2 h-20 w-20 object-cover">
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
