{{-- filepath: resources/views/users/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit User</h2>
    </x-slot>

    <div class="p-6">
        <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label>Name</label>
                <input type="text" name="name" class="border rounded px-2 py-1 w-full" value="{{ $user->name }}" required>
            </div>
            <div>
                <label>Email</label>
                <input type="email" name="email" class="border rounded px-2 py-1 w-full" value="{{ $user->email }}" required>
            </div>
            <div>
                <label>Password (leave blank to keep current)</label>
                <input type="password" name="password" class="border rounded px-2 py-1 w-full">
            </div>
            <div>
                <label>Role</label>
                <select name="role_id" class="border rounded px-2 py-1 w-full" required>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" @if($user->role_id == $role->id) selected @endif>{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-black rounded">Update</button>
        </form>
    </div>
</x-app-layout>