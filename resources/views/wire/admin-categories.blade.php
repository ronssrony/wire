<x-layout>
    @include('components.wire.dash-navbar')
    <div>
        <div class="flex justify-between">
            <h1 class="text-2xl font-bold tracking-wider">Category Dashboard</h1>
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
                <th>Category Name</th>
                <th>Description</th>
                <th>Actions</th>
            </x-slot>

            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->description }}</td>
                    <td>
                        <a href="{{ route('admin.categories.create', $category->id) }}" class="text-blue-500 hover:text-blue-700">Create</a> |
                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="text-yellow-500 hover:text-yellow-700">Edit</a> |
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </x-bladewind::table>
</x-layout>
