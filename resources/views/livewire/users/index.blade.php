<div class="space-y-6 font-inter mt-8">

    {{-- Flash Messages --}}
    @if (session()->has('message'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-2xl shadow-soft animate-in slide-in-from-top-2 duration-300" role="alert">
            <div class="flex items-center">
                <div class="bg-green-100 rounded-full p-1 mr-3">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span class="font-bold">{{ session('message') }}</span>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-2xl shadow-soft animate-in slide-in-from-top-2 duration-300" role="alert">
            <div class="flex items-center">
                <div class="bg-red-100 rounded-full p-1 mr-3">
                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span class="font-bold">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    {{-- Clean Header Section --}}
    <div class="flex justify-between items-center">
        <div class="space-y-3">
            <h1 class="text-5xl font-black text-gray-800 tracking-tight">Users</h1>
            <p class="text-gray-600 text-base font-medium">Manage system users and their roles</p>
        </div>
        <div class="flex items-center space-x-3">
            <button wire:click="create" 
                class="px-8 py-3 bg-gradient-to-r from-primary to-primary-dark text-white rounded-2xl hover:shadow-lg hover:shadow-primary/25 transition-all duration-300 font-bold tracking-wide uppercase text-sm shadow-soft">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add User
            </button>
        </div>
    </div>

    {{-- Clean Search and Filters --}}
    <div class="bg-white rounded-2xl p-6 shadow-soft border border-gray-200">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Search Bar --}}
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input type="text" wire:model.live.debounce.300ms="search" 
                       class="w-full pl-12 pr-4 py-3 bg-gray-50 border border-gray-300 rounded-2xl text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all duration-300 font-medium" 
                       placeholder="Search users by name or email...">
            </div>

            {{-- Role Filter --}}
            <div>
                <select wire:model.live="roleFilter" 
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-2xl text-gray-800 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all duration-300 font-medium">
                    <option value="" class="bg-white">All Roles</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" class="bg-white">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- Clean Users Table --}}
    <div class="bg-white rounded-2xl shadow-soft border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-200 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">User</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-600">#{{ $user->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-primary to-primary-dark rounded-2xl flex items-center justify-center shadow-soft mr-4">
                                        <span class="text-white text-sm font-black">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                    </div>
                                    <div>
                                        <div class="text-sm font-bold text-gray-800">{{ $user->name }}</div>
                                        @if($user->id === auth()->id())
                                            <div class="text-xs text-primary font-semibold">Current User</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold 
                                    @if($user->role->name === 'Admin') bg-red-100 text-red-700 border border-red-200
                                    @elseif($user->role->name === 'Cashier') bg-blue-100 text-blue-700 border border-blue-200
                                    @elseif($user->role->name === 'Food Processor') bg-yellow-100 text-yellow-700 border border-yellow-200
                                    @else bg-gray-100 text-gray-700 border border-gray-200 @endif">
                                    {{ $user->role->name ?? 'No Role' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-3">
                                    <button wire:click="edit({{ $user->id }})" 
                                            class="p-2 text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-all duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    @if($user->id !== auth()->id())
                                        <button wire:click="delete({{ $user->id }})" 
                                                onclick="return confirm('Are you sure you want to delete this user?')"
                                                class="p-2 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-all duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center text-gray-500">
                                    <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mb-4">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-lg font-bold text-gray-700 mb-1">No users found</p>
                                    <p class="text-sm font-medium text-gray-500">Try adjusting your search or filters</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Clean Pagination Card --}}
    @if($users->hasPages())
        <div class="bg-white rounded-2xl p-6 shadow-soft border border-gray-200">
            {{ $users->links() }}
        </div>
    @endif

    {{-- Clean Create/Edit Modal --}}
    @if($showCreateModal || $showEditModal)
        <div class="fixed inset-0 flex items-center justify-center z-50 bg-black/50 backdrop-blur-sm">
            <div class="bg-white rounded-2xl shadow-soft-2xl w-[600px] max-h-[90vh] overflow-y-auto border border-gray-200">
                {{-- Modal Header --}}
                <div class="bg-gray-50 rounded-t-2xl border-b border-gray-200 p-8">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-3xl font-black text-gray-800 tracking-tight">
                                {{ $selectedUser ? 'Edit User' : 'Add User' }}
                            </h2>
                            <p class="text-sm text-gray-600 mt-2 font-semibold">
                                {{ $selectedUser ? 'Update user information' : 'Create a new user account' }}
                            </p>
                        </div>
                        <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600 transition-colors duration-300 hover:scale-110">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Modal Body --}}
                <div class="p-8 bg-white">
                    <form wire:submit.prevent="save" class="space-y-6">
                        {{-- Name --}}
                        <div class="space-y-3">
                            <label class="block text-gray-700 font-bold text-sm uppercase tracking-wide">Name</label>
                            <input type="text" wire:model="name" class="w-full bg-gray-50 border border-gray-300 rounded-2xl px-4 py-3 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all duration-300 font-medium" placeholder="Enter full name">
                            @error('name') <span class="text-red-500 text-sm font-semibold">{{ $message }}</span> @enderror
                        </div>

                        {{-- Email --}}
                        <div class="space-y-3">
                            <label class="block text-gray-700 font-bold text-sm uppercase tracking-wide">Email</label>
                            <input type="email" wire:model="email" class="w-full bg-gray-50 border border-gray-300 rounded-2xl px-4 py-3 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all duration-300 font-medium" placeholder="Enter email address">
                            @error('email') <span class="text-red-500 text-sm font-semibold">{{ $message }}</span> @enderror
                        </div>

                        {{-- Password --}}
                        <div class="space-y-3">
                            <label class="block text-gray-700 font-bold text-sm uppercase tracking-wide">
                                Password {{ $selectedUser ? '(leave blank to keep current)' : '' }}
                            </label>
                            <input type="password" wire:model="password" class="w-full bg-gray-50 border border-gray-300 rounded-2xl px-4 py-3 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all duration-300 font-medium" placeholder="{{ $selectedUser ? 'Enter new password' : 'Enter password' }}">
                            @error('password') <span class="text-red-500 text-sm font-semibold">{{ $message }}</span> @enderror
                        </div>

                        {{-- Role --}}
                        <div class="space-y-3">
                            <label class="block text-gray-700 font-bold text-sm uppercase tracking-wide">Role</label>
                            <select wire:model="role_id" class="w-full bg-gray-50 border border-gray-300 rounded-2xl px-4 py-3 text-gray-800 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all duration-300 font-medium">
                                <option value="" class="bg-white">Select Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" class="bg-white">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('role_id') <span class="text-red-500 text-sm font-semibold">{{ $message }}</span> @enderror
                        </div>

                        {{-- Form Actions --}}
                        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                            <button type="button" wire:click="closeModal" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-2xl hover:bg-gray-200 hover:text-gray-800 transition-all duration-300 font-bold tracking-wide">
                                Cancel
                            </button>
                            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-primary to-primary-dark text-white rounded-2xl hover:shadow-lg hover:shadow-primary/25 transition-all duration-300 font-bold tracking-wide uppercase">
                                {{ $selectedUser ? 'Update User' : 'Create User' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
