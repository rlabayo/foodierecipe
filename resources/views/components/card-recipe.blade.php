<div {{ $attributes->merge(['class' => 'bg-[#faf7f526]/10 hover:bg-[#faf7f526]/30 hover:text-gray-800 hover:font-bold ']) }} > 
    <div class="w-full flex justify-around items-center h-[10%] mt-2"> 
        @if(!strpos(parse_url(url()->current(), PHP_URL_PATH), "profile") && !strpos(parse_url(url()->current(), PHP_URL_PATH), "drafts"))
        <div class="mr-auto ml-4">
            <a href="{{ route('profile.show', Crypt::encrypt($item->user_id)) }}" alt="{{ $item->user_name }}">
                <x-profile-image src="{{Storage::url('')}}{{$item->profile_image}}" alt="{{ $item->user_name }}" class="h-[50px] w-[50px]" ></x-profile-image>
            </a>
        </div>
        @endif
        <div class="flex flex-row justify-between items-center space-x-1 ml-auto mr-2">
            @guest
                <div class="ml-auto mr-2">
                    <a href="{{ route('guest.show', Crypt::encrypt($item->id)) }}">
                        @if($item->private == 1)
                            <x-private-logo></x-private-logo>
                        @else 
                            <x-view-logo></x-view-logo>
                        @endif
                    </a>
                </div>
            @endguest
                
            @auth
                <div>
                    <a href="{{ route('recipe.show', Crypt::encrypt($item->id)) }}" alt="View Recipe" class="block">
                        <x-view-logo></x-view-logo>
                    </a>
                </div>
            @endauth
            
            @auth
                @if($item->user_id != auth()->user()->id) 
                    @if($item->is_favorite == '1')
                        <div class="ml-auto">
                            <a href="{{ route('favorite.remove', Crypt::encrypt($item->favorite_id)) }}"  alt="Remove favorite button" class="flex items-center justify-center font-bold">
                                <x-unfavorite></x-unfavorite>
                            </a>
                        </div>
                    @elseif($item->is_favorite == 0)
                        <div class="ml-auto">
                            <a href="{{ route('favorite.add', Crypt::encrypt($item->id)) }}"  alt="Add favorite button" class="flex items-center justify-center font-bold">
                                <x-favorite></x-favorite>
                            </a>
                        </div>
                    @endif
                @endif
                
                @if($item->user_id == auth()->user()->id)
                    <div>
                        <a href="{{ route('recipe.edit', Crypt::encrypt($item->id)) }}" class="block">
                            <x-edit-logo></x-edit-logo>
                        </a>
                    </div>
                    <div id="delete_{{$item->id}}">
                        <form action="{{ route('recipe.delete', Crypt::encrypt($item->id)) }}" method="POST" class="delete_form">
                            @csrf
                            @method('delete')
                            <x-trash-icon type="submit" class="block" ></x-trash-icon>
                        </form> 
                    </div>
                @endif
            @endauth
        </div>
    </div>
    @guest
        <a href="{{route('guest.show', Crypt::encrypt($item->id))}}" alt="{{ $item->title }}" class="w-full md:mt-auto my-auto text-center items-center text-wrap">   
            <h1 class="text-white md:text-3xl text-2xl leading-auto min-h-20 px-4 py-3 rounded-sm font-semibold hover:text-gray-800 hover:font-bold">
            {{ $item->title }} 
            </h1>
        </a>
    @endguest

    @auth
        <a href="{{ route('recipe.show', Crypt::encrypt($item->id)) }}" alt="{{ $item->title }}" class="w-full md:mt-auto my-auto text-center items-center text-wrap">   
            <h1 class="text-white md:text-3xl text-2xl leading-auto min-h-20 px-4 py-3 rounded-sm font-semibold hover:text-gray-800 hover:font-bold">
            {{ $item->title }} 
            </h1>
        </a> 
    @endauth
</div>
