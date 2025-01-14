<x-app-layout>
    <div class="min-h-[85vh] mx-auto max-w-6xl">
        <div class="py-4 px-4">
            <p class="text-[--secondary] text-sm my-4">About {{$total_profile_items}} {{$total_profile_items > 1 ? 'results' : 'result'}} for <span class="italic font-semibold">{{$param}}</span></p>
            <hr class="my-4 font-semibold">
                @if($profile_items->count() > 0)
                    <h1 class="text-[--secondary] text-2xl font-semibold">Profiles</h1>
                    <div>
                        @foreach($profile_items as $item)
                            <div class="flex w-full min-h-[100px] my-1 items-center justify-between space-x-4">
                                <div class="flex flex-row justify-between w-full">
                                    <div class="md:flex-row flex-col flex gap-4 w-1/2">
                                        <div class="md:w-1/3 w-auto my-auto">
                                            <img src="{{ Storage::url($item->profile_image) }}" alt="{{$item->name}}" width="50" height="50" class="rounded-full md:mx-auto mx-0"/>
                                        </div>
                                        <div class="md:w-2/3 w-auto">
                                            <a href="{{ route('profile.show', Crypt::encrypt($item->profile_id)) }}" alt="Go to profile"><h5 class="font-semibold">{{$item->name}}</h5></a>
                                            <!-- <p>{{$item['email']}}</p> -->
                                            <p class="italic text-sm">{{$item->description}}</p>
                                        </div>
                                    </div>
                                    <div class="my-auto md:mx-auto mx-2">
                                        <a href="{{ route('profile.show', Crypt::encrypt($item->profile_id)) }}" class="bg-[--primary] text-sm text-white py-1 px-2 w-full rounded-full hover:ring-1 hover:ring-[--primary] hover:bg-white hover:text-[--primary] hover:font-semibold">
                                            See Profile
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="my-4">
                        {{$profile_items->links()}}
                    </div>
                @else
                    <p class=" text-sm">Your search did not match any recipe or profile.</p>
                @endif
        </div>
    </div>
</x-app-layout>
