<x-layout>
    @include('components.wire.dash-navbar')
    <div>
        <div class="flex justify-between">
            <h1 class="text-2xl font-bold tracking-wider">Admin Dashboard</h1>
            <a href="{{route('admin.dashboard')}}">
                <x-bladewind::button
                    size="small"
                    type="secondary"
                    icon="arrow-small-right"
                    icon_right="true">
                    Posts
                </x-bladewind::button>
            </a>

        </div>
    <x-bladewind::table divider="thin">
        <x-slot name="header">
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Created At</th>
            <th>Actions</th>
        </x-slot>

        @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                <span class="px-3 py-1 rounded-lg text-white
                    {{ $user->role === 'admin' ? 'bg-red-500' : 'bg-blue-500' }}">
                    {{ ucfirst($user->role) }}
                </span>
                </td>
                <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d M Y H:i') }}</td>
                <td>
                   {{-- <a href="{{ route('show.user', $user->id) }}" class="text-yellow-500 hover:text-yellow-700">View</a> |--}}
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="text-yellow-500 hover:text-yellow-700">Edit</a> |
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </x-bladewind::table>


</x-layout>
