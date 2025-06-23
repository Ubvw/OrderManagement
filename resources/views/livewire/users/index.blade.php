{{-- filepath: resources/views/livewire/users/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Users</h2>
    </x-slot>

    <div class="p-6">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('users.create') }}" class="px-4 py-2 bg-blue-600 text-black rounded mb-4 inline-block">Create User</a>

        <table class="w-full border mt-4">
            <thead>
                <tr>
                    <th class="border px-2 py-1">ID</th>
                    <th class="border px-2 py-1">Name</th>
                    <th class="border px-2 py-1">Email</th>
                    <th class="border px-2 py-1">Role</th>
                    <th class="border px-2 py-1">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td class="border px-2 py-1">{{ $user->id }}</td>
                    <td class="border px-2 py-1">{{ $user->name }}</td>
                    <td class="border px-2 py-1">{{ $user->email }}</td>
                    <td class="border px-2 py-1">{{ $user->role->name ?? '' }}</td>
                    <td class="border px-2 py-1">
                        <a href="{{ route('users.edit', $user) }}" class="text-blue-600">Edit</a>
                        <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 ml-2" onclick="return confirm('Delete user?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>