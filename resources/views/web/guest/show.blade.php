<x-guest-layout>
    <div class="bg-[--primary]">
        @include('layouts.guest_navigation')
    </div>
    <div class="flex flex-col justify-between bg-fixed bg-cover resize-y md:bg-center bg-center bg-[#D99877]/30 px-4 md:h-[550px] h-[450px]" style="background-image: url('{{Storage::url($recipe->image)}}');">
        <div class="flex justify-between pt-4">
            <div class="flex justify-start space-x-1">
                    <a href="/">
                        <img src="{{ Storage::url('assets/images/Back.png') }}" alt="Back" width="30" height="30" />
                    </a>
                </div>
            </div>
            <div class="flex justify-center space-x-1">
                @if($recipe->video_url != '')
                    <a href="{{ $recipe->video_url }}" target="__blank" class="px-12 py-2 bg-[--primary] rounded shadow-lg text-white font-semibold mb-[-20px]">Watch Video</a>
                @endif
            </div>
        </div>
    </div>
    <div class="flex flex-wrap mx-auto rounded-md shadow-md">
        <div class="md:w-3/4 w-full bg-white">
            <x-show-recipe :recipe="$recipe"></x-show-recipe>
        </div>
        <div class="md:w-1/4 w-full md:px-4 text-[--secondary] md:bg-gradient-to-b bg-gradient-0 md:from-[#fff7f3] md:to-white ">
            <h2 class="md:text-2xl text-xl font-semibold md:mt-20 my-4 px-2 py-4 border-b-2 border-b-[--primary]">More like this</h2>
            <div class="mb-4">
                <ul class="space-y-2">
                    <!-- List some of suggested recipe -->
                    @foreach($recommendation_list as $recommendation)
                        <li class="px-2">
                            <a href="{{ route('guest.show', $recommendation->id) }}" alt="{{ $recommendation->title }}" class="text-md  hover:font-semibold">{{ $recommendation->title }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <x-list-comment class="max-w-7xl mr-auto md:w-2/3 w-full md:px-20 px-4 my-10" :comments="$comments" :totalComments="$total_comments" :recipeCreator="$recipe->user_id" ></x-list-comment>
</x-guest-layout>