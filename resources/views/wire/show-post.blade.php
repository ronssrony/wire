<x-layout>
     <style>
         img{

         img{
             padding: 20%  20%;
         }
         }
        .content h3{
             font-size: 30px;
         }
        .content h2{
            font-size: 35px;
        }
        .content h1{
            text-align: center;
             font-size: 45px;
         }
     </style>
    <div>
        @include('components.wire.dash-navbar')
    </div>
    <div class="flex flex-col items-center">

        <div class="md:max-w-[800px] md:min-w-[800px] flex flex-col gap-4  ">
            <div class="post mb-10">
                <h1 class="text-5xl font-bold ">{{$post->title}}</h1>
                <div class="flex gap-2 text-black/90 items-center my-2">
                    <x-bladewind::avatar
                        label="{{ strtoupper(substr($post->user->name, 0)) }}"
                        size="small" />
                    <h1 class=" font-semibold mt-1">
                        {{$post->user->name}}
                    </h1>
                </div>
                <div>
                    <h1 class="text-black/70 text-sm font-semibold my-1">{{ $post->created_at->diffForHumans() }}</h1>

                </div>

                <div class="flex justify-between items-center mt-1">
                    <div class="flex gap-2 w-1/2 flex-wrap">
                        @foreach($post->categories as $category)
                            <h1 class="text-sm font-semibold">{{$category->name}}</h1>
                        @endforeach
                    </div>
                    <div class="flex gap-2 w-1/2 flex-wrap justify-end">
                        @foreach($post->authors as $author)
                            <h1 class="text-sm font-semibold">{{$author->name}}</h1>
                        @endforeach
                    </div>
                </div>
                <div class="reactions h-10 border-t border-b border-gray-300/80 mt-1 flex gap-4 items-center">
                    <a href="{{ route('like', $post->id) }}">
                        <button class=" py-1 {{$post->liked?'text-red-700':'text-black'}} text-sm rounded-full text-black font-semibold"> Like {{$post->likes_count}} </button>
                    </a>
                    <div  class="flex gap-1 text-sm text-semibold cursor-pointer ">
                        <h1>Comments</h1>
                        <h1>{{$post->comments->count()}}</h1>
                    </div>
                    <div class="flex gap-1 text-sm text-semibold cursor-pointer ">
                        <h1>Views</h1>
                        {{$post->views->count()}}
                    </div>
                </div>
            </div>
            <div class="content flex flex-col gap-3 " >
                {!! $post->content_text  !!}
            </div>

            <form action="{{ route('store.comment') }}" method="post" class="bg-white p-2 rounded-md shadow-md w-full">
                @csrf
                <input type="hidden" name="post_id" value="{{ $post->id }}">

                <div class="mb-4 relative">
                    <x-bladewind::textarea name="comment" label="Comment"  class="focus:border-gray-200" />
                    <div class="">
                        <button type="submit" class="bg-gray-600 text-white px-3 py-1 rounded-lg hover:bg-gray-700 focus:outline-none transition duration-300">Comment</button>
                    </div>
                </div>
            </form>


            <div class="mb-10 flex flex-col gap-1 px-2 ">
                @foreach($post->comments as $comments)
                    <div class="flex flex-col gap-1 ">
                        <div class="flex gap-2 text-black/90 items-center">
                            <x-bladewind::avatar
                                label="{{ strtoupper(substr($comments->user->name, 0)) }}"
                                size="small" />
                            <h1 class=" font-semibold mt-1">
                                {{$comments->user->name}}
                            </h1>
                        </div>

                        <h1 class="pl-9">{{ $comments->body }}</h1>
                    </div>
                @endforeach
            </div>
        </div>


    </div>




</x-layout>

