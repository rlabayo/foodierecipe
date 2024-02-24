<x-app-layout>
    <div class="grid bg-cover bg-center" style="background-image: url('{{ Storage::url($recipe->image)}}'); height:500px;">
        <div class="flex flex-row justify-between px-4 mt-4">
            <div>
                <a href="{{ URL::previous() }}">
                    <img src="{{ Storage::url('assets/images/Back.png') }}" alt="Back" width="30" height="30" />
                </a>
            </div>
            @auth
                <div>
                    @if($recipe->is_favorite == '1')
                        <a href="{{ route('favorite.remove', $recipe->favorite_id) }}">
                            <img src="{{ Storage::url('assets/images/Remove.png') }}" alt="Add favorite" class="rounded-full" width="25" height="25" >
                        </a>
                    @elseif($recipe->is_favorite == '0' && $recipe->user_id != auth()->user()->id)
                        <a href="{{ route('favorite.add', $recipe->id) }}">
                            <img src="{{ Storage::url('assets/images/Add.png') }}" alt="Add favorite" class="rounded-full" width="25" height="25" >
                        </a>
                    @endif

                    @if($recipe->user_id == auth()->user()->id)
                        <a href="{{ route('recipe.edit', $recipe->id) }}">
                            <img src="{{ Storage::url('assets/images/Edit.png') }}" alt="Edit Recipe" class="rounded-full" width="25" height="25" >
                        </a>
                    @endif
                </div>
            @endauth
        </div>
        @if($recipe->video_url != '')
            <div class="mx-auto mt-auto">
                <a href="{{ $recipe->video_url }}" target="__blank" class="px-12 py-2 bg-[--primary] rounded shadow-lg text-white font-semibold">Watch Video</a>
            </div>
        @endif
    </div>
    <div class="flex flex-col md:w-2/3 w-full mx-auto mt-10 md:px-10 px-4 text-[--secondary] mb-10">
        <h1 class="text-[--text-secondary] text-[48px] text-center font-semibold leading-normal">
            {{ $recipe->title }}
        </h1>
        <p class="text-[--text-secondary] text-md text-center font-[300] leading-normal">
            {{ $recipe->summary }}
        </p>
        <div class="md:ml-auto md:mr-2 mt-4">
            <select name="unit" id="unit" class="rounded border-[--primary] text-[--primary] font-semibold accent-cyan-600">
                <option value="">Select Unit</option>
                @foreach($unit as $item_unit)
                    <option value="{{$item_unit}}">{{$item_unit}}</option>
                @endforeach
            </select>
        </div>
        <div class="mt-4">
            <h2 class="font-semibold">Ingredients:</h2>
            <p class="text-md text-wrap">
                {{ $recipe->ingredients }}
            </p>
        </div>
        <div class="mt-4">
            <h2 class="font-semibold">Process:</h2>
            <p class="text-md">
                {{ $recipe->instruction }}
            </p>
        </div>
    </div>
    @include('layouts.footer')
</x-app-layout>