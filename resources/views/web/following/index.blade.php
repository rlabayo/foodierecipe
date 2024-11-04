<x-app-layout>
    @push('headerScript')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    @endpush
    <x-profile-information :profile="$profile" :userId="$user->id" :username="$user->name" :postCount="$total_post" :favoriteCount="$total_favorite" :totalFollowing="$total_following" :totalFollower="$total_follower" :isFollow="$is_follow" ></x-profile-information>
    
    <div class="min-h-[50vh] md:w-1/2 w-full h-auto mx-auto">
        <div class="flex flex-wrap justify-center mt-4">
            <!-- Display the profile details of the following-->
            @foreach($following_list as $item)
                <div class="flex w-full min-h-[100px] my-1 items-center justify-between space-x-4 gap-1 px-2">
                    <div class="w-2/3 items-center">
                        <img src="{{ Storage::url($item['image']) }}" alt="{{$item['name']}}" width="50" height="50" class="rounded-full"/>
                        <a href="{{ route('profile.show', $item['following_id']) }}" alt="Go to profile"><h5 class="font-semibold">{{$item['name']}}</h5></a>
                        <p>{{$item['email']}}</p>
                    </div>
                    <div class="w-1/3 ml-auto gap-1 flex flex-wrap text-center items-center">
                        <a href="{{ route('profile.show', $item['following_id']) }}" class="bg-[--primary] text-sm text-white py-1 px-2 rounded-full hover:ring-1 hover:ring-[--primary] hover:bg-white hover:text-[--primary] hover:font-semibold">
                            See Profile
                        </a>
                        <a href="{{ route('unfollow', $item['following_id']) }}" class="bg-[--primary] text-sm text-white py-1 px-2 rounded-full hover:ring-1 hover:ring-[--primary] hover:bg-white hover:text-[--primary] hover:font-semibold">
                            Unfollow
                        </a>
                    </div>
                </div>

            @endforeach
        </div>
    </div>

    @push('script')
        <script src="{{ Storage::url('assets/js/delete_confirmation.js') }}" defer></script>
    @endpush

</x-app-layout>