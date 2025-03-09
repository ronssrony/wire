<x-layout>
 @include('components.wire.dash-navbar')

   <div>
       <div class="flex justify-between">
           <h1 class="text-2xl font-bold tracking-wider">Admin Dashboard</h1>
          <div class="flex gap-2">
              <a href="{{route('admin.users')}}">
                  <x-bladewind::button
                      size="small"
                      type="secondary"
                      icon="arrow-small-right"
                      icon_right="true"
                      color="cyan"
                  >

                      Users
                  </x-bladewind::button>
              </a>

              <a href="{{route('admin.categories')}}">
                  <x-bladewind::button
                      size="small"
                      type="secondary"
                      icon="arrow-small-right"
                      icon_right="true"
                      color="pink"
                  >
                      Categories
                  </x-bladewind::button>
              </a>
          </div>

       </div>
       <x-bladewind::table divider="thin">
           <x-slot name="header">
               <th>Title</th>
               <th>Content</th>
               <th>Image</th>
               <th>Created At</th>
               <th>Actions</th>
           </x-slot>


               @foreach ($posts as $post)

                   <tr>


                       <td>{{ $post->title }}</td>
                       <td>
                           <a href="{{ asset($post->content) }}" target="_blank">View Content</a>
                       </td>
                       <td>
                           <img src="{{ asset($post->image) }}" alt="Post Image" class="w-20 h-20 max-w-20 max-h-20 object-cover">
                       </td>
                       <td>{{ \Carbon\Carbon::parse($post->created_at)->format('d M Y H:i') }}</td>
                       <td>
                           <a href="{{ route('show.post', $post->id) }}" class="text-yellow-500 hover:text-yellow-700">view</a>|
                           <a href="{{ route('editPost', $post->id) }}" class="text-yellow-500 hover:text-yellow-700">Edit</a> |
                           <form action="{{ route('destroy.post', $post->id) }}" method="POST" style="display:inline;">
                               @csrf
                               @method('DELETE')
                               <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                           </form>
                       </td>
                   </tr>
               @endforeach

       </x-bladewind::table>

   </div>
</x-layout>
