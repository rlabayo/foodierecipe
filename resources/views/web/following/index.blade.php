<x-app-layout>
    @push('headerScript')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    @endpush
    
    <x-profile-information :profile="$profile" :userId="$user->id" :username="$user->name" :postCount="$total_post" :favoriteCount="$total_favorite" :totalFollowing="$total_following" :totalFollower="$total_follower" ></x-profile-information>
    
    <div class="min-h-[50vh] md:w-1/2 w-full h-auto mx-auto pb-4 px-4">
        <div class="flex flex-wrap justify-center mt-4 px-1">
            <!-- Display the profile details of the following-->
            @foreach($following as $item)
                <div class="flex w-full min-h-[100px] my-1 items-center justify-around space-x-4">
                    <div class="flex gap-4">
                        <div>
                            <img src="{{ Storage::url($item['image']) }}" alt="{{$item['name']}}" width="50" height="50" class="rounded-full"/>
                        </div>
                        <div>
                            <a href="{{ route('profile.show', $item['following_id']) }}" alt="Go to profile"><h5 class="font-semibold">{{$item['name']}}</h5></a>
                            <p>{{$item['email']}}</p>
                            <p class="italic text-sm">{{$item['description']}}</p>
                        </div>
                    </div>
                    <div class="ml-auto">
                        <a href="{{ route('profile.show', $item['following_id']) }}" class="bg-[--primary] text-sm text-white py-1 px-2 rounded-2xl hover:ring-1 hover:ring-[--primary] hover:bg-white hover:text-[--primary] hover:font-semibold">Visit Profile</a>
                    </div>
                </div>

            @endforeach
        </div>
    </div>

    @push('script')
        <script src="{{ Storage::url('assets/js/delete_confirmation.js') }}" defer></script>
    @endpush

</x-app-layout>