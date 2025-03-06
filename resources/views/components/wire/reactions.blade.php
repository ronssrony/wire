<div x-data="{ open: false }" x-cloak class="reactions flex gap-2 flex-col gap-2 w-full">
    <div class="flex gap-4 items-center text-sm">
        <a class="flex gap-1 items-center text-sm text-black/60" href="{{ route('like', $post->id) }}">
            @if($post->liked)
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M4 21h1V8H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2zM20 8h-7l1.122-3.368A2 2 0 0 0 12.225 2H12L7 7.438V21h11l3.912-8.596L22 12v-2a2 2 0 0 0-2-2z" fill="currentColor"/></svg>
            @else
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M20 8h-5.612l1.123-3.367c.202-.608.1-1.282-.275-1.802S14.253 2 13.612 2H12c-.297 0-.578.132-.769.36L6.531 8H4c-1.103 0-2 .897-2 2v9c0 1.103.897 2 2 2h13.307a2.01 2.01 0 0 0 1.873-1.298l2.757-7.351A1 1 0 0 0 22 12v-2c0-1.103-.897-2-2-2M4 10h2v9H4zm16 1.819L17.307 19H8V9.362L12.468 4h1.146l-1.562 4.683A.998.998 0 0 0 13 10h7z"/>
                </svg>
            @endif
            {{$post->likes_count}}
        </a>
        <button @click="open = !open" class=" rounded-full flex gap-1 items-center text-black text-sm text-black/60 font-semibold"> <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 20"><path d="M20 2H4c-1.103 0-2 .897-2 2v18l4-4h14c1.103 0 2-.897 2-2V4c0-1.103-.897-2-2-2z" fill="currentColor"/></svg> {{$post->comments->count()}} </button>
        <div title="views" class="views text-black/60 flex gap-1 items-center text-sm font-semibold cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 22"><path fill="currentColor" d="M6.85 15q.775 0 1.388-.45t.862-1.175l.375-1.15q.4-1.2-.2-2.212T7.55 9H4.025l.475 3.925q.125.875.788 1.475t1.562.6m10.3 0q.9 0 1.563-.6t.787-1.475L19.975 9h-3.5q-1.125 0-1.725 1.025t-.2 2.225l.35 1.125q.25.725.863 1.175t1.387.45m-10.3 2q-1.65 0-2.887-1.088t-1.438-2.737L2 9H1V7h6.55q1.1 0 2.013.538T11 9h2.025q.525-.925 1.438-1.463T16.475 7H23v2h-1l-.525 4.175q-.2 1.65-1.437 2.738T17.15 17q-1.425 0-2.562-.812T13 14.025l-.375-1.125q-.05-.175-.1-.363t-.1-.537h-.85q-.05.3-.1.488t-.1.362L11 14q-.45 1.35-1.587 2.175T6.85 17"/></svg>
            {{$post->views->count()}}
        </div>
    </div>
    <div
        x-show="open"
        @click.outside="open = false"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="w-full mt-4"
    >

        <div class="shadow-inner flex flex-col gap-1 ">
            @if($post->comments->count()===0)
                <h1>No Comments</h1>
            @endif
            @foreach($post->comments as $comments)
                <div class="flex flex-col gap-1 ">
                  <div class="flex gap-2 items-center ">
                      <h1 class="h-7 w-7 rounded-full  bg-gray-400"></h1>
                      <h1 class="font-semibold "> {{$comments->user->name}}</h1>

                  </div>

                    <h1 class="pl-9">{{ $comments->body }}</h1>
                </div>
            @endforeach
        </div>

    </div>
</div>
