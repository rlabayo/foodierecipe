<div class="mx-auto pt-10 pb-2 px-4">
    <div class="flex md:flex-row flex-col justify-center items-center md:w-1/2 w-full mx-auto">
        <div class="md:w-1/3 w-full">
            @if($profile->image != 'default_profile.svg')
                <x-profile-image src="{{Storage::url('')}}{{$profile->image}}" alt="{{ $username }}" width="120" height="120" class="md:ml-auto mx-auto" ></x-profile-image>
            @else
                <x-profile-image src="{{Storage::url('assets/images/')}}{{$profile->image}}" alt="{{ $username }}" width="120" height="120" class="md:ml-auto mx-auto" ></x-profile-image>
            @endif
        </div>
        <div class="flex flex-col mr-auto lg:w-2/3 w-full">
            <div class="flex md:justify-start justify-center md:mt-0 mt-4 gap-2">
                <h1 class="text-[--secondary] md:text-1xl text-xl font-semibold">{{ $username }}</h1>
                <div class="group flex relative mb-auto">
                    @if((auth()->user()->id == $profile->user_id))
                        <a href="{{ route('profile.edit') }}" class="px-2 py-1" tooltip="Edit Profile" >
                            <img src="{{ Storage::url('assets/images/icons/edit.svg') }}" alt="Edit Profile" class="fill-white">
                        </a>
                    @else 
                        @if($isFollow <= 0)
                            <a href="{{ route('follow', Crypt::encrypt($profile->user_id)) }}" class="bg-[--primary] text-sm text-white py-1 px-2 rounded-2xl hover:ring-1 hover:ring-[--primary] hover:bg-white hover:text-[--primary] hover:font-semibold">
                                Follow
                            </a>
                        @else
                            <a href="{{ route('unfollow', Crypt::encrypt($profile->user_id)) }}" class="bg-[--primary] text-sm text-white py-1 px-2 rounded-2xl hover:ring-1 hover:ring-[--primary] hover:bg-white hover:text-[--primary] hover:font-semibold">
                                Unfollow
                            </a>
                        @endif
                    @endif
                </div>
            </div>
            <p class="md:text-start text-center text-wrap md:text-md text-sm text-[--secondary]">{{ $profile->description }}</p>
            <div class="flex flex-wrap md:justify-start justify-center gap-4 mt-4 w-full mx-auto">
                @php
                    $favorite_classes = request()->routeIs('favorite.index') ? 'font-bold' : '';
                    $post_classes = request()->routeIs('profile.index') ? 'font-bold' : '';
                    $followers_classes = request()->routeIs('follower') ? 'font-bold' : '';
                    $following_classes = request()->routeIs('following') ? 'font-bold' : '';
                @endphp
                <div class="flex flex-col text-center ">
                    <p class="font-bold md:text-md text-sm">{{ $postCount }}</p>
                    <a href="{{ route('profile.index', Crypt::encrypt($userId)) }}" class="md:text-md text-sm text-[--secondary] cursor-pointer {{$post_classes}}">posts</a>
                </div>
                <div class="flex flex-col text-center ">
                    <p class="font-bold  md:text-md text-sm">{{ $favoriteCount }}</p>
                    <a href="{{ route('favorite.index', Crypt::encrypt($userId)) }}" alt="Favorites" class="md:text-md text-sm text-[--secondary] {{$favorite_classes}}">favorites</a>
                </div>
                <div class="flex flex-col text-center ">
                    <p class="font-bold md:text-md text-sm">{{ $totalFollower }}</p>
                    <a href="{{ route('follower', Crypt::encrypt($userId)) }}" alt="Follower" class="md:text-md text-sm text-[--secondary] cursor-pointer {{$followers_classes}}">followers</a>
                </div>
                <div class="flex flex-col text-center ">
                    <p class="font-bold  md:text-md text-sm">{{ $totalFollowing }}</p>
                    <a href="{{ route('following', Crypt::encrypt($userId)) }}" alt="Following" class="md:text-md text-sm text-[--secondary] {{$following_classes}}">following</a>
                </div>
            </div>
            <div class="mt-4 md:mx-0 mx-auto">
                @if(auth()->user()->id == $profile->user_id)
                    @if((auth()->user()->admin_verified == 1))
                        <a href="{{ route('recipe.create') }}">
                            <x-primary-button >{{ __('Create Recipe') }}</x-primary-button>
                        </a>
                        <a href="{{ route('drafts') }}">
                            <x-secondary-button >{{ __('Drafts') }}</x-secondary-button>
                        </a>
                    @endif
                @endif
            </div>
        </div>
    </div>
    
    <div class="border-b-2 border-b-w-1/2 border-b-[--primary] my-4 mx-auto"></div>
</div>