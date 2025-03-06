
<nav class="flex w-full justify-between items-center mb-10 ">
    <a href="{{route('dashboard')}}" class=" text-4xl font-extrabold  text-black tracking-[5px] " >WIRE</a>

    <ul class="flex gap-3 items-center ">
        @if(Auth::user()->role==='admin'||Auth::user()->role==='author')
            <a href="{{route('createPost')}}" class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm  leading-normal">Write</a>
        @endif

        <x-bladewind::bell show_dot="false" />
         @if(Auth::user()->role==='admin')
            <a href="{{route('admin.dashboard')}}" class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm  leading-normal">Dashboard </a>
        @endif
        <nav class="flex items-center justify-end gap-4">
            @include('layouts.navigation')
        </nav>
    </ul>
</nav>

