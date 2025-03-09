<x-layout>

 @include('components.wire.root-navbar')
  <div class="container mx-auto flex justify-center items-center relative ">

      <a href="{{ route('dashboard') }}" class="mt-[200px] overflow-hidden">
          <button id="hoverButton" class=" bg-black px-6 py-3 shadow-2xl rounded-full text-white font-semibold ">
              Read Blogs
          </button>

      </a>
  </div>
</x-layout>
