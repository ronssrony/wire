<x-layout>
    @include('components.wire.dash-navbar')

    <div class="max-w-4xl mx-auto mt-6">
        <h1 class="text-2xl font-bold tracking-wider">Edit Category</h1>

        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="mt-6">
            @csrf
            @method('PUT') <!-- This indicates that we're updating the resource -->

            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Category Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Category Description</label>
                    <textarea id="description" name="description" rows="4" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" required>{{ old('description', $category->description) }}</textarea>
                    @error('description')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex items-center justify-end space-x-4">
                    <a href="{{ route('admin.categories') }}" class="text-gray-600 hover:text-gray-800">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-black text-white rounded-md ">Update Category</button>
                </div>
            </div>
        </form>
    </div>
</x-layout>
