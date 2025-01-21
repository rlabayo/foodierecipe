<x-app-layout>
    <x-profile-information :profile="$profile" :userId="$user->id" :username="$user->name" :postCount="$total_post" :favoriteCount="$total_favorite" :totalFollowing="$total_following" :totalFollower="$total_follower" :isFollow="$is_follow"></x-profile-information>
    <div class="min-h-[50vh] h-auto mx-auto pb-4 md:px-4 px-0">
        <div class="flex flex-wrap justify-start mt-4">
            @foreach($items as $item)
                <div class="bg-cover flex flex-col rounded-sm md:max-w-[33%] w-[49.8%] md:h-[300px] h-[200px] items-center shadow-md bg-blend-overlay md:py-2 py-4 bg-center md:m-[1px] m-[.5px] mx-auto bg-[#faf7f526]/10 hover:bg-[#faf7f526]/30 hover:text-gray-800 hover:font-bold " style="background-image: url('{{ Storage::url($item->thumbnail)}}')">
                    <div class="w-full flex justify-around items-center h-[20%]">
                        <div class=" mt-4 mr-auto ml-2 ">
                            <a href="{{ route('profile.show', Crypt::encrypt($item->user_id)) }}" alt="{{ $item->user_id }}">
                                @if($item->profile_image != 'default_profile.svg')
                                    <x-profile-image src="{{Storage::url('')}}{{$item->profile_image}}" alt="{{ $item->profile_image }}" width="50" height="50" class="md:h-[50px] h-[30px] md:w-[50px] w-[30px]" ></x-profile-image>
                                @else
                                    <x-profile-image src="{{Storage::url('assets/images/')}}{{$item->profile_image}}" alt="{{ $item->profile_image }}" width="50" height="50" class="md:h-[50px] h-[30px] md:w-[50px] w-[30px]" ></x-profile-image>
                                @endif
                            </a>
                        </div>
                        <div class="flex justify-between ml-auto mr-2 mt-2 items-center">
                            <div>
                                <a href="{{ route('recipe.show', Crypt::encrypt($item->id)) }}" class="block">
                                    <x-view-logo></x-view-logo>
                                </a>
                            </div>
                            <div>
                                @if($user->id == auth()->user()->id)
                                    <a href="{{ route('favorite.remove', Crypt::encrypt($item->favorite_id)) }}" class="block">
                                        <x-unfavorite></x-unfavorite>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('recipe.show', Crypt::encrypt($item->id)) }}" alt="{{ $item->title }}" class="w-full md:mt-auto my-auto text-center items-center text-wrap">
                        <h1 class="text-white md:text-3xl text-lg leading-auto min-h-20 px-4 py-3 rounded-sm font-semibold hover:text-gray-800 hover:font-bold">
                        {{ $item->title }} 
                        </h1>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>