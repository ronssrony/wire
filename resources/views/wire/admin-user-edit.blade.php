<x-layout>
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                   class="mt-1 p-2 block w-full border rounded-md shadow-sm focus:ring focus:ring-blue-300">
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                   class="mt-1 p-2 block w-full border rounded-md shadow-sm focus:ring focus:ring-blue-300">
        </div>

        <div class="mb-4">
            <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
            <select id="role" name="role" class="mt-1 p-2 block w-full border rounded-md shadow-sm focus:ring focus:ring-blue-300">
                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                <option value="author" {{ $user->role === 'author' ? 'selected' : '' }}>Author</option>
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-700">Update</button>
    </form>

</x-layout>
