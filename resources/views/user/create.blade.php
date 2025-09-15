<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User / Create') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Success / Error Messages -->
                    @if(session('success'))
                        <div class="mb-4 p-4 text-green-700 bg-green-100 rounded-md">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="mb-4 p-4 text-red-700 bg-red-100 rounded-md">
                            <ul class="list-disc pl-5">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- User Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">User Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                                focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                                @error('name') border-red-500 @enderror"
                                placeholder="Enter User Name">
                        </div>

                        <!-- User Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">User Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                                focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                                @error('email') border-red-500 @enderror"
                                placeholder="Enter User Email">
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" name="password" id="password"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                                focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                                @error('password') border-red-500 @enderror"
                                placeholder="Enter Password">
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                            <input type="password" name="confirm_password" id="password_confirmation"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                                focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                placeholder="Confirm Password">
                        </div>

                        <!-- Roles -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Roles</label>
                            <div class="grid grid-cols-4 gap-4">
                                @if ($roles->isNotEmpty())
                                    @foreach ($roles as $role)
                                        <div class="flex items-center space-x-2">
                                            <input type="checkbox" name="role[]" id="role-{{ $role->id }}"
                                                value="{{ $role->name }}" class="mr-2">
                                            <label for="role-{{ $role->id }}" class="text-gray-700">{{ $role->name }}</label>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-gray-500 col-span-4">No roles available.</p>
                                @endif
                            </div>
                        </div>

                        <!-- Division -->
                        <div>
                            <label for="division" class="block text-sm font-medium text-gray-700">Division</label>
                            <select name="division_id" id="division"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="">Select Division</option>
                                @foreach($divisions as $division)
                                    <option value="{{ $division->id }}">{{ $division->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Districts -->
                        <div>
                            <label for="district" class="block text-sm font-medium text-gray-700">Districts</label>
                            <select name="district_id[]" id="district" multiple

                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <!-- districts will load via Ajax -->
                            </select>
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

    <!-- Ajax Script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#division').on('change', function() {
            var division_id = $(this).val();
            if(division_id){
                $.get('/districts-by-division/'+division_id, function(data){
                    $('#district').html(data);
                });
            } else {
                $('#district').html('');
            }
        });
    </script>
</x-app-layout>
