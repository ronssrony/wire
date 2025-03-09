
<x-layout>
    @if(auth()->check())
        @include('components.wire.dash-navbar')
    @else
        @include('components.wire.root-navbar')
    @endif

    <div class="flex  flex-col gap-4 justify-center items-center  w-full relative ">
        <div x-data="{ scroll: $refs.category.scrollLeft }" class=" sticky top-0 backdrop-blur-md z-20 bg-white/50  dark:bg-[#1b1b18] ">
            <div x-ref="category" class="max-w-[800px] overflow-hidden scrollbar-hide h-10 w-full border-b border-t border-gray-200 flex items-center gap-1 px-3 whitespace-nowrap scroll-smooth">

                @foreach($categories as $category)
                    <a href="{{route('postsByCategory', $category->id)}}" class="px-4 py-2  text-gray-700 {{$currentCategory===$category->id?'text-gray-900 font-semibold border-b-2 py-2 border-gray-800':'text-gray-700'}} ">{{ $category->name }}</a>
                @endforeach
            </div>

            <!-- Scroll Buttons -->
            <button @click="$refs.category.scrollBy({ left: -200, behavior: 'smooth' })" class="absolute -left-0 top-1/2 transform bg-white/60 -translate-y-1/2  px-2 py-1">←</button>
            <button @click="$refs.category.scrollBy({ left: 200, behavior: 'smooth' })" class="absolute -right-0 top-1/2 transform bg-white/60 -translate-y-1/2  px-2 py-1">→</button>
        </div>
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
                    @include('components.wire.reactions')
                    <div class="w-full border mt-1 border-gray-200"></div>
                </div>

            </div>
        @endforeach
    </div>

    </div>
</x-layout>
