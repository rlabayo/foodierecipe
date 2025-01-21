<x-app-layout>
    <div class="flex flex-wrap mx-auto rounded-md shadow-sm max-w-7xl">
        <!-- Display recipes-->
        <x-show-recipe :recipe="$recipe" :recommendations="$recommendation_list" :user="$user" ></x-show-recipe>
        <!-- Display recommendations after recipe section -->
        <div class="mx-auto w-full md:px-20 p-4 text-[--secondary] md:bg-gradient-to-b bg-gradient-0 md:from-[#fff7f3] md:to-white md:hidden block">
            <h2 class="md:text-2xl text-xl font-semibold md:mt-4 mb-4 px-2 py-4 border-b-2 border-b-[--primary]">More like this</h2>
            <x-recommendations :recommendations="$recommendation_list"></x-recommendations>
        </div>
    </div>
    <x-list-comment class="max-w-7xl mr-auto md:w-2/3 w-full md:px-20 px-4 my-10" :comments="$comments" :totalComments="$total_comments" :recipeCreator="$recipe->user_id" ></x-list-comment>
    <x-footer></x-footer>
</x-app-layout>