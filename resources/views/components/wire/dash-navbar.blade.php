
<nav class="flex w-full justify-between items-center mb-5">
    <script>
        function RequestWritingPermission() {
            fetch("{{ route('request.permission') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({})
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Your request has been sent successfully!");
                    } else {
                        alert("Failed to send request. Please try again.");
                    }
                })
                .catch(error => console.error("Error:", error));
        }
    </script>


    <a href="{{route('dashboard')}}" class=" text-4xl font-extrabold  text-black tracking-[5px] " >WIRE</a>

    <ul class="flex gap-3 items-center ">
        @if(Auth::check() && Auth::user()->role==='admin'||Auth::check() && Auth::user()->role==='author')
            <a href="{{route('createPost')}}" class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm  leading-normal">Write</a>
        @endif
            @if(Auth::check() && Auth::user()->role === 'user')
                <x-bladewind::button outline="true" class="border-black border-1 hover:border-gray-500 !py-2 text-black text-md font-inter" onclick="showModal('stretched')">
                    Write
                </x-bladewind::button>

                @if(Auth::user()->permission?->status === 'pending')
                    <x-bladewind::modal
                        size="big"
                        title="Already Requested"
                        name="stretched"
                        show_action_buttons="false"
                        >
                        <p>You have already requested to write. Please wait for your request to be approved.</p>


                    </x-bladewind::modal>
                @else
                    <x-bladewind::modal
                        size="big"
                        title="Request Writing Permission"
                        ok_button_label="Send Request"
                        ok_button_action="RequestWritingPermission()"
                        name="stretched">
                        If your request is accepted, you will become an author and gain the ability to write and publish posts.
                    </x-bladewind::modal>
                @endif
            @endif

         <a href="{{route('notifications')}}" class="">
             <x-bladewind::bell show_dot="false" />
         </a>
         @if(Auth::check() && Auth::user()->role==='admin')
            <a href="{{route('admin.dashboard')}}" class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm  leading-normal">Dashboard </a>
        @endif
        <nav class="flex items-center justify-end gap-4">
            @auth
                @include('layouts.navigation')
            @endauth
        </nav>
    </ul>
</nav>

