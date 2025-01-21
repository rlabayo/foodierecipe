<x-app-layout>
    <div class="min-h-[85vh] mx-auto max-w-6xl ">
        <div class="py-4 px-4">
            <p class="text-[--secondary] text-sm my-4">About {{($profile_items->count() + $items->count())}} {{($profile_items->count() + $items->count()) > 1 ? 'results' : 'result'}} for <span class="italic font-semibold">{{$param}}</span></p>
            <hr class="my-4 font-semibold">
            @if($items->count() > 0 || $profile_items->count() > 0)
                @if($profile_items->count() > 0)
                    @foreach($profile_items as $key => $item)
                        @if($key < 3)
                            <div class="flex w-full min-h-[100px] my-1 items-center justify-between space-x-4">
                                <div class="flex flex-row justify-between w-full">
                                    <div class="md:flex-row flex-col flex gap-4 w-1/2">
                                        <div class="md:w-1/3 w-auto my-auto">
                                            <x-profile-image src="{{Storage::url($item->profile_image)}}" alt="{{ $item->name }}" width="50" height="50" class="md:mx-auto mx-0" ></x-profile-image>
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
                        @else
                            @php break; @endphp
                        @endif
                    @endforeach
                    @if($profile_items->count() > 6)
                        <div class="w-full my-4 text-center">
                            <a href="{{ route('search.profiles', $param) }}" alt="Show More" class="px-3 py-2 font-semibold rounded-md bg-[--primary] text-white hover:bg-white hover:border-2 hover:border-[--primary] hover:text-[--primary]">Show More</a>
                        </div>
                    @endif
                    <hr class="my-4 font-semibold">
                @endif
                <h1 class="text-[--secondary] text-2xl font-semibold">Recipes</h1>
                <div class="flex mt-4 flex-wrap justify-start px-1">
                    @foreach($items as $key => $item)
                        @if($key < 6)
                        <x-card-recipe class="flex flex-col bg-cover rounded-xl md:w-[33%] w-full md:h-[240px] min-h-[300px] items-center shadow-md bg-blend-overlay md:pt-2 pt-4 bg-center m-[1px]" style="background-image: url('{{ Storage::url($item->thumbnail)}}');" :item="$item" ></x-card-recipe>
                        @else
                            @php break; @endphp
                        @endif
                    @endforeach
                    @if($items->count() == 0)
                        <p class=" text-sm">Your search did not match any recipe.</p>
                    @endif
                </div>
                @if($items->count() > 6)
                    <div class="w-full my-4 text-center">
                        <a href="{{ route('search.recipes', $param) }}" alt="Show More" class="px-3 py-2 font-semibold rounded-md bg-[--primary] text-white hover:bg-white hover:border-2 hover:border-[--primary] hover:text-[--primary]">Show More</a>
                    </div>
                @endif
            @else
                <p class=" text-sm">Your search did not match any recipe or profile.</p>
            @endif
        </div>
    </div>
</x-app-layout>