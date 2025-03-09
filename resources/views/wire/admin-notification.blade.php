<x-layout>
    @include('components.wire.dash-navbar')
    <div class="container  px-6 py-2 justify-center flex flex-col items-center  ">
        <div class="md:max-w-[800px]  ">
            <h2 class="mb-4 text-3xl font-semibold">Notifications</h2>
            <div class="list-group flex flex-col gap-4">
                <x-bladewind::card size="big" compact="true">
                @foreach($notifications as $notification)

                        <div class="list-group-item mb-2 flex flex-col justify-content-between align-items-center">
                            <div class="flex gap-2 text-black/90 items-center">
                                <x-bladewind::avatar
                                    label="{{ strtoupper(substr($notification->user->name, 0)) }}"
                                    size="small" />
                                <h1 class=" mt-1">
                                    <strong> {{$notification->user->name}}</strong> has requested permission to write.

                                </h1>
                            </div>

                            <div class=" flex gap-4  justify-end ">

                                @if($notification->status == 'approved')
                                    <x-bladewind::button color="green" disabled="true" class="text-white font-semibold" size="tiny">Accepted</x-bladewind::button>
                                    @elseif($notification->status == 'rejected')
                                    <x-bladewind::button color="red" disabled="true" class="text-white font-semibold"  size="tiny">Rejected</x-bladewind::button>
                                    @else
                                    <div class="flex gap-2 justify-end">
                                        <a href="{{ route('permission.reject', $notification->id) }}"  class="d-inline">

                                            <x-bladewind::button color="red" class="text-white font-semibold" type="submit" size="tiny">Reject</x-bladewind::button>
                                        </a>
                                        <a href="{{ route('permission.accept', $notification->id) }}"  class="d-inline">


                                            <x-bladewind::button color="green" class="text-white font-semibold" type="submit" size="tiny">Accept</x-bladewind::button>

                                        </a>
                                    </div>
                            </div>
                                @endif

                        </div>


                @endforeach
                </x-bladewind::card>
            </div>
        </div>
    </div>
</x-layout>
