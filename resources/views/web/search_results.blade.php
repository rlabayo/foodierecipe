<x-app-layout>
    <div class="min-h-[85vh] mx-auto py-4 px-4">
        <h1 class="text-[--secondary] text-2xl font-semibold px-4">Search Results</h1>
        <div class="flex mt-4 flex-wrap justify-start px-1">
            @if($items->count() > 0)
                @foreach($items as $item) 
                    <x-card-recipe class="flex flex-col bg-cover rounded-xl md:w-[33%] w-full md:h-[240px] min-h-[300px] items-center shadow-md bg-blend-overlay md:pt-2 pt-4 bg-center m-[1px]" style="background-image: url('{{ Storage::url($item->thumbnail)}}');" pageName="recipe" :item="$item"></x-card-recipe>
                @endforeach
            @else
                <p class="text-[--secondary] text-sm px-4">No results found.</p>
            @endif
        </div>
        <div class="px-4 my-4 w-full">{{ $items->links() }}</div>
    </div>
    <!-- @include('layouts.footer') -->
</x-app-layout>
