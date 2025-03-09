
<x-layout>
    @if(auth()->check())
        @include('components.wire.dash-navbar')
    @else
        @include('components.wire.root-navbar')
    @endif

    <div class="flex  flex-col gap-4 justify-center items-center  w-full relative ">

        <div class="flex  flex-col gap-12 justify-center items-center  w-full relative ">
            @foreach($posts as $post )

                <div class="w-full md:w-1/2 max-w-[800px]   ">
                    <div class="flex gap-2 text-black/90 items-center">
                        <x-bladewind::avatar
                            label="{{ strtoupper(substr($post->user->name, 0)) }}"
                            size="small" />
                        <h1 class=" font-semibold mt-1">
                            {{$post->user->name}}
                        </h1>
                    </div>
                    <div class="flex justify-between items-center  ">
                        <div class="flex gap-2 w-1/2 flex-wrap">
                            @foreach($post->categories as $category)

                                <h1 class="text-sm">{{$category->name}}</h1>
                            @endforeach
                        </div>
                        <div title="Authors" class="flex cursor-pointer w-1/2 mb-2 flex-wrap justify-end">
                            @foreach($post->authors as $author)
                                <x-bladewind::avatar
                                    label="{{ strtoupper(substr($author->name, 0)) }}"
                                    class="ring-green-100 ring-offset-1  "
                                    size="tiny" />
                            @endforeach
                        </div>
                    </div>
                    <div class="post  min-w-full  flex flex-col  justify-between  items-start mt-4 ">

                        <div class="flex gap-4 justify-between items-start">
                            <a href="{{route('show.post',$post->id)}}">

                                <h1 class="text-2xl font-bold ">{{$post->title}}</h1>
                                <p class="truncate  text-wrap max-w-full py-2 text-black/70 ">
                                    {{ Str::limit($post->description, 100, '...') }}
                                </p>
                            </a>
                            <a  href="{{route('show.post',$post->id)}}" class="w-52 h-32 relative">
                                <img src="{{ asset('storage/' . $post->image) }}" class="rounded-md w-full h-full min-w-40 object-cover
                  " alt="Uploaded Image">
                            </a>
                        </div>
                        <div class="flex w-full justify-between mt-1 w-full">
                            @include('components.wire.reactions')
                            <div class="flex gap-2">
                                <a href="{{route('editPost',$post->id)}}">
                                    <x-bladewind::button outline="true" color="yellow" size="tiny">Edit</x-bladewind::button>
                                </a>
                                <form action="{{ route('destroy.post', $post->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <x-bladewind::button size="tiny" class="text-white"  type="submit" color="red">Delete</x-bladewind::button>

                                </form>

                            </div>
                        </div>
                        <div class="w-full border mt-1 border-gray-200"></div>
                    </div>

                </div>
            @endforeach
        </div>

    </div>
</x-layout>
