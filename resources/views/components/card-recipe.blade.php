@php
    $display_route_to = ($pageName == 'guest') ? route('guest.show', $item->id) : route('recipe.show', $item->id);
@endphp

<div {{ $attributes->merge(['class' => 'py-2']) }} > 
    <div class="w-full flex justify-around items-center h-[10%] md:mt-2 mt-2">
        <div class="mr-auto ml-4">
            @if($pageName == 'recipe' || $pageName == 'guest') 
                <a href="{{ route('profile.show', $item->user_id) }}" alt="{{ $item->user_id }}">
                    <img src="{{Storage::url('')}}{{$item->profile_image}}" alt="{{ $item->profile_image }}"  class="rounded-full md:h-[50px] h-[30px] md:w-[50px] w-[30px]" />
                </a>
            @endif
        </div>
        <div class="flex flex-row justify-between items-center space-x-1 ml-auto mr-2">
            @if($pageName == 'guest')
                <div class="ml-auto mr-2">
                    <a href="{{ route('guest.show', $item->id) }}">
                        <x-view-logo></x-view-logo>
                    </a>
                </div>
            @else
                <div>
                    <a href="{{ route('recipe.show', $item->id) }}" alt="View Recipe" class="block">
                        <x-view-logo></x-view-logo>
                    </a>
                </div>
            @endif

    @if(Auth::check())
        @if($item->user_id != auth()->user()->id) 
            @if($item->is_favorite == '1' && $item->favorite_by == auth()->user()->id)
                <div>
                    <a href="{{ route('favorite.remove', $item->favorite_id) }}" class="block">
                        <x-remove-logo></x-remove-logo>
                    </a>
                </div>
            @else
                <div>
                    <a href="{{ route('favorite.add', $item->id) }}" class="block">
                        <x-add-logo></x-add-logo>
                    </a>
                </div>
            @endif
        @endif
        
        @if($pageName == 'profile' && $item->user_id == auth()->user()->id)
            <div>
                <a href="{{ route('recipe.edit', $item->id) }}" class="block">
                    <x-edit-logo></x-edit-logo>
                </a>
            </div>
            <div>
                <form action="{{ route('recipe.delete', $item->id) }}" method="POST" class="delete_form">
                    @csrf
                    @method('delete')
                    <x-trash-icon type="submit" class="block" ></x-trash-icon>
                </form>
            </div>
        @endif
    @endif
        </div>
    </div>
     
    <div class="cursor-pointer my-auto w-full text-center min-h-min">
        <a href="{{ $display_route_to }}" alt="{{ $item->title }}" class="w-full shadow-md">   
            <h1 class="text-white md:text-lg text-sm font-[600] leading-4 bg-[#ffe6da]/60 px-4 py-3 rounded-sm hover:bg-[#ffe6da] hover:text-[--primary] shadow-lg ring-lg">
            {{ $item->title }} 
            </h1>
        </a>
    </div>
</div>
