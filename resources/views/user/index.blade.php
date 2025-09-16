<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users List') }}
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
                            <h1>All Users</h1>
                            <a href="{{ route('users.create') }}"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Create
                                User</a>
                        </div>
                        <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">#</th>
                                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Name</th>
                                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Email</th>
                                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Role</th>
                                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">
                                        District/Division</th>
                                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Status</th>
                                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Created At</th>
                                    <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($users as $key => $user)
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-700">{{ $key + 1 }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-700">{{ $user->name }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-700">
                                            {{ $user->email }}
                                        </td>
                                        <td class="px-4 py-2 text-sm text-gray-700">
                                            @if ($user->roles->isNotEmpty())
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach ($user->roles as $role)
                                                        <span
                                                            class="px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-700">
                                                            {{ $role->name }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-gray-400 italic">No role assigned</span>
                                            @endif
                                        </td>

                                        <td class="px-4 py-2 text-sm text-gray-700">
                                            @if ($user->districts->isNotEmpty())
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach ($user->districts as $district)
                                                        <span
                                                            class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                                            {{ $district->name }}
                                                            @if ($district->division)
                                                                ({{ $district->division->name }})
                                                            @endif
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-gray-400 italic">No district assigned</span>
                                            @endif
                                        </td>

<td class="px-4 py-2">
    <button 
        class="status-btn px-2 py-1 rounded {{ $user->status ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}" 
        data-id="{{ $user->id }}">
        {{ $user->status ? 'Active' : 'Inactive' }}
    </button>
</td>





                                        <td class="px-4 py-2 text-sm text-gray-500">
                                            {{ $user->created_at->format('d M, Y') }}</td>
                                        <td class="px-4 py-2 text-center space-x-2">
                                            <a href="{{ route('users.edit', $user->id) }}"
                                                class="px-3 py-1 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">
                                                Edit
                                            </a>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                class="inline-block"
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
                                            No permissions found.
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





<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.querySelectorAll('.status-btn').forEach(button => {
    button.addEventListener('click', function() {
        let userId = this.dataset.id;
        let btn = this;

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to toggle the status?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'OK',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // AJAX request
                axios.post(`/users/${userId}/toggle-status`, {
                    _token: '{{ csrf_token() }}'
                })
                .then(response => {
                    let isActive = response.data.status == 1;

                    // Update button text
                    btn.textContent = isActive ? 'Active' : 'Inactive';

                    // Update button classes
                    btn.classList.toggle('bg-green-100', isActive);
                    btn.classList.toggle('text-green-700', isActive);
                    btn.classList.toggle('bg-red-100', !isActive);
                    btn.classList.toggle('text-red-700', !isActive);

                    // SweetAlert feedback
                    Swal.fire({
                        position: 'center',
                        icon: isActive ? 'success' : 'warning',
                        title: response.data.message,
                        showConfirmButton: false,
                        timer: 1200
                    });
                })
                .catch(error => {
                    console.error(error);
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Status update failed!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                });
            } 
            // else cancelled, do nothing
        });
    });
});
</script>
