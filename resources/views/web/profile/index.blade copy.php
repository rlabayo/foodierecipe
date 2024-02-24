<x-app-layout>
    <div x-data="{ recipes: true, favorites: false }">
        <div class="max-w-7xl mx-auto pt-10 pb-4 px-4 sm:px-6 lg:px-8">
            @if($profile->image != 'default_profile.svg')
                <img src="{{Storage::url('assets/images/')}}{{$profile->image}}" alt="" class="rounded-full mx-auto" width="100" height="100" />
            @else
                <img src="{{Storage::url('assets/images/')}}{{$profile->image}}" alt="" class="rounded-full mx-auto" width="100" height="100" />
            @endif
            <h1 class="text-[--secondary] md:text-2xl text-xl font-semibold text-center mt-3">{{ $user->name }}</h1>
            <p class="text-center md:text-lg text-sm text-[--secondary] mt-2">{{ $profile->description }}</p>
            <div class="flex mt-4 flex-wrap md:gap-6 gap-0 justify-center p-4">
                <div class="flex flex-col text-center md:w-1/4 w-1/2">
                    <p class="font-bold md:text-lg text-sm">{{ $recipes->count() }}</p>
                    <a href="#posts" class="md:text-lg text-sm text-[--secondary] cursor-pointer" x-on:click="recipes = true, favorites = false" >Posts</a>
                </div>
                <div class="flex flex-col text-center md:w-1/4 w-1/2">
                    <p class="font-bold  md:text-lg text-sm">{{ $favorites->count() }}</p>
                    <a href="#favorites" alt="Favorites" x-on:click="favorites = true, recipes = false" class="md:text-lg text-sm text-[--secondary]">Favorites</a>
                </div>
            </div>
            <div class="flex flex-row justify-center gap-4">
                <a href="{{ route('recipe.create') }}" class="px-4 md:text-lg text-sm text-white font-bold text-center py-2 rounded-md md:w-1/4 w-1/2 shadow-[0px_1px_0px_0px_#FFF]" style="background: conic-gradient(from 180deg at 50% 100%, #FFAF87 0deg, #FFC3A4 343.25260877609253deg, #FFCFB6 359.92798805236816deg, #FFDCCB 359.9639940261841deg);">Add Recipe</a>
                <a href="{{ route('profile.edit') }}" class="px-4 md:text-lg text-sm text-white font-bold text-center py-2 rounded-md md:w-1/4 w-1/2 shadow-[0px_1px_0px_0px_#FFF]" style="background: conic-gradient(from 180deg at 50% 100%, #FFAF87 0deg, #FFC3A4 343.25260877609253deg, #FFCFB6 359.92798805236816deg, #FFDCCB 359.9639940261841deg);">Edit Profile</a>
            </div>
        </div>
        <div x-show="recipes" class=" flex mt-4 flex-wrap md:gap-2 gap-[.1rem] md:justify-center justify-between md:p-4 p-0">
            @foreach($recipes as $recipe)
                <div class="bg-cover rounded-sm w-full md:max-w-[30%] max-w-[33%] md:h-[300px] min-h-[150px] flex flex-col items-center shadow-lg bg-blend-overlay bg-[--img-overlay/50]" style="background-image: url('{{ $recipe->attachment}}')">
                    <div class="flex justify-between gap-1 ml-auto mr-2 mt-4">
                        <div>
                            <a href="{{ route('recipe.show', $recipe->id) }}">
                                <img src="{{ Storage::url('assets/images/see.png') }}" alt="View recipe" class="rounded-full" width="25" height="25" >
                            </a>
                        </div>
                        <div>
                            <a href="{{ route('recipe.edit', $recipe->id) }}">
                                <img src="{{ Storage::url('assets/images/Edit.png') }}" alt="Add favorite" class="rounded-full" width="25" height="25" >
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div x-show="favorites" class=" flex mt-4 flex-wrap md:gap-2 gap-[.1rem] md:justify-center justify-between md:p-4 p-0">
            @foreach($favorites as $favorite) {{$favorite->is_favorite}}
                <div class="bg-cover rounded-sm w-full md:max-w-[30%] max-w-[33%] md:h-[300px] min-h-[150px] flex flex-col items-center shadow-lg bg-blend-overlay bg-[--img-overlay/50]" style="background-image: url('{{ $favorite->attachment}}')">
                    <div class="flex justify-between gap-1 ml-auto mr-2 mt-4">
                        <div>
                            <a href="{{ route('recipe.show', $favorite->id) }}">
                                <img src="{{ Storage::url('assets/images/see.png') }}" alt="View recipe" class="rounded-full" width="25" height="25" >
                            </a>
                        </div>
                        <div>
                            <a href="{{ route('favorite.remove', $favorite->favorite_id) }}">
                                <img src="{{ Storage::url('assets/images/Remove.png') }}" alt="Add favorite" class="rounded-full" width="25" height="25" >
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>