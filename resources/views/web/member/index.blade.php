<x-app-layout>
    <div class="min-h-[85vh] mx-auto py-4 px-4 max-w-7xl">
        <div class="flex space-x-1">
            <a href="{{route('member')}}?tab=all" onclick="display('all')" class="items-center border rounded-full {{$currentTab == 'all' ? 'border-[--primary] bg-[--primary] text-white font-semibold' : 'border-[--secondary] hover:bg-[--secondary] hover:text-white font-semibold' }}">
                <h1 class="text-1xl py-2 px-4">All Recipe</h1>
            </a>
            <a href="{{route('member')}}?tab=following" onclick="display('following')" class="items-center border rounded-full {{$currentTab == 'following' ? 'border-[--primary] bg-[--primary] text-white font-semibold' : 'border-[--secondary] hover:bg-[--secondary] hover:text-white font-semibold' }}">
                <h1 class="text-1xl py-2 px-4">Following</h1>
            </a>
        </div>
        @if($currentTab == "all")
            <div class="flex mt-4 flex-wrap md:justify-start justify-center" id="all">
                @if($items->count() > 0)
                    @foreach($items as $item) 
                        <x-card-recipe class="flex flex-col bg-cover rounded-md md:w-[33%] w-full md:h-[240px] min-h-[300px] items-center shadow-md bg-blend-overlay md:py-2 py-4 bg-center m-[1px]" style="background-image: url('{{ Storage::url($item->thumbnail)}}');" :item="$item"></x-card-recipe>
                    @endforeach 
                @else
                    <p class="text-[--secondary] text-md p-4">No recipe yet.</p>
                @endif
            </div>
            <div class="px-4 my-4 w-full">{{ $items->links() }}</div>
        @else
            <div class="flex mt-4 flex-wrap md:justify-start justify-center" id="following">
            @if($items->count() > 0)
                    @foreach($items as $item) 
                        <x-card-recipe class="flex flex-col bg-cover rounded-md md:w-[33%] w-full md:h-[240px] min-h-[300px] items-center shadow-md bg-blend-overlay md:py-2 py-4 bg-center m-[1px]" style="background-image: url('{{ Storage::url($item->thumbnail)}}');" :item="$item"></x-card-recipe>
                    @endforeach 
                @else
                    <p class="text-[--secondary] text-md p-4">No recipe yet.</p>
                @endif
            </div>
            <div class="px-4 my-4 w-full">{{ $items->links() }}</div>
        @endif
    </div>
</x-app-layout>

