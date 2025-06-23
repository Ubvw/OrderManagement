<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create User</h2>
    </x-slot>

    <div class="p-6">
        <form action="{{ route('users.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label>Name</label>
                <input type="text" name="name" class="border rounded px-2 py-1 w-full" required>
            </div>
            <div>
                <label>Email</label>
                <input type="email" name="email" class="border rounded px-2 py-1 w-full" required>
            </div>
            <div>
                <label>Password</label>
                <input type="password" name="password" class="border rounded px-2 py-1 w-full" required>
            </div>
            <div>
                <label>Role</label>
                <select name="role_id" class="border rounded px-2 py-1 w-full" required>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-black rounded">Create</button>
        </form>
    </div>
</x-app-layout>