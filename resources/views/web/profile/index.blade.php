<x-app-layout>
    @push('headerScript')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    @endpush
    <x-profile-information :profile="$profile" :userId="$user->id" :username="$user->name" :postCount="$total_post" :favoriteCount="$total_favorite" :totalFollowing="$total_following" :totalFollower="$total_follower" :isFollow="$is_follow"></x-profile-information>
    
    <div class="min-h-[50vh] h-auto mx-auto pb-4 md:px-4 px-0">
        <div class="flex flex-wrap justify-start mt-4">
            @foreach($recipes as $recipe)
                <x-card-recipe class="bg-cover flex flex-col md:max-w-[33%] w-[49.8%] md:h-[300px] h-[200px] mx-auto items-center shadow-md bg-blend-overlay md:py-2 py-4 bg-center md:m-[1px] m-[.5px]" style="background-image: url('{{ Storage::url($recipe->thumbnail)}}');" :item="$recipe"></x-card-recipe>
            @endforeach
        </div>
    </div>

    @if(session('status') === 200)
        @include('web.recipe.components.success', ['status'=> 200, 'message' => 'Recipe deleted successfully!', 'routeName' => 'profile.index', 'buttonLabel' => 'Back to Recipe'])
    @elseif(session('status') === 400)
        @include('web.recipe.components.error', ['status'=> 200, 'message' => 'Unfortunately we have an issue while deleting your new recipe. Please try again!'])
    @endif

    @push('script')
        <script src="{{ Storage::url('assets/js/delete_confirmation.js') }}" defer></script>
    @endpush
</x-app-layout>