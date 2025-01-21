@props(["user"])

@push('headerScript')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
@endpush
<div class="md:w-3/4 w-full bg-white">
    <div class="flex flex-row justify-around items-center w-full">
        <div class="w-full my-10 ml-6">
            @if(parse_url(URL::current(), PHP_URL_PATH) != session('customPrevURL'))
                @if(session('customPrevURL') != "")
                    <a href="{{session('customPrevURL')}}" alt="Back to list" class="flex items-center justify-center py-1 px-1 font-bold lg:w-2/6 md:w-3/6 w-full rounded-full border-solid border-2 border-[--primary] text-[--primary] hover:border-4"><img src="{{ Storage::url('/assets/images/icons/back.svg') }}" alt="Back to list" /><span class="ml-2">Back to list</span></a>
                @endif
            @else
                <a href="/" alt="Back to list button" class="flex items-center justify-center py-1 px-1 font-bold lg:w-2/6 md:w-3/6 w-full rounded-full border-solid border-2 border-[--primary] text-[--primary] hover:border-4"><img src="{{ Storage::url('/assets/images/icons/back.svg') }}" alt="Back to list" /><span class="ml-2">Back to list</span></a>
            @endif
        </div>
        <div class="w-full flex">
            @auth
                @if($recipe->is_favorite == '1' && $recipe->user_id != auth()->user()->id)
                    <div class="ml-auto">
                        <a href="{{ route('favorite.remove', Crypt::encrypt($recipe->favorite_id)) }}"  alt="Remove favorite button" class="flex items-center justify-end font-bold mr-6">  
                            <x-unfavorite></x-unfavorite>
                        </a>
                    </div>
                    
                @elseif($recipe->is_favorite == '0' && $recipe->user_id != auth()->user()->id)
                    <div class="ml-auto">
                        <a href="{{ route('favorite.add', Crypt::encrypt($recipe->id)) }}"  alt="Add favorite button" class="flex items-center justify-end font-bold mr-6">
                            <x-favorite></x-favorite>
                        </a>
                    </div>
                @endif

                @if($recipe->user_id == auth()->user()->id)
                    <div class="flex ml-auto items-center">
                        <div class="ml-auto">
                            <a href="{{ route('recipe.edit', Crypt::encrypt($recipe->id)) }}"  alt="Edit button" class="flex items-center justify-end font-bold mr-2 border-2 rounded-full border-[--primary] hover:border-4">
                                <x-edit-logo></x-edit-logo>
                            </a>
                        </div>
                        <div class="mr-auto">
                            <form action="{{ route('recipe.delete', Crypt::encrypt($recipe->id)) }}" method="POST" class="delete_form">
                                @csrf
                                @method('delete')
                                <x-trash-icon type="submit" class="block mr-6 border-2 rounded-full border-[--primary] hover:border-4" ></x-trash-icon>
                            </form>
                        </div>
                    </div>
                @endif
            @endauth
        </div>
    </div>
    <div class="flex flex-col w-full mt-10 md:px-10 px-4 text-[--secondary] mb-10">
            
        <h1 class="text-[--text-secondary] md:text-[48px] text-[40px] text-center font-semibold md:leading-normal leading-[3rem]">
            {{ $recipe->title }}
        </h1>
        <div class="flex md:flex-row flex-col gap-1 my-4 justify-center">
            <p class="text-[--text-secondary] text-sm font-[350] md:leading-normal leading-[1.2rem]">By: <a href="{{ route('profile.show', Crypt::encrypt($user->id)) }}" class="font-semibold hover:text-[--primary]">{{$user->name}} &nbsp;</a></p>
            <p class="text-[--text-secondary] text-sm font-[350] md:leading-normal leading-[1.2rem]">Posted: {{ Carbon\Carbon::parse($recipe->created_at)->format('F d, Y') }} &nbsp; Updated: {{ Carbon\Carbon::parse($recipe->updated_at)->format('F d, Y') }}</p>
        </div>
        <p class="text-[--text-secondary] text-md text-justify font-[400] md:leading-normal leading-[1.2rem]">
            {{ $recipe->summary }}
        </p>
        <div class="flex w-full md:min-h-[550px] min-h-[300px] rounded-lg mt-6 bg-cover bg-center" style="background-image: url({{Storage::url($recipe->image)}})">
            @if($recipe->video_url != '')
                <a href="{{ $recipe->video_url }}" rel="noreferrer" target="__blank" class="w-0 h-0 
                border-t-[50px] border-t-transparent
                border-l-[75px] border-l-[#ffaf8781] hover:border-l-[--primary]
                border-b-[50px] border-b-transparent
                mx-auto my-auto"></a>
            @endif
        </div>
        
        <!-- Display list of ingredients -->
        <div class="mt-4 md:hidden block">
            <h2 class="md:text-2xl text-xl font-semibold">Ingredients:</h2>
            <ul class="px-4 mx-4 list-disc">
                @foreach(json_decode($recipe->ingredients,true) as $ingredient)
                    <!-- <li class="before:content-['']"> -->
                    <li>
                        {{ $ingredient['item'] }}
                    </li>
                @endforeach
            </ul type="disc">
        </div>
        <div class="mt-10">
            <h2 class="md:text-2xl text-xl font-semibold">Directions:</h2>
            <ol class="mx-4 list-decimal space-y-4" id="customlist">
                @php $key = 1; @endphp
                @foreach(json_decode($recipe->instruction,true) as $instruction)
                    <li>
                        <p>
                            @php
                                if($instruction['instruction_item'] != ''){
                                    echo '<span class="text-md font-bold">'. $key .'.</span>';
                                    $key++;
                                }
                            @endphp
                            {{ $instruction['instruction_item'] }}
                        </p>

                        @if($instruction['attached_photo'] != '')
                            <img src="{{ Storage::url($instruction['attached_photo']) }}" alt="Instruction photo" class="w-[300px] mx-auto rounded-md shadow-md my-4">
                        @endif
                    </li>
                @endforeach
            </ol>
        </div>
    </div>
</div>
<div class="md:w-1/4 w-full md:pt-20 pt-0 md:px-4 text-[--secondary] md:bg-gradient-to-b bg-gradient-0 md:from-[#fff7f3] md:to-white md:block hidden">
    <!-- Display list of ingredients -->
    <h2 class="md:text-2xl text-xl font-semibold md:mt-20 my-4 px-2 py-4 border-b-2 border-b-[--primary]">Ingredients:</h2>
    <ul class="px-4 mx-4 list-disc">
        @foreach(json_decode($recipe->ingredients,true) as $ingredient)
            <li>
                {{ $ingredient['item'] }}
            </li>
        @endforeach
    </ul type="disc">
    
    <!-- Display for recommendations-->
    <h2 class="md:text-2xl text-xl font-semibold md:mt-4 my-4 px-2 py-4 border-b-2 border-b-[--primary]">More like this</h2>
    <x-recommendations :recommendations="$recommendations"></x-recommendations>
</div>
<style>
    #customlist {
        /* delete default counter */
        list-style-type: none;
        /* create custom counter and set it to 0 */
        counter-reset: elementcounter;
    }

    #customlist>li:before {
        /* print out "Element " followed by the current counter value */
        /* content: "Step " counter(elementcounter); */
        /* increment counter */
        counter-increment: elementcounter;
        font-weight: bold;
        display: block;
        font-size:1.2rem;
    }
</style>
@push('script')
    <script src="{{ Storage::url('assets/js/delete_confirmation.js') }}" defer></script>
@endpush
