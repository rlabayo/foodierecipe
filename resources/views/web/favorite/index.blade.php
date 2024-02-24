<x-app-layout>
    <x-profile-information :profile="$profile" :userId="$user->id" :username="$user->name" :postCount="$total_post" :favoriteCount="$total_favorite" :totalFollowing="$total_following" :totalFollower="$total_follower" ></x-profile-information>
    <div class="min-h-[50vh] h-auto mx-auto pb-4 px-4">
        <div class="flex flex-wrap justify-start mt-4 px-1">
            @foreach($items as $item)
                <div class="bg-cover flex flex-col rounded-xl w-full md:max-w-[33%] max-w-[48%] md:h-[300px] min-h-[200px] items-center shadow-md bg-blend-overlay md:py-2 py-4 bg-center md:m-[1px] m-[.5px]" style="background-image: url('{{ Storage::url($item->thumbnail)}}')">
                    <div class="w-full flex justify-around items-center h-[20%]">
                        <div class=" mt-4 mr-auto ml-2 ">
                            <a href="{{ route('profile.show', $item->user_id) }}" alt="{{ $item->user_id }}">
                                @if($item->profile_image != 'default_profile.svg')
                                    <img src="{{Storage::url('')}}{{$item->profile_image}}" alt="{{ $item->profile_image }}" class="rounded-full md:h-[50px] h-[30px] md:w-[50px] w-[30px]"  />
                                @else
                                    <img src="{{Storage::url('assets/images/')}}{{$item->profile_image}}" alt="{{ $item->profile_image }}"  class="rounded-full md:h-[50px] h-[30px] md:w-[50px] w-[30px]"  />
                                @endif
                            </a>
                        </div>
                        <div class="flex justify-between gap-1 ml-auto mr-2 mt-4">
                            <div>
                                <a href="{{ route('recipe.show', $item->id) }}" class="block">
                                    <x-view-logo></x-view-logo>
                                </a>
                            </div>
                            <div>
                                <a href="{{ route('favorite.remove', $item->favorite_id) }}" class="block">
                                    <x-remove-logo></x-remove-logo>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center text-center cursor-pointer min-h-[70%] md:px-4 px-1 md:py-4 py-1 w-full">
                        <a href="{{ route('recipe.show', $item->id) }}" alt="{{ $item->title }}" class="w-full">
                            <h1 class="text-white md:text-lg text-sm font-[600] leading-4 bg-[#D99877]/50 px-4 py-1 rounded-sm">
                            {{ $item->title }} 
                            </h1>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>