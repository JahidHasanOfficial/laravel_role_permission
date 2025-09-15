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

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" name="password" id="password" value="{{ old('password') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                @error('password') border-red-500 @enderror"
                                placeholder="Enter Password">
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm
                                Password</label>
                            <input type="password" name="confirm_password" id="password_confirmation" value="{{ old('password') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm
                focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50
                @error('confirm_password') border-red-500 @enderror"
                                placeholder="Enter Password">
                            @error('confirm_password')
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
<!-- Division Select -->
<select name="division_id" id="division" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
    <option value="">Select Division</option>
    @foreach($divisions as $division)
        <option value="{{ $division->id }}" {{ $division->id == $selectedDivisionId ? 'selected' : '' }}>
            {{ $division->name }}
        </option>
    @endforeach
</select>

<!-- District Checkboxes -->
<div id="district-checkboxes">
    @if($selectedDivisionId)
        @foreach(\App\Models\District::where('division_id', $selectedDivisionId)->get() as $district)
            <div class="flex items-center space-x-2">
                <input type="checkbox" name="district_id[]" id="district-{{ $district->id }}" value="{{ $district->id }}"
                    {{ in_array($district->id, $hasDistricts) ? 'checked' : '' }}>
                <label for="district-{{ $district->id }}">{{ $district->name }}</label>
            </div>
        @endforeach
    @endif
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$('#division').on('change', function() {
    var division_id = $(this).val();
    if(division_id){
        $.get('/districts-by-division/'+division_id, function(data){
            $('#district-checkboxes').html(data); // HTML replace
        });
    } else {
        $('#district-checkboxes').html('');
    }
});
</script>




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
