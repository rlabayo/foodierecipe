<x-app-layout>
    <div class="min-h-[85vh] mx-auto py-4 px-4 max-w-7xl">
        <h1 class="text-[--secondary] text-2xl font-semibold px-4">Shared Public Recipe</h1>
        <div class="flex mt-4 flex-wrap  md:justify-start justify-center px-1">
            @foreach($items as $item)
                <x-card-recipe class="flex flex-col bg-cover rounded-sm md:w-[33%] w-full md:h-[240px] min-h-[300px] items-center shadow-md bg-blend-overlay md:py-2 py-4 bg-center m-[1px]" style="background-image: url('{{ Storage::url($item->thumbnail)}}');" style="background-image: url('{{ Storage::url($item->thumbnail)}}');" :item="$item"></x-card-recipe>
            @endforeach
        </div>
        <div class="px-4 my-4">{{ $items->links() }}</div>
    </div>
</x-app-layout>