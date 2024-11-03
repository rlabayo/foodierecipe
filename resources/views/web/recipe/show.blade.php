<x-app-layout>
    {{ isset($message) }}
    <div class="flex flex-wrap mx-auto rounded-md shadow-sm max-w-7xl">
        <!-- Display recipes-->
        <x-show-recipe :recipe="$recipe" :recommendations="$recommendation_list" ></x-show-recipe>
        <!-- Display recommendations after recipe section -->
        <div class="mx-auto w-full md:px-20 p-4 text-[--secondary] md:bg-gradient-to-b bg-gradient-0 md:from-[#fff7f3] md:to-white md:hidden block">
            <h2 class="md:text-2xl text-xl font-semibold md:mt-4 mb-4 px-2 py-4 border-b-2 border-b-[--primary]">More like this</h2>
            <x-recommendations :recommendations="$recommendation_list"></x-recommendations>
        </div>
    </div>
    <x-list-comment class="max-w-7xl mr-auto md:w-2/3 w-full md:px-20 px-4 mt-10 " :comments="$comments" :totalComments="$total_comments" :recipeCreator="$recipe->user_id" ></x-list-comment>
    <x-create-comment class="max-w-7xl mr-auto md:w-2/3 w-full md:px-20 px-4 mt-10" :recipeId="$recipe->id"></x-create-comment>
    <!-- Add comments section -->

    @if(session('commentStatus') === 200)
        @include('web.recipe.components.success', ['status'=> 201, 'message' => 'You successfully updated a comment to this recipe.', 'routeName' => 'recipe.show', 'recipeId' => $recipe->id, 'buttonLabel' => 'Back to Recipe'])
    @elseif(session('commentStatus') === 400)
        @include('web.recipe.components.error', ['status'=> 400, 'message' => 'Unfortunately we have an issue while updating your comment. Please try again!'])
    @endif
</x-app-layout>