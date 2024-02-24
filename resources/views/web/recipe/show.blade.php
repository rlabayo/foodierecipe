<x-app-layout>
    {{ isset($message) }}
    <x-show-recipe-banner :recipe="$recipe"></x-show-recipe-banner>
    <div class="flex flex-wrap mx-auto rounded-md shadow-md">
        <div class="md:w-3/4 w-full bg-white">
            <x-show-recipe :recipe="$recipe"></x-show-recipe>
        </div>
        <div class="md:w-1/4 w-full md:px-4 text-[--secondary] md:bg-gradient-to-b bg-gradient-0 md:from-[#fff7f3] md:to-white">
            <h2 class="md:text-2xl text-xl font-semibold md:mt-20 my-4 px-2 py-4 border-b-2 border-b-[--primary]">More like this</h2>
            <div class="mb-4">
                <ul class="space-y-2">
                    <!-- List some of suggested recipe -->
                    @foreach($recommendation_list as $recommendation)
                        <li class="px-2">
                            <a href="{{ route('recipe.show', $recommendation->id) }}" alt="{{ $recommendation->title }}" class="text-md  hover:font-semibold">{{ $recommendation->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
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