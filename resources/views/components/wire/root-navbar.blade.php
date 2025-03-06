
    <nav class="flex w-full justify-between items-center">
        <h1 class=" text-4xl font-extrabold  text-black tracking-[5px] " >WIRE</h1>
        <ul class="flex gap-3 items-center ">
            <a href="{{route('login')}}">Write</a>

                <nav class="flex items-center justify-end gap-4">
                        <a
                            href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                        >
                            Log in
                        </a>


                            <a
                                href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                Register
                            </a>


                </nav>
        </ul>
    </nav>

