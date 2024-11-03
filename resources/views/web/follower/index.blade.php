<x-app-layout>
    @push('headerScript')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    @endpush
    <x-profile-information :profile="$profile" :userId="$user->id" :username="$user->name" :postCount="$total_post" :favoriteCount="$total_favorite" :totalFollowing="$total_following" :totalFollower="$total_follower" :isFollow="$is_follow"></x-profile-information>
    
    <div class="min-h-[50vh] md:w-1/2 w-full h-auto mx-auto">
        <div class="flex flex-wrap justify-center mt-4">
            <!-- Display the profile details of the followers-->
            @foreach($followers as $item)
                <div class="flex w-full min-h-[100px] my-1 items-center justify-between space-x-4 gap-1 px-2">
                    <div class="flex gap-4">
                        <div>
                            <img src="{{ Storage::url($item['image']) }}" alt="{{$item['name']}}" width="50" height="50" class="rounded-full"/>
                        </div>
                        <div>
                            <a href="{{ route('profile.show', $item['follower_id']) }}" alt="Go to profile"><h5 class="font-semibold">{{$item['name']}}</h5></a>
                            <p>{{$item['email']}}</p>
                            <p class="italic text-sm">{{$item['description']}}</p>
                        </div>
                    </div>
                    <div class="ml-auto">
                        @if($user->id == auth()->user()->id)
                            <a href="{{ route('removeFollower', $item->follower_id) }}" class="bg-[--primary] text-sm text-white py-1 px-2 rounded-2xl hover:ring-1 hover:ring-[--primary] hover:bg-white hover:text-[--primary] hover:font-semibold">Remove</a>
                        @endif  
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @push('script')
        <script src="{{ Storage::url('assets/js/delete_confirmation.js') }}" defer></script>
    @endpush

</x-app-layout>