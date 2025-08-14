    <div>
        <section class="mt-8">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <!-- Card Container -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <!-- Card Header -->
                    <div class="px-6 py-5 border-b border-gray-200 bg-white">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-800">User Management</h2>
                                <p class="mt-1 text-sm text-gray-600">Manage user roles and permissions</p>
                            </div>
                            <div class="mt-3 sm:mt-0 flex items-center space-x-3">
                                <!-- Search Input -->
                                <div class="relative w-64">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input
                                        wire:model.live.debounce.300ms="search"
                                        type="text"
                                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                        placeholder="Search users...">
                                </div>

                                <!-- Role Filter -->
                                <div class="flex items-center">
                                    <select
                                        wire:model.live="roleFilter"
                                        class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                        <option value="">All Roles</option>
                                        <option value="admin">Admin</option>
                                        <option value="author">Author</option>
                                        <option value="user">User</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    @include('livewire.includes.table-sortable-th', [
                                        'name' => 'name',
                                        'displayName' => 'User'
                                    ])
                                    @include('livewire.includes.table-sortable-th', [
                                        'name' => 'email',
                                        'displayName' => 'Email'
                                    ])
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Role
                                    </th>
                                    @include('livewire.includes.table-sortable-th', [
                                        'name' => 'created_at',
                                        'displayName' => 'Joined'
                                    ])
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($users as $user)
                                <tr wire:key="{{ $user->id }}" class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 font-medium">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <select
                                            x-data
                                            x-init="currentRole = '{{ $user->getRoleNames()->first() ?? 'user' }}'"
                                            x-model="currentRole"
                                            x-on:change="
                                                const selectedRole = $event.target.value;
                                                Swal.fire({
                                                    title: 'Change User Role?',
                                                    text: `Change role for {{ $user->name }} to ${selectedRole}?`,
                                                    icon: 'question',
                                                    showCancelButton: true,
                                                    confirmButtonColor: '#3085d6',
                                                    cancelButtonColor: '#d33',
                                                    confirmButtonText: 'Yes, change it!',
                                                    cancelButtonText: 'Cancel',
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        $wire.updateUserRole({{ $user->id }}, selectedRole)
                                                            .then(() => {
                                                                Swal.fire({
                                                                    title: 'Updated!',
                                                                    text: 'User role has been updated.',
                                                                    icon: 'success',
                                                                    timer: 1500,
                                                                    showConfirmButton: false
                                                                });
                                                            });
                                                    } else {
                                                        $event.target.value = currentRole;
                                                    }
                                                });
                                            "
                                            class="block w-full pl-3 pr-8 py-1 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
                                        >
                                            @foreach(['user', 'author', 'admin'] as $role)
                                                <option value="{{ $role }}" {{ $user->hasRole($role) ? 'selected' : '' }}>
                                                    {{ ucfirst($role) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->created_at->format('M j, Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button
                                            x-data
                                            x-on:click="
                                                Swal.fire({
                                                    title: 'Delete User?',
                                                    text: 'Are you sure you want to delete {{ $user->name }}?',
                                                    icon: 'warning',
                                                    showCancelButton: true,
                                                    confirmButtonColor: '#3085d6',
                                                    cancelButtonColor: '#d33',
                                                    confirmButtonText: 'Yes, delete it!'
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        $wire.deleteUser({{ $user->id }})
                                                            .then(() => {
                                                                Swal.fire(
                                                                    'Deleted!',
                                                                    'User has been deleted.',
                                                                    'success'
                                                                );
                                                            });
                                                    }
                                                });
                                            "
                                            class="text-red-600 hover:text-red-900"
                                        >
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination and Per Page -->
                    <div class="px-6 py-4 bg-white border-t border-gray-200 flex items-center justify-between">
                        <div class="flex-1 flex justify-between sm:hidden">
                            {{ $users->links() }}
                        </div>
                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div class="flex items-center space-x-4">
                                <p class="text-sm text-gray-700">
                                    Showing
                                    <span class="font-medium">{{ $users->firstItem() }}</span>
                                    to
                                    <span class="font-medium">{{ $users->lastItem() }}</span>
                                    of
                                    <span class="font-medium">{{ $users->total() }}</span>
                                    results
                                </p>
                                <select
                                    wire:model.live="perPage"
                                    class="block w-20 pl-3 pr-8 py-1 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                            <div>
                                {{ $users->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            // Success notifications
            Livewire.on('notify', (event) => {
                Swal.fire({
                    title: event.title,
                    text: event.message,
                    icon: event.type,
                    timer: 2000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-right'
                });
            });

            // Error notifications
            Livewire.on('error', (event) => {
                Swal.fire({
                    title: 'Error',
                    text: event.message,
                    icon: 'error',
                    timer: 3000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-right'
                });
            });
        });
    </script>
    @endpush
